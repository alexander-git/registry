<?php

Yii::import('managers.SaveResult');
Yii::import('managers.SearchCriteria');

require_once 'SpecializationWithSuchIdIsNotExistsException.php';
require_once 'DeletingDoctorWhichIsInWorkDaysException.php';
require_once 'DeletingDoctorWhichIsInOrdersException.php';

class DoctorManager {
    
    public function __construct() {
        
    }
    
    public function getDoctorById($id) {
        $model = Doctor::model()->findByPk($id);
        if ($model === null) {
            throw new RowIsNotExistsException();
        }
        return $model;
    }
    
    public function getDoctorWithSpecializationsById($id) {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'specializations' => array(
                'select' => 'id, name, additional',
                'order' => 's.name ASC, s.additional ASC',
                'alias' => 's',
            )
        );
        $criteria->alias = 'd';
        $model = Doctor::model()->findByPk($id, $criteria);
        if ($model === null) {
            throw new RowIsNotExistsException();
        }
        return $model;
    }
    
    public function getDoctorsByIdSpecializationAndEnabled($idSpecialization, $enabled = null) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id';
        $criteria->alias = 's';
        
        $enabledCondition = '';
        if ($enabled !== null) {
            if ($enabled) {
                 $enabledCondition = 'd.enabled = TRUE';
            } else {
                $enabledCondition =  'd.enabled = FALSE';
            }
        }
        
        $criteria->with = array(
            'doctors' => array(
                'order' => 'd.surname ASC, d.firstname ASC, d.patronymic ASC',
                'alias' => 'd',
                'on' => "$enabledCondition",
                'joinType' => 'LEFT JOIN'
            )
        );
        
        $specialization = Specialization::model()->findByPk($idSpecialization, $criteria);
        
        if ($specialization === null) {
            throw new SpecializationWithSuchIdIsNotExistsException();
        } else {
            return $specialization->doctors;
        }
    }
    
    public function createDoctor($attributes, $idsSpecialiazation = null) {
        $model = new Doctor();
        try {
            $this->saveDoctor($model, $attributes, $idsSpecialiazation);
            return new SaveResult($model, true);
        }
        catch(Exception $e) {
            return new SaveResult($model, false);
        }
    }
    
    public function updateDoctorByModel($model, $attributes, $idsSpecialiazation = null) {
        try {
            $this->saveDoctor($model, $attributes, $idsSpecialiazation);
            return new SaveResult($model, true);
        }
        catch(Exception $e) {
            return new SaveResult($model, false);
        }
    }
    
    public function updateDoctorById($id, $attributes, $idsSpecialiazation = null) {
        $model = $this->getDoctorById($id);
        try {
            $this->saveDoctor($model, $attributes, $idsSpecialiazation);
            return new SaveResult($model, true);
        }
        catch(Exception $e) {
            return new SaveResult($model, false);
        }
    }
    
    public function deleteDoctorById($id) {
        if ($this->isThereDoctorInWorkDays($id) ) {
            throw new DeletingDoctorWhichIsInWorkDaysException();
        }
        if ($this->isThereDoctorInOrders($id) ) {
            throw new DeletingDoctorWhichIsInOrdersException();
        }
        
        $t = Yii::app()->db->beginTransaction();
        try {
            // Удаляем привязку специализаций к врачу
            Doctor::deleteSpecializationsById($id);
            // Удалям врача
            Doctor::model()->deleteByPk($id);
            $t->commit();
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        }
    }
    
    public function searchDoctor($searchCriteria) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id, firstname, surname, patronymic, additional';
        
        if ($searchCriteria->text !== null) {
            $textToSearch = $searchCriteria->text;
            // Ищем в имени, фамилии, отчестве и поле дополнительно
            $criteria->addCondition("firstname LIKE '$textToSearch%'", 'AND');
            $criteria->addCondition("surname LIKE '$textToSearch%'", 'OR');
            $criteria->addCondition("patronymic LIKE '$textToSearch%'", 'OR');
            $criteria->addCondition("additional LIKE '$textToSearch%'", 'OR'); 
        } else {
            // Иначе просто запишем результаты по возрастанию имени
            $criteria->order = 'firstname ASC';
        }
        
        if ($searchCriteria->limit !== null ) {
            $criteria->limit = $searchCriteria->limit;
        }
        
        $rows = Doctor::model()->findAll($criteria);
        
        return $rows;
    }
    
    private function saveDoctor($model, $attributes, $idsSpecialization = null) {
        $t = Yii::app()->db->beginTransaction();
        try {
            $model->attributes = $attributes;
            // Сохраняем врача
            if (!$model->save() ) {
                throw new ModifyDBException();
            }
            if ($idsSpecialization === null) {
                $model->deleteSpecializations(); 
            } else {
                $model->updateSpecializations($idsSpecialization);
            }
            $t->commit(); 
        } 
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        }
    }
    
    private function isThereDoctorInWorkDays($idDoctor) {
        $criteria = new CDbCriteria();
        $criteria->select = "id";
        $criteria->condition = "idDoctor = $idDoctor";
        $workDay = WorkDay::model()->find($criteria);
        if ($workDay === null) {
            return false;
        } else {
            return true;
        }
    }
    
    private function isThereDoctorInOrders($idDoctor) {
        $criteria = new CDbCriteria();
        $criteria->select = "id";
        $criteria->condition = "idDoctor = $idDoctor";
        $order = Order::model()->find($criteria);
        if ($order === null) {
            return false;
        } else {
            return true;
        }
    }
    
}
