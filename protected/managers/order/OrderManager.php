<?php

Yii::import('managers.SaveResult');
Yii::import('managers.SearchCriteria');
Yii::import('helpers.DateFormatHelper');
Yii::import('helpers.TimeFormatHelper');
Yii::import('helpers.DateTimeFormatHelper');
Yii::import('helpers.ConvertHelper');
Yii::import('utils.Application');

require_once 'OrderAttributes.php';
require_once 'OrderValidationResult.php';
require_once 'MakeNewOrderResult.php';

class OrderManager {
    
    public function __construct() {
        
    }
    
    public function getOrderById($id) {
        $model = Order::model()->findByPk($id);
        if ($model === null) {
            throw new RowIsNotExistsException();
        }
        return $model;
    }
    
    public function getOrderWithSpecializationAndDoctorById($id) {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'specialization' => array(
                'alias' => 's'
            ),
            'doctor' => array(
                'select' => 'id, firstname, surname, patronymic, additional, speciality, enabled',
                'alias' => 'd'
            )
        );
        $criteria->alias = 'o';

        $model = Order::model()->findByPk($id, $criteria);
        if ($model === null) {
            throw new RowIsNotExistsException();
        }
        return $model;
        
    }
    
    public function createOrder($attributes) {
        $model = new Order();
  
        //Иначе попробуем её сохранить.
        try {
            $this->saveOrder($model, $attributes);
            return new SaveResult($model, true);
        }
        catch (Exception $e) {
            return new SaveResult($model, false);
        }
    }
    
    public function updateOrderByModel($model, $attributes) {
        try {
            $this->saveOrder($model, $attributes);
            return new SaveResult($model, true);
        }
        catch (Exception $e) {
            return new SaveResult($model, false);
        }  
    }
    
    public function deleteOrderById($id) {
        $t = Yii::app()->db->beginTransaction();
        try {
            Order::model()->deleteByPk($id);
            $t->commit();
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        } 
    }
    
    // Удаляет заказы с orderDateTime из интервала [$beginDate, $endDate].
    // $begin и $endDate - объекты DateTime. Причём время, если он задано 
    // в этих объектах, не учитвается. Берётся 00:00:00 для $beginDate
    // и 23:59:59 для $endDate. Т.е начальная и конечная дата входят в интервал полностью.
    // $processed и $state, если они не равны null, позволяют удалять заказы 
    // только с определённым значением processed и state.
    public function deleteOrders($beginDate, $endDate, $processed = null, $state = null) {
        $beginDate->setTime(0, 0, 0);
        $endDate->setTime(0, 0, 0);
        // Сдвинем конечную дату на один день вперёд, а в условиях будем 
        // использовать сторого "меньше"(<).  
        $shiftedEndDate = DateFormatHelper::shiftDateForSeveralDays($endDate, 1);
        
        $beginDateDBView = DateTimeFormatHelper::getDateTimeDBView($beginDate);  
        $endDateDBView = DateTimeFormatHelper::getDateTimeDBView($shiftedEndDate);
        
        $criteria = new CDbCriteria();
        $criteria->addCondition("orderDateTime >= '$beginDateDBView' AND orderDateTime < '$endDateDBView'");

        if ($processed !== null) {
            if ($processed) {
                $criteria->addCondition("processed = TRUE", "AND");
            } else {
                $criteria->addCondition("processed = FALSE", "AND");  
            }
        }
        if ($state !== null) {
            $criteria->addCondition("state = '$state'", "AND");
        }
        
        $t = Yii::app()->db->beginTransaction();
        try {
            Order::model()->deleteAll($criteria);
            $t->commit();
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        } 
    }
    
    // Создаёт новый заказ, у которого время равно текущему. 
    // Он становится неоьработанным и с неопредейлённым состоянием.
    // $orderAttributes - объект для заполнения модели Order. Однако не все его
    // имена и типы полей соответствуют именам и типам полей модели Order.
    // Некоторых полей, которые есть в модели Order, в нём нет. 
    public function createNewOrder($orderAttributes, $phonePattern = null, $isNeedMakeTimeBusy = true) 
    {
        $idSpecialization = $orderAttributes->idSpecialization; 
        $idDoctor = $orderAttributes->idDoctor; 
        $date = $orderAttributes->date; 
        $timeShortTextView = $orderAttributes->timeShortTextView;
        
        $model = $this->createModelForNewOrderOnAttributes($orderAttributes);
        
        // Провалидируем модель.
        $orderValidationResult = $this->validateModelForMakeNewOrder($model, $phonePattern); 
        
        // Если были ошибки, то сразу вернём результат.
        if ($orderValidationResult->hasErrors) {
            return new MakeNewOrderResult($model, $orderValidationResult, false);
        }
        
        $t = Yii::app()->db->beginTransaction();
        try {     
            if (!$model->save(false) ) {
                $orderValidationResult->setDefaultCommonError();
                $t->rollback();
                // Если не удалось сохранить заявку, то вернём результат.
                return new MakeNewOrderResult($model, $orderValidationResult, false);
            }
            
            if ($isNeedMakeTimeBusy) {
                // Попытаемся сделать время занятым.
                $isSuccess = $this->makeTimeBusy($idSpecialization, $idDoctor, $date, $timeShortTextView);
                if (!$isSuccess) { 
                    // Если не получилось, выясним почему и добавим эту информацию в сообщенния об ошибке.
                    $timeState = $this->getTimeState($idSpecialization, $idDoctor, $date, $timeShortTextView);
                    if ($timeState !== WorkTime::STATE_FREE) {
                        $t->rollback();
                        $orderValidationResult->setErrorOnTimeStateIfNeed($timeState);
                        return new MakeNewOrderResult($model, $orderValidationResult, false);
                    } else {
                        throw new ModifyDBException();
                    }
                }
            } else {
                // Время занимать не нужно - проверим его состояние.
                $timeState = $this->getTimeState($idSpecialization, $idDoctor, $date, $timeShortTextView);
                if ($timeState !== WorkTime::STATE_FREE) {
                    // Если время не свободно, то добавим информацию о его
                    // состоянии в сообщенния об ошибке.
                    $t->rollback();
                    $orderValidationResult->setErrorOnTimeStateIfNeed($timeState);
                    return new MakeNewOrderResult($model, $orderValidationResult, false);
                }
            }
            
            $t->commit(); 
            // Всё успешно - возврщаем результат.
            return new MakeNewOrderResult($model, $orderValidationResult, true);
        } 
        catch(Exception $e) {
            $t->rollback();
            $orderValidationResult->setDefaultCommonError();
            return new MakeNewOrderResult($model, $orderValidationResult, false);
        }  
    }
        
    
    public function validateOrderAttributesForMakeNewOrder($orderAttributes, $phonePattern = null) {
        $model = $this->createModelForNewOrderOnAttributes($orderAttributes);
        $orderValidationResult = $this->validateModelForMakeNewOrder($model, $phonePattern);
        
        // Если никаких ошибок не найдено, то дополнительно 
        // проверим состояние времени на которое будет идти заявка.
        if (!$orderValidationResult->hasErrors) {
            $timeState = $this->getTimeState(
                $orderAttributes->idSpecialization, 
                $orderAttributes->idDoctor, 
                $orderAttributes->date, 
                $orderAttributes->timeShortTextView
            );
            if ($timeState !== WorkTime::STATE_FREE) {
                $orderValidationResult->setErrorOnTimeStateIfNeed($timeState);
            }
        }
        
        return $orderValidationResult;
    }
   
   
    
    private function isAttributeEmpty($attribute) {
        return $attribute === '';
    }
          
    private function validateModelForMakeNewOrder($model, $phonePattern = null) {
        $orderValidationResult = new OrderValidationResult();
       
        $phonePatternValid = null;
        $phonePatternIsEmpty = ($phonePattern === null) || ($phonePattern === '');
        if (!$phonePatternIsEmpty) {
           $phonePatternValid = preg_match($phonePattern, $model->phone);
            if (!$phonePatternValid) {
                $orderValidationResult->setPhoneIsNotCorrectError();
            }
        } else {
            $phonePatternValid = true;
        }
        
        $model->validate();
        if ($model->hasErrors() ) {
            if ($model->hasErrors('firstname') ) {
                $orderValidationResult->setFirstnameError($model->getError('firstname') );
            }
            if ($model->hasErrors('surname') ) {
                $orderValidationResult->setSurnameError($model->getError('surname') );
            }
            if ($model->hasErrors('patronymic') ) {
                $orderValidationResult->setPatronymicError($model->getError('patronymic') );
            }
            if ($model->hasErrors('phone') ) {
                // Добавим ошибку связанную с телефоном, только
                // если она ещё не установлена - телефон соответствует шаблону (или 
                // он(шаблон) не задан в настройках.
                if ($phonePatternValid) {
                    $orderValidationResult->setPhoneError($model->getError('phone') );
                }
            }
            
            // Ошибки не установлены, но модель валидацию не прошла.
            // Значит ошибки есть в других полях модели - установим общую ошибку.
            if (!$orderValidationResult->hasErrors) {
                $orderValidationResult->setDefaultCommonError();
            }
        }
        
        return $orderValidationResult;
    }

    // Возвращает состояние времени для заказа. null - в случае если такого времени не найдено.
    private function getTimeState($idSpecilization, $idDoctor, $date, $timeShortTextView) {
        $dateDBView = DateFormatHelper::getDateDBView($date);
        if ($idDoctor === null) {
            $doctorCondition = "wd.idDoctor is NULL";
        } else {
            $doctorCondition = "wd.idDoctor = $idDoctor";
        }
        $timeDBView = TimeFormatHelper::timeShortTextViewToTimeDBView($timeShortTextView);
        
        
        $sql = 
            "SELECT wt.* FROM {{workDay}} AS wd INNER JOIN {{workTime}} AS wt ON wd.id = wt.idWorkDay AND ".
            " wd.idSpecialization = $idSpecilization AND $doctorCondition AND ".
            " wd.date = '$dateDBView' AND wt.time = '$timeDBView'";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        $row = $dataReader->read();
        if ($row === false) {
            return null;
        } else {
            return $row['state'];
        }
    }
    
    private function makeTimeBusy($idSpecilization, $idDoctor, $date, $timeShortTextView) {
        $dateDBView = DateFormatHelper::getDateDBView($date);
        if ($idDoctor === null) {
            $doctorCondition = "wd.idDoctor is NULL";
        } else {
            $doctorCondition = "wd.idDoctor = $idDoctor";
        }
        $timeDBView = TimeFormatHelper::timeShortTextViewToTimeDBView($timeShortTextView);
        
        $freeState = WorkTime::STATE_FREE;
        $busyState = WorkTime::STATE_BUSY;
        
        $sql = 
            "UPDATE {{workTime}} AS wt INNER JOIN {{workDay}} AS wd ON wd.id = wt.idWorkDay AND ".
            "wd.idSpecialization = $idSpecilization AND $doctorCondition AND ".
            "wd.date = '$dateDBView' AND wt.time = '$timeDBView' AND wd.published = TRUE AND ".
            "wt.state = '$freeState' ".
            "SET wt.state = '$busyState' ";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $numberOfModifiedRows = $command->execute();
        
        if ($numberOfModifiedRows === 0) {
            return false;
        } else if ($numberOfModifiedRows === 1) {
            return true;
        } else {
            throw new ModifyDBException();
        }
    }
    
    private function createModelForNewOrderOnAttributes($orderAttributes) {
        // Эти атрибуты при создании новой модели во внешней функции не заполняются,
        // поэтому заполним их в соответствии  с необходимым состоянием нового заказа.
        $orderAttributes->orderDateTime = Application::getInstance()->getCurrentDateTime();
        $orderAttributes->processed = false;
        $orderAttributes->state = Order::STATE_NOT_DEFINED;
        
        return $this->createModelOnOrderAttributes($orderAttributes);
    }
    
    private function createModelOnOrderAttributes($orderAttributes) {
        $model = new Order();
        $model->idSpecialization = $orderAttributes->idSpecialization;
        $model->idDoctor = $orderAttributes->idDoctor;
        $model->date = DateFormatHelper::getDateDBView($orderAttributes->date);
        $model->time = TimeFormatHelper::timeShortTextViewToTimeDBView($orderAttributes->timeShortTextView);
        $model->firstname = $orderAttributes->firstname;
        $model->surname = $orderAttributes->surname;
        $model->patronymic = $orderAttributes->patronymic;
        $model->phone = $orderAttributes->phone;
        $model->orderDateTime = DateTimeFormatHelper::getDateTimeDBView($orderAttributes->orderDateTime);
        $model->processed = ConvertHelper::booleanToOneOrZero($orderAttributes->processed);
        $model->state = $orderAttributes->state;
        
        return $model;
    }
    
    
    // $attributes - поля формы, но не все они совпадают с тем значением,
    // которое будет сохранятся в базе данных. Например даты 
    // вводятся в другом формате. $attributes не тоже самое, что $orderAttributes.
    private function saveOrder($model, $attributes) {
        // Поля с датами и временем нужно перед валидацией сконвертировать в
        // формат в котором они храняться в базе данных. Однако перед этим 
        // проверяется введены ли они в правильном 
        // формате - нет ли там 30-го февраля и т.д. Если это не так, то 
        // в модель будет устанвалена ошибка после проведения валидации.  
        // Этот атрубут из валидации исключается.
        // Применяется для date, time и orderDateTime.
        
        $hasErrorsBeforeValidate = false;
        $isDateCorrect = true;
        $isTimeCorrect = true;
        $isOrderDateTimeCorrect = true;
        
        $model->attributes = $attributes;
        if ($attributes['idDoctor'] === '') {
            $model->idDoctor = null;
        } else {
            $model->idDoctor = $attributes['idDoctor'];
            
        }
       
        $dateText = $attributes['date'];
        if (!$this->isAttributeEmpty($dateText) ) {
            if (!DateFormatHelper::checkDateInCommonTextView($dateText) ) {
                $isDateCorrect = false;
                $hasErrorsBeforeValidate = true;
            } else {
                $model->date = DateFormatHelper::dateCommonTextViewToDateDBView($dateText);
            }
        } 
        
        $timeText = $attributes['time'];
        if (!$this->isAttributeEmpty($timeText) ) {
            if (!TimeFormatHelper::checkTimeInShortTextView($timeText) ) {
                $isTimeCorrect = false;
                $hasErrorsBeforeValidate = true;
            } else {
                $model->time = TimeFormatHelper::timeShortTextViewToTimeDBView($timeText);
            }
        }
        
        $orderDateTime = $attributes['orderDateTime'];
        if (!$this->isAttributeEmpty($orderDateTime) ) {
            if (!DateTimeFormatHelper::checkDateTimeInCommonTextView($orderDateTime) ) {
                $isOrderDateTimeCorrect = false;
                $hasErrorsBeforeValidate = true;
            } else {
                $model->orderDateTime = DateTimeFormatHelper::dateTimeCommonTextViewToDateDBView($orderDateTime);
            }
        } 
        
        // Если уже были найдены ошибки, то просто провалидируем остальные поля модели.
        if ($hasErrorsBeforeValidate) {
            $attributesToValidate = array(
                'idSpecialization',
                'idDoctor',
                'firstname',
                'surname',
                'patronymic',
                'phone',
                'processed',
                'state'
            );
            
            // Добавим атрибуты которые пока корректны.
            if ($isDateCorrect) {
                $attributesToValidate []= 'date';
            }
            if ($isTimeCorrect) {
                $attributesToValidate []= 'time';
            }
            if ($isOrderDateTimeCorrect) {
                $attributesToValidate []= 'orderDateTime';
            }
            
            $model->validate($attributesToValidate);
            
            // Добавим ошибки которые были найдены до валидации(валидации для этих полей не проводилась).
            if (!$isDateCorrect) {
                $model->addError('date', OrderConst::DATE_IS_NOT_CORRECT_MSG);
            }
            if (!$isTimeCorrect) {
                $model->addError('time', OrderConst::TIME_IS_NOT_CORRECT_MSG);
            }
            if (!$isOrderDateTimeCorrect) {
                $model->addError('orderDateTime', OrderConst::ORDER_DATE_TIME_IS_NOT_CORRECT_MSG);
            }
           
            throw new ModifyDBException();
        }
        
        
        $t = Yii::app()->db->beginTransaction();
        try { 
            if (!$model->save() ) {
                throw new ModifyDBException();
            }
            $t->commit(); 
        } 
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        }     
    }
     
}
