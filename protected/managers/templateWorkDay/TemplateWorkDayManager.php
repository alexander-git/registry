<?php

Yii::import('managers.SaveResult');
Yii::import('managers.SearchCriteria');

class TemplateWorkDayManager {
    
    const TIME_INVALID_ARGUMENST_EXCEPTION_MESSAGE = 'Аргументы $time и $timeStates используются совместно. Поэтому они должны быть либо оба заданы(не null), либо оба не заданы(по умолчанию им будет присвоено null).';
    
    public function getTemplateWorkDayById($id) {
        $model = TemplateWorkDay::model()->findByPk($id);
        if ($model === null) {
            throw new RowIsNotExistsException();
        }
        return $model;    
    }
    
    public function getTemplateWorkDayWithTimeById($id) {
        $criteria = new CDbCriteria();
        $criteria->with = 'time';
        $model = TemplateWorkDay::model()->findByPk($id, $criteria);
        if ($model === null) {
            throw new RowIsNotExistsException();
        }
        return $model;    
    }
    
    public function cteateTemplateWorkDay($attributes, $time = null, $timeStates = null) {
        $model = new TemplateWorkDay();
        try {
            $this->saveTemplateWorkDay($model, $attributes, $time, $timeStates);
            return new SaveResult($model, true);
        }
        catch(Exception $e) {
            return new SaveResult($model, false);
        }
    }
    
    public function updateTemplateWorkDayByModel($model, $attributes, $time = null, $timeStates = null) {
        try {
            $this->saveTemplateWorkDay($model, $attributes, $time, $timeStates);
            return new SaveResult($model, true);
        }
        catch(Exception $e) {
            return new SaveResult($model, false);
        }
    }
    
    public function updateTemplateWorkDayById($id, $attributes, $time = null, $timeStates = null) {
        $model = $this->getTemplateWorkDayById($id);
        try {
            $this->saveTemplateWorkDay($model, $attributes, $time, $timeStates);
            return new SaveResult($model, true);
        }
        catch(Exception $e) {
            return new SaveResult($model, false);
        }
    }
    
    public function deleteTemplateWorkDayById($id) {
        $model = $this->getTemplateWorkDayById($id);
        $t = Yii::app()->db->beginTransaction();
        try {
            // Удаляем старые значения времени если они были
            TemplateWorkTime::model()->deleteAllByAttributes(array('idTemplateWorkDay' => $id) );  
           
            // Удаляем TemplateWorkDay
            if (!$model->delete() ) {
                throw new ModifyDBException();
            }
            
            $t->commit();
        } 
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        } 
    }
    
    public function searchTemplateWorkDay($searchCriteria) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id, name';
        
        if ($searchCriteria->text !== null) {
            $textToSearch = $searchCriteria->text;
            // Ищем в имени, фамилии, отчестве и поле дополнительно
            $criteria->addCondition("name LIKE '$textToSearch%'", 'AND');
        } else {
            // Иначе просто запишем результаты по возрастанию имени
            $criteria->order = 'name ASC';
        }
        
        if ($searchCriteria->limit !== null ) {
            $criteria->limit = $searchCriteria->limit;
        }
        
        $rows = TemplateWorkDay::model()->findAll($criteria);
        
        return $rows;       
    }
    
    private function saveTemplateWorkDay($model, $attributes, $time = null, $timeStates = null) {
        self::checkTimeArgumnets($time, $timeStates);
        
        $isNeedCreateTime = ($time !== null) && ($timeStates != null);
        $t = Yii::app()->db->beginTransaction();
        try {
            $model->attributes = $attributes;
            // Сохраняем TemplateWorkDay
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
