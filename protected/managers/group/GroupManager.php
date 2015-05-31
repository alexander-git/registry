<?php

Yii::import('managers.SaveResult');
Yii::import('managers.SearchCriteria');

require_once 'DeletingGroupWhichHasSpecializationsException.php';

class GroupManager {
   
    public function __construct() {
        
    }
 
    public function getGroupById($id) {
        $model = Group::model()->findByPk($id);
        if($model === null) {
            throw new RowIsNotExistsException();
        }
        return $model;
    }
    
    public function getGroupWithSpecializationsById($id) {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'specializations' => array(
                'select' => 'id, name, additional',
                'alias' => 's'
            ),
        );
        $criteria->alias = 'g';
        
        $model = Group::model()->findByPk($id, $criteria);
        if($model === null) {
            throw new RowIsNotExistsException();
        }
        return $model;
    }
    
    // Если $enabled === null, то выбираются все гурппы.
    public function getGroupsByEnabled($enabled = null) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id, name, enabled';
        $criteria->order = 'g.name ASC';
        $criteria->alias = 'g';
        if ($enabled !== null) {
            if ($enabled) {
                $criteria->addCondition('g.enabled = TRUE');
            } else {
                $criteria->addCondition('g.enabled = FALSE');
            }
        }
        
        return Group::model()->findAll($criteria);
    }
    
    public function createGroup($attributes) {
        $model = new Group();
        try {
            $this->saveGroup($model, $attributes);
            return new SaveResult($model, true);
        }
        catch (Exception $e) {
            return new SaveResult($model, false);
        }
    }
    
    public function updateGroupByModel($model, $attributes) {
        try {
            $this->saveGroup($model, $attributes);
            return new SaveResult($model, true);
        }
        catch (Exception $e) {
            return new SaveResult($model, false);
        } 
    }

    public function updateGroupById($id, $attributes) {
        $model = $this->getGroupById($id);
        try {
            $this->saveGroup($model, $attributes);
            return new SaveResult($model, true);
        }
        catch (Exception $e) {
            return new SaveResult($model, false);
        } 
    }
    
    public function deleteGroupById($id) {
        // Группу нельзя удалять если у неё есть специализации.
        $specializationsCount = $this->getGroupSpecializationsCountById($id);
        if ($specializationsCount > 0) {
            throw new DeletingGroupWhichHasSpecializationsException();
        }

        $t = Yii::app()->db->beginTransaction();
        try {
            Group::model()->deleteByPk($id);
            $t->commit();
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        } 
    }
    
    public function searchGroup($searchCriteria) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id, name, enabled';
        
        if ($searchCriteria->text !== null) {
            $textToSearch = $searchCriteria->text;
            // Ищем в имени
            $criteria->addCondition("name LIKE '$textToSearch%'", 'AND');
        } else {
            // Иначе просто запишем результаты по возрастанию имени
            $criteria->order = 'name ASC';
        }
        
        if ($searchCriteria->limit !== null ) {
            $criteria->limit = $searchCriteria->limit;
        }
        
        $rows = Group::model()->findAll($criteria);
        
        return $rows;   
    }
    
    private function saveGroup($model, $attributes) {
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
    
    private function getGroupSpecializationsCountById($id) {
        $group = Group::model()->with('specializationsCount')->findByPk($id, array('select' => 'id') );
        return $group->specializationsCount;
    }
     
}
