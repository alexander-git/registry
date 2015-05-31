<?php

Yii::import('helpers.ModelHelper');
Yii::import('utils.ResponseWriter');

class ReadDataIntervalActionFormModelBehavior extends CBehavior {
   
    public function readDateActionFormModel() {
        $formModel = new DateIntervalActionForm();
        $formModel->attributes = $_POST['DateIntervalActionForm'];
        if (!$formModel->validate() ) {
            $firstError = ModelHelper::getFirstError($formModel);
            $rw = new ResponseWriter();
            $rw->writeErrorJson($firstError);
            Yii::app()->end();
        } 
        return $formModel;
    }
    
}
