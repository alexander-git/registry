<?php

Yii::import('constant.Values');
Yii::import('constant.Messages');
Yii::import('constant.FlashMessages');
Yii::import('constant.Operations');
Yii::import('helpers.FlashMessageHelper');
Yii::import('managers.user.UserManager');


class UserController extends AdminController
{
    const CREATE_UPDATE_USER_FORM_ID = 'createUpdateUserForm';

    public $layout = '//layouts/admin';   
    public $userMenu = null;
    
    public function init() {
        parent::init();
        
        $this->attachBehavior(
            'makerConditionBehavior', 
            array(
                'class' => 'ext.behaviors.MakerConditionBehavior'
            )
        );
    }
    
    
    public function filters()
    {
        return array(
            //TODO# Раскомментировать в рабочей версиии в этом и других
            // контроллерах.
            'accessControl', 
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array(Operations::MANAGE_USERS) ),
            array('deny', 'users' => array('*') ),
        );
    }
    
    public function actionIndex()
    {      
        $condition = $this->prepareEnableConditionOnGetVariable();
        
        $dataProvider = new CActiveDataProvider(
            'User', 
            array(
                'pagination' => array(
                    'pageSize' => Values::USERS_PER_PAGE,
                ),
                'sort' => array(
                    'defaultOrder' => array(
                        'name' => CSort::SORT_ASC
                    ),     
                ),  
                'criteria' => array(
                    'condition' => $condition,
                ),
            )
        );
        
        $this->render('index', array('dataProvider'=>$dataProvider) );
    }

    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id) ) );
    }

    public function actionCreate()
    {
        $this->performAjaxValidation();

        if(isset($_POST['User']) ) {
            $userManager = new UserManager();
            $result = $userManager->createUser($_POST['User']);
            $model = $result->model;
            if($result->isSuccess) { 
                FlashMessageHelper::setSuccessMessage(FlashMessages::USER_CREATE_SUCCESS);
                $this->redirect(array('view', 'id' => $model->id) );
            }
        } else {
            $model = new User();
        }

        $this->render('create', array('model' => $model) );
    }

    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);
        $this->performAjaxValidation($model);

        if(isset($_POST['User']) ) {
            $userManager = new UserManager();
            $result = $userManager->updateUserByModel($model, $_POST['User']);
            $model = $result->model;
            if($result->isSuccess ) {
                FlashMessageHelper::setSuccessMessage(FlashMessages::USER_UPDATE_SUCCESS);
                $this->redirect(array('view', 'id' => $model->id) );
            }
        }

        $this->render('update', array('model' => $model)  );
    }

    public function actionDelete($id)
    {
        $userManager = new UserManager();
        try {
             $userManager->deleteUserById($id);
        } 
        catch (Exception $e) {
            throw $e;
        }
           
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index') );
        }
    }

    public function loadModel($id)
    {
        $userManager = new UserManager();
        try {
            $model = $userManager->getUserById($id);
        }
        catch (RowIsNotExistsException $e) {
            throw new CHttpException(404, Messages::PAGE_NOT_EXIST_404);
        }
        return $model;
    }

    protected function performAjaxValidation($model = null)
    {
        if (isset($_POST['ajax']) && ($_POST['ajax'] === self::CREATE_UPDATE_USER_FORM_ID) )  
        {
            if ($model === null) {
                $model = new User();
            }
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
}
