<?php

Yii::import('managers.SaveResult');
Yii::import('helpers.DateFormatHelper');
Yii::import('helpers.ConvertHelper');

class ScheduleManager {
   
    const TIME_INVALID_ARGUMENST_EXCEPTION_MESSAGE = 'Аргументы $time и $timeStates используются совместно. Поэтому они должны быть либо оба заданы(не null), либо оба не заданы(по умолчанию им будет присвоено null).';
    
    public function __construct() {
    
    }
    
    // Функции getBasisFor* возвращают данные(группы, специализации, врачей) для основы расписания. 
    ////////////////////////////////////////////////////////////////////////////
    
    // Возвращает основу для общего расписания
    public function getBasisForCommonSchedule() {
        $criteria = new CDbCriteria();
        $criteria->select = 'id, name';
        $criteria->order = 'g.name ASC';
        $criteria->alias = 'g';
        $criteria->with = array(
            'specializations' => array(
                'select' => 'id, name, additional, needDoctor',
                'alias' => 's',
                'order' => 's.name ASC',
                'joinType' => 'INNER JOIN',
                'with' => array(
                    'doctors' => array(
                        'select' => 'id, firstname, surname, patronymic, additional',
                        'order' => 'd.surname ASC, d.firstname ASC, d.patronymic ASC',
                        'alias' => 'd',
                        'on' => 'g.enabled = TRUE AND s.enabled = TRUE AND s.recordOnTime = TRUE AND (d.enabled = TRUE OR s.needDoctor = FALSE)',
                    ),
                ),
            ),  
        );
        $criteria->condition =  '(d.id IS NOT NULL) OR (s.needDoctor = FALSE)';
        
        $basis = Group::model()->findAll($criteria);
        return $basis;
    }
    
    // Возвращает основу для расписания группы
    public function getBasisForGroupSchedule($idGroup) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id, name';
        $criteria->order = 'g.name ASC';
        $criteria->alias = 'g';
        $criteria->with = array(
            'specializations' => array(
                'select' => 'id, name, additional, needDoctor',
                'alias' => 's',
                'order' => 's.name ASC',
                'joinType' => 'INNER JOIN',
                'on' => "g.id = $idGroup",
                'with' => array(
                    'doctors' => array(
                        'select' => 'id, firstname, surname, patronymic, additional',
                        'order' => 'd.surname ASC, d.firstname ASC, d.patronymic ASC',
                        'alias' => 'd',
                        'on' => 's.enabled = TRUE AND s.recordOnTime = TRUE AND (d.enabled = TRUE OR s.needDoctor = FALSE)',
                    ),
                ),
            ),  
        );
        $criteria->condition =  '(d.id IS NOT NULL) OR (s.needDoctor = FALSE)';
        
        $basis = Group::model()->findAll($criteria);
        return $basis;
    }
    
    
    // Возвращает основу для расписания специализации
    public function getBasisForSpecializationSchedule($idSpecialization) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id, name';
        $criteria->order = 'g.name ASC';
        $criteria->alias = 'g';
        $criteria->with = array(
            'specializations' => array(
                'select' => 'id, name, additional, needDoctor',
                'alias' => 's',
                'order' => 's.name ASC',
                'joinType' => 'INNER JOIN',
                'on' => "s.id = $idSpecialization",
                'with' => array(
                    'doctors' => array(
                        'select' => 'id, firstname, surname, patronymic, additional',
                        'order' => 'd.surname ASC, d.firstname ASC, d.patronymic ASC',
                        'alias' => 'd',
                        'on' => 's.recordOnTime = TRUE'
                    ),
                ),
            ),  
        );
        $criteria->condition =  '(d.id IS NOT NULL) OR (s.needDoctor = FALSE)';
        
        $basis = Group::model()->findAll($criteria);
        return $basis;
    }
    
    // Возвращает основу для расписания врачаы
    public function getBasisForDoctorSchedule($idDoctor) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id, name';
        $criteria->order = 'g.name ASC';
        $criteria->alias = 'g';
        $criteria->with = array(
            'specializations' => array(
                'select' => 'id, name, additional, needDoctor',
                'alias' => 's',
                'order' => 's.name ASC',
                'joinType' => 'INNER JOIN',
                'with' => array(
                    'doctors' => array(
                        'select' => 'id, firstname, surname, patronymic, additional',
                        'order' => 'd.surname ASC, d.firstname ASC, d.patronymic ASC',
                        'alias' => 'd',
                        'joinType' => 'INNER JOIN',
                        'on' => "s.recordOnTime = TRUE AND d.id = $idDoctor"
                    ),
                ),
            ),  
        );

        $basis = Group::model()->findAll($criteria);
        return $basis;
    }
    
    // Функции getWorkDaysFor* возвращают расписание - созданные рабочие дни 
    ////////////////////////////////////////////////////////////////////////////
    
    // Возвращает общее расписание
    public function getWorkDaysForCommonSchedule($beginDate, $endDate) {
        return $this->getWorkDaysForSchedule($beginDate, $endDate);
    }
    
    // Возвращает расписание группы
    public function getWorkDaysForGroupSchedule($beginDate, $endDate, $idGroup) {
       // Выбираем рабочие дни только с теми специализациями, которые относятся к данной группе
       $criteria = new CDbCriteria();
       $criteria->select = 'id';
       $criteria->alias = 'g';
       $criteria->with = array(
           'specializations' => array(
               'select' => 'id',
               'alias' => 's',
               'on' => 's.enabled = TRUE AND s.recordOnTime = TRUE'
            ),
        );
        $group = Group::model()->findByPk($idGroup);
        
        $numberOfSpecializations = count($group->specializations);
        if ($numberOfSpecializations  > 0) {
            $ids = array();
            foreach($group->specializations as $s) {
                $ids[] = $s->id;
            }
            return $this->getWorkDaysForSchedule($beginDate, $endDate, 'idSpecialization', $ids);
        } else {
            return $this->getWorkDaysForSchedule($beginDate, $endDate);    
        } 
    }
    
    // Возвращает расписание специализации
    public function getWorkDaysForSpecializationSchedule($beginDate, $endDate, $idSpecialization) {
        return $this->getWorkDaysForSchedule($beginDate, $endDate, 'idSpecialization', $idSpecialization);
    }
    
    // Возвращает расписание врача   
    public function getWorkDaysForDoctorSchedule($beginDate, $endDate, $idDoctor) {
        return $this->getWorkDaysForSchedule($beginDate, $endDate, 'idDoctor', $idDoctor);
    }
    
    public function getWorkDayById($id) {
        $workDay = WorkDay::model()->findByPk($id);
        if($workDay === null) {
            throw new RowIsNotExistsException();
        }
        return $workDay;
    }
    
    public function getWorkDayWithTimeById($id) {
        $criteria = new CDbCriteria();
        $criteria->with = 'time';
        $workDay = WorkDay::model()->findByPk($id, $criteria);
        if($workDay === null) {
            throw new RowIsNotExistsException();
        }
        return $workDay;
    }
    
    public function getWorkDayByAttributes($date, $idSpecialization, $idDoctor) {
        $dateDBView = DateFormatHelper::getDateDBView($date);
        
        $criteria = new CDbCriteria();
        $criteria->addCondition("date = '$dateDBView'", 'AND');
        $criteria->addCondition("idSpecialization = $idSpecialization", 'AND');
        if ($idDoctor === null) {
            $criteria->addCondition("idDoctor is NULL", 'AND');
        } else {
            $criteria->addCondition("idDoctor = $idDoctor", 'AND');
        }

        $workDay = WorkDay::model()->find($criteria);
        if ($workDay === null) {
            throw new RowIsNotExistsException();
        }
        return $workDay;
    }
    
    public function getWorkDayWithTimeByAttributes($date, $idSpecialization, $idDoctor) {
        $dateDBView = DateFormatHelper::getDateDBView($date);
        
        $criteria = new CDbCriteria();
        $criteria->addCondition("wd.date = '$dateDBView'", 'AND');
        $criteria->addCondition("wd.idSpecialization = $idSpecialization", 'AND');
        if ($idDoctor === null) {
            $criteria->addCondition("wd.idDoctor is NULL", 'AND');
        } else {
            $criteria->addCondition("wd.idDoctor = $idDoctor", 'AND');
        }
        $criteria->alias = 'wd';
        
        $criteria->with = array(
            'time' => array(
                'alias' => 'wt'
            )
        );
        
        $workDay = WorkDay::model()->find($criteria);
        if ($workDay === null) {
            throw new RowIsNotExistsException();
        }
        return $workDay;
    }

    public function createWorkDay($date, $idSpecialization, $idDoctor, $published, $time = null, $timeStates = null) {
        $model = $this->createWorkDayModel($date, $idSpecialization, $idDoctor, $published);
        try {
            $this->saveWorkDayModel($model, $time, $timeStates);
            return new SaveResult($model, true);
        }
        catch(Exception $e) {
            return new SaveResult($model, false);
        }
    }
    
    public function updateWorkDayById($idWorkDay, $published,  $time = null, $timeStates = null) {
        $model= $this->getWorkDayById($idWorkDay);
        $model->published = ConvertHelper::booleanToOneOrZero($published);
        try {
            $this->saveWorkDayModel($model, $time, $timeStates);
            return new SaveResult($model, true);
        }
        catch(Exception $e) {
            return new SaveResult($model, false);
        }
    }
    
    public function deleteWorkDays($ids) {
        $t = Yii::app()->db->beginTransaction();
        try {
            foreach ($ids as $id) {
                $this->deleteWorkDayByIdNotTransactional($id);  
            }
            $t->commit();
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        }  
    }
    
    public function deleteWorkDayById($id) { 
        $t = Yii::app()->db->beginTransaction();
        try {
            $this->deleteWorkDayByIdNotTransactional($id);  
            $t->commit();
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        }
    }
    
    public function updatePublishedInWorkDays($ids, $published) {
        $t = Yii::app()->db->beginTransaction();
        try {
            foreach ($ids as $id) {
                $this->updatePublishedInWorkDayByIdNotTransactional($id, $published);  
            }
            $t->commit();
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        }  
    }
    
    public function updatePublishedInWorkDayById($id, $published) {
        $t = Yii::app()->db->beginTransaction();
        try {
            $this->updatePublishedInWorkDayByIdNotTransactional($id, $published);  
            $t->commit();
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        }  
    }
    
    // Применяет шаблон 
    // $idTemplateWorkDay - ключ шаблона(TemplateWorkDay), который нужно применить.
    // $idsWorkDay - массив id существющих рабочих дней, к которым нужно применить шаблон, если === null
    // существующие дни изменятся не будут.
    // $dates, $idsSpecialization, $idsDoctor - массивы содержащие данные для создания новых рабочих дней и применения к ним шаблона
    // т.е будет созданы дни(WorkDay) с ($dates[0], idsSpecialization[0], $idsDoctor[0]), ($dates[1], idsSpecialization[1], $idsDoctor[1]) и т.д
    // Все массивы $dates, $idsSpecialization, $idsDoctor должны быть одинаковой длинны, если хоть один
    // из них не задан(т.е. === null) новые дни создаваться не будут.
    // Возвращает вновь созданные рабочие дни(изменённые не возвращает) - в случае отсутствия  
    // новых дней(шаблон применялся только к существующим) возвращает пустой массив.
    public function actionAcceptTemplateWorkDay($idTemplateWorkDay, $idsWorkDay = null, $dates = null, $idsSpecialization = null, $idsDoctor = null) {     
        // Находим нужный шаблон
        $templateWorkDay = TemplateWorkDay::model()->findByPk($idTemplateWorkDay);
        if ($templateWorkDay === null) {
            throw new RowIsNotExistsException();
        }

        $isNeedCreateNewWorkDays = ($dates !== null) && ($idsSpecialization !== null) && ($idsDoctor !== null);
        $t = Yii::app()->db->beginTransaction();
        try {
            if ($idsWorkDay !== null) {
                // Нужно обновить существующие дни
                foreach($idsWorkDay as $idWorkDay) {
                    WorkDay::acceptTemplateWorkDayById($idWorkDay, $templateWorkDay); 
                }
            }

            // создаём новые дни на основе шаблона
            $createdWorkDays = array();
            if ($isNeedCreateNewWorkDays) {
                for ($i = 0; $i < count($dates); $i++) {
                    $published = false;// Дни которые только создаются не публикуем
                    $workDay = $this->createWorkDayModel($dates[$i], $idsSpecialization[$i], $idsDoctor[$i],  $published);
                    if (!$workDay->save() ) {
                        throw new ModifyDBException();
                    }
                    $workDay->acceptTemplateWorkDay($templateWorkDay);      
                    $createdWorkDays []= $workDay;
                }
            }
            
            $t->commit();
            return $createdWorkDays;
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        }
    }
    
    // Функции deleteFor* удаляют расписание в заданом интервале дат 
    ////////////////////////////////////////////////////////////////////////////
    
    // Удаляет из общего расписания
    public function deleteFromCommonSchedule($beginDate, $endDate) {
        $workDays = $this->getWorkDaysForCommonSchedule($beginDate, $endDate);

        $t = Yii::app()->db->beginTransaction();
        try {
            foreach($workDays as $wd) {
                $this->deleteWorkDayByIdNotTransactional($wd->id);
            }
            $t->commit();
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        }  
    }
    
    // Удаляет из расписания группы
    public function deleteFromGroupSchedule($beginDate, $endDate, $idGroup) {
        $workDays = $this->getWorkDaysForGroupSchedule($beginDate, $endDate, $idGroup);

        $t = Yii::app()->db->beginTransaction();
        try {
            foreach($workDays as $wd) {
                $this->deleteWorkDayByIdNotTransactional($wd->id);
            }
            $t->commit();
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        }     
    }
    
    // Удаляет из расписания специализации
    public function deleteFromSpecializationSchedule($beginDate, $endDate, $idSpecialization) {
        $workDays = $this->getWorkDaysForSpecializationSchedule($beginDate, $endDate, $idSpecialization);

        $t = Yii::app()->db->beginTransaction();
        try {
            foreach($workDays as $wd) {
                $this->deleteWorkDayByIdNotTransactional($wd->id);
            }
            $t->commit();
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        }     
    }
    
    // Удаляет из расписания врача
    public function deleteFromDoctorSchedule($beginDate, $endDate, $idDoctor) {
        $workDays = $this->getWorkDaysForDoctorSchedule($beginDate, $endDate, $idDoctor);

        $t = Yii::app()->db->beginTransaction();
        try {
            foreach($workDays as $wd) {
                $this->deleteWorkDayByIdNotTransactional($wd->id);
            }
            $t->commit();
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        }     
    }
    
    public function updateTimeState($idWorkDay, $timeShortTextView, $state) {
        $t = Yii::app()->db->beginTransaction();
        try {
           $workTime = $this->getWorkTimeByIdWorkDayAndTime($idWorkDay, $timeShortTextView);
           $workTime->state = $state;
           if (!$workTime->save() ) {
               throw new ModifyDBException();
           }
           $t->commit();
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        }
    }
    
    public function deleteTime($idWorkDay, $timeShortTextView) {
        $t = Yii::app()->db->beginTransaction();
        try {
           $workTime = $this->getWorkTimeByIdWorkDayAndTime($idWorkDay, $timeShortTextView);
           if (!$workTime->delete() ) {
               throw new ModifyDBException();
           }
           $t->commit();
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        }
        
    }
      
    // Если $column и $value не пустые к запросу будет добавлено условие $column = $value 
    // или, если $value массив, $coulmn IN ($value[0], $value[1] ... $value[N])
    private function getWorkDaysForSchedule($beginDate, $endDate, $column = '', $value = '') {
        $beginDateDBView = DateFormatHelper::getDateDBView($beginDate);
        $endDateDBView = DateFormatHelper::getDateDBView($endDate);
        
        $criteria = new CDbCriteria();
        $criteria->addCondition("date >= '$beginDateDBView' AND date <= '$endDateDBView'");
        if ($column !== '' && $value !== '') {
            if (is_array($value) ) {
                $criteria->addInCondition($column, $value, 'AND');
            } else {
                $criteria->addCondition("$column = $value", 'AND');
            }
        }
        $workDays = WorkDay::model()->findAll($criteria);
        return $workDays;
    }
    
    private function createWorkDayModel($date, $idSpecialization, $idDoctor, $published) {
        $model = new WorkDay();
        $model->date = DateFormatHelper::getDateDBView($date);
        $model->idSpecialization = $idSpecialization;
        $model->idDoctor = $idDoctor;
        $model->published = ConvertHelper::booleanToOneOrZero($published);
        return $model;
        
    }
    
    private function saveWorkDayModel($model, $time = null, $timeStates = null) {
        self::checkTimeArgumnets($time, $timeStates);
        
        $isNeedCreateTime = ($time !== null) && ($timeStates != null);
        $t = Yii::app()->db->beginTransaction();
        try {
            if (!$model->save() ) {
                throw new ModifyDBException();
            }
           
            // Записываем время
            if ($isNeedCreateTime) {
                $model->updateTime($time, $timeStates);    
            } else {
                $model->deleteTime();
            }
            
            $t->commit();
        } 
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        }  
    }
    
    private function deleteWorkDayByIdNotTransactional($id) {
        $workDay = $this->getWorkDayById($id);
        // Удаляем всё время связанное с рабочим днём
        $workDay->deleteTime();
        // Удаляем сам рабочий день
        if (!$workDay->delete() ) {
            throw new ModifyDBException();
        } 
    }
        
    private function updatePublishedInWorkDayByIdNotTransactional($id, $published) {
        $workDay = $this->getWorkDayById($id);
        $workDay->published = ConvertHelper::booleanToOneOrZero($published);
        if (!$workDay->save() ) {
            throw new ModifyDBException();
        } 
    }
    
    private function getWorkTimeByIdWorkDayAndTime($idWorkDay, $timeShortTextView) {
        $timeDbView = TimeFormatHelper::timeShortTextViewToTimeDBView($timeShortTextView);
        $criteria = new CDbCriteria();
        $criteria->addCondition("idWorkDay = $idWorkDay", 'AND');
        $criteria->addCondition("time = '$timeDbView'", 'AND');
        $workTime = WorkTime::model()->find($criteria); 
        if ($workTime === null) {
            throw new RowIsNotExistsException();
        }    
        return $workTime;
    }
   
    // Проверяет правильность передачи аргументов функции.
    // Приходится использовать из-за ограничения php на перегрузку функций.
    // Т.к. нельзя иметь две функции с одним именем, но разным количеством аргументов, а необходима функция
    // которой нужно либо не передавать доп. аргументы вообще,  либо передавать два доп.аргумента, 
    // но нельзя передавать один - поэтому параметры по умолчанию не всегда подходят.
    private static function checkTimeArgumnets($time, $timeStates) {
        if ( 
                ( ($time === null) && ($timeStates !== null) ) ||
                ( ($time !== null) && ($timeStates === null) )
           ) 
        {
            throw new InvalidArgumentException(self::TIME_INVALID_ARGUMENST_EXCEPTION_MESSAGE);
        }   
    }
    
    
}
