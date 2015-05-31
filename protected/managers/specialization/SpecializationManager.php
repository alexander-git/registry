<?php

Yii::import('managers.SaveResult');
Yii::import('managers.SearchCriteria');

require_once 'DeletingSpecializationWhichHasDoctorsException.php';
require_once 'DeletingSpecializationWhichIsInWorkDaysException.php';
require_once 'DeletingSpecializationWhichIsInOrdersException.php';

class SpecializationManager {
    
    public function __construct() {
        
    }
    
    public function getSpecializationById($id) {
        $model = Specialization::model()->findByPk($id);
        if ($model === null) {
            throw new RowIsNotExistsException();
        }
        return $model;
    }
    
    public function getSpecializationWithGroupById($id) {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'group' => array(
                'alias' => 'g'
            ),
        );
        $criteria->alias = 's';

        $model = Specialization::model()->findByPk($id, $criteria);
        if ($model === null) {
            throw new RowIsNotExistsException();
        }
        return $model;
    }
    
    public function getSpecializationWithGroupAndDoctorsById($id) {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'group' => array(
                'select' => 'name',
                'alias' => 'g'
            ),
            'doctors' => array(
                'select' => 'id, surname, firstname, patronymic, additional',
                'alias' => 'd'
            )
        );
        $criteria->alias = 's';

        $model = Specialization::model()->findByPk($id, $criteria);
        if ($model === null) {
            throw new RowIsNotExistsException();
        }
        return $model;
    }
    
    public function getSpecializationsByIdGroupAndEnabled($idGroup, $enabled = null) {
        $criteria = new CDbCriteria();
        $criteria->order = 's.name ASC';
        $criteria->alias = 's';
        $criteria->addCondition("s.idGroup = $idGroup");
        if ($enabled !== null) {
            if ($enabled) {
                $criteria->addCondition('s.enabled = TRUE');
            } else {
                $criteria->addCondition('s.enabled = FALSE');
            }
        }
        
        return Specialization::model()->findAll($criteria);
        
    }
    
    public function createSpecialization($attributes) {
        $model = new Specialization();
        try {
            $this->saveSpecialization($model, $attributes);
            return new SaveResult($model, true);
        }
        catch (Exception $e) {
            return new SaveResult($model, false);
        }
    }
    
    public function updateSpecializationByModel($model, $attributes) {
        try {
            $this->saveSpecialization($model, $attributes);
            return new SaveResult($model, true);
        }
        catch (Exception $e) {
            return new SaveResult($model, false);
        } 
    }

    public function updateSpecializationById($id, $attributes) {
        $model = $this->getSpecializationById($id);
        try {
            $this->saveSpecialization($model, $attributes);
            return new SaveResult($model, true);
        }
        catch (Exception $e) {
            return new SaveResult($model, false);
        } 
    }
    
    public function deleteSpecializationById($id) {
        $doctorsCount = $this->getSpecializationDoctorsCountById($id);
        if ($doctorsCount > 0) {
            throw new DeletingSpecializationWhichHasDoctorsException();
        }
        if ($this->isThereSpecializationInWorkDays($id) ) {
            throw new DeletingSpecializationWhichIsInWorkDaysException();
        }
        if ($this->isThereSpecializationInOrders($id) ) {
            throw new DeletingSpecializationWhichIsInOrdersException();
        }
        
        
        $t = Yii::app()->db->beginTransaction();
        try {
            Specialization::model()->deleteByPk($id);
            $t->commit();
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        } 
    }
     
    public function searchSpecialization($searchCriteria) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id, name, additional';
        

        if ($searchCriteria->text !== null) {
            $textToSearch = $searchCriteria->text;            
            // Ищем в имени и поле дополнительно
            $criteria->addCondition("name LIKE '$textToSearch%'", 'AND');
            $criteria->addCondition("additional LIKE '$textToSearch%'", 'OR');
            
        } else {
            // Иначе просто запишем результаты по возрастанию имени
            $criteria->order = 'name ASC';
        } 
        
        if ($searchCriteria->limit !== null ) {
            $criteria->limit = $searchCriteria->limit;
        }
        
        $rows = Specialization::model()->findAll($criteria);
        
        return $rows;
    }
    
    private function saveSpecialization($model, $attributes) {
        $t = Yii::app()->db->beginTransaction();
        try {
            $model->attributes = $attributes;
 
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
    
    private function getSpecializationDoctorsCountById($idSpecialization) {
        $specialization = Specialization::model()->with('doctorsCount')->findByPk($idSpecialization, array('select' => 'id') );
        return $specialization->doctorsCount;
    }
    
    private function isThereSpecializationInWorkDays($idSpecialization) {
        $criteria = new CDbCriteria();
        $criteria->select = "id";
        $criteria->condition = "idSpecialization = $idSpecialization";
        $workDay = WorkDay::model()->find($criteria);
        if ($workDay === null) {
            return false;
        } else {
            return true;
        }
    }
    
    private function isThereSpecializationInOrders($idSpecialization) {
        $criteria = new CDbCriteria();
        $criteria->select = "id";
        $criteria->condition = "idSpecialization = $idSpecialization";
        $order = Order::model()->find($criteria);
        if ($order === null) {
            return false;
        } else {
            return true;
        }
    }
      
}
