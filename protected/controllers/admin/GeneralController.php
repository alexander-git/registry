<?php

Yii::import('constant.Operations');

class GeneralController extends AdminController
{
    
    public $layout = '//layouts/admin';   
    
    public function filters()
    {
        return array(
            'accessControl', 
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow', 
                'actions' => array('main'),
                'roles' => array(Operations::GENERAL_ADMIN_ACTIONS) ),
            array(
                'deny', 
                'users' => array('*') 
            ),
        );
    }
    
    public function actionMain()
    {      
        $this->render('main');
    }

    
}
