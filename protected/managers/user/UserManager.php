<?php

Yii::import('managers.SaveResult');

class UserManager {
    
    public function __construct() {
    
    }
    
    public function getUserById($id) {
        $model = User::model()->findByPk($id);
        if($model === null) {
            throw new RowIsNotExistsException();
        }
        return $model;
    }
    
    public function createUser($attributes) {
        $model = new User();
        try {
            $this->saveUser($model, $attributes);
            return new SaveResult($model, true);
        }
        catch (Exception $e) {
            return new SaveResult($model, false);
        }
    }
    
    public function updateUserByModel($model, $attributes) {
        try {
            $this->saveUser($model, $attributes);
            return new SaveResult($model, true);
        }
        catch (Exception $e) {
            return new SaveResult($model, false);
        } 
    }

    public function updateUserById($id, $attributes) {
        $model = $this->getUserById($id);
        try {    
            $this->saveUser($model, $attributes);
            return new SaveResult($model, true);
        }
        catch (Exception $e) {
            return new SaveResult($model, false);
        } 
    }
    
    public function deleteUserById($id) {
        $t = Yii::app()->db->beginTransaction();
        try {
            User::model()->deleteByPk($id);
            $t->commit();
        }
        catch(Exception $e) {
            $t->rollback();
            throw $e;
        } 
    }
        
    private function saveUser($model, $attributes) {
        $t = Yii::app()->db->beginTransaction();
        try {
            // Если обновляем старую запись, запомним предыдущую роль
            // В случае успешного сохранения она(предыдущая роль) будет использоваться 
            // в методе afterSave модели User
            if (!$model->isNewRecord) {
                $model->previousRole = $model->role;
            }
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
    
}
