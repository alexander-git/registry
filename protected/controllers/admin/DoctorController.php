<?php

Yii::import('constant.Values');
Yii::import('constant.Messages');
Yii::import('constant.FlashMessages');
Yii::import('constant.Operations');
Yii::import('helpers.FlashMessageHelper');
Yii::import('managers.doctor.DoctorManager');


class DoctorController extends AdminController
{
    const CREATE_UPDATE_DOCTOR_FORM_ID = 'createUpdateDoctorForm';
    
    public $layout = '//layouts/admin';
    public $doctorMenu = null;

    public function init() {
        parent::init();
            
        $this->attachBehavior(
            'makerConditionBehavior', 
            array(
                'class' => 'ext.behaviors.MakerConditionBehavior',
            )
        );
    }
    
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
                'actions' => array('index', 'view'),
                'roles' => array(Operations::VIEW_DOCTORS), 
            ),
            array(
                'allow',
                'actions' => array('create', 'update', 'delete'),
                'roles' => array(Operations::MANAGE_DOCTORS),
            ),
            array('deny', 'users' => array('*') ),
        );
    }
    
    public function actionIndex()
    {      
        // Создание условия
        $doctorTableAlias = 'doctor';
        $enabledCondition = $this->prepareEnableConditionOnGetVariable($doctorTableAlias);
          
        $dataProvider = new CActiveDataProvider(
            'Doctor', 
            array(
                'pagination' => array(
                    'pageSize' => Values::DOCTORS_PER_PAGE,
                ),
                'sort' => array(
                    'defaultOrder' => array(
                        'surname' => CSort::SORT_ASC
                    ),     
                ),    
                'criteria' => array(
                    'select' => 'id, firstname, surname, patronymic, additional, enabled, speciality',
                    'condition' => $enabledCondition,
                    'alias' => $doctorTableAlias,
                ),
            )
        );

        $this->render('index', array('dataProvider' => $dataProvider) );
    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->render('view', array('model' => $model) );
    }

    public function actionCreate()
    {
        $this->performAjaxValidation();
        
        if(isset($_POST['Doctor']) ) {
            $doctorManager = new DoctorManager();
            if (!isset($_POST['specializations']) ) {
                $result = $doctorManager->createDoctor($_POST['Doctor']); 
            } else {
                $result = $doctorManager->createDoctor($_POST['Doctor'], $_POST['specializations']);
            }
            $model = $result->model;
            if ($result->isSuccess) {
                FlashMessageHelper::setSuccessMessage(FlashMessages::DOCTOR_CREATE_SUCCESS);
                $this->redirect(array('view', 'id' => $model->id) ); 
            } 
        } else {
            $model = new Doctor();
        }
        
        $this->render('create', array('model' => $model) );
    }
    
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        
        if(isset($_POST['Doctor']) ) {
            $doctorManager = new DoctorManager();
            if (!isset($_POST['specializations']) ) {
                $result = $doctorManager->updateDoctorByModel($model, $_POST['Doctor']); 
            } else {
                $result = $doctorManager->updateDoctorByModel($model, $_POST['Doctor'], $_POST['specializations']);
            }
            $model = $result->model;
            if ($result->isSuccess) {
                FlashMessageHelper::setSuccessMessage(FlashMessages::DOCTOR_UPDATE_SUCCESS);
                $this->redirect(array('view', 'id' => $model->id) ); 
            }
        }

        $this->render('update',  array('model' => $model) );
    }
    
    public function actionDelete($id)
    {
        $doctorManager = new DoctorManager();
        try {
            $doctorManager->deleteDoctorById($id);
        }
        catch (DeletingDoctorWhichIsInWorkDaysException $e) {
            if (!Yii::app()->request->isAjaxRequest) {
                FlashMessageHelper::setErrorMessage(FlashMessages::DELETING_DOCTOR_WHICH_IN_WORK_DAYS_ERROR);                
                $this->redirect(array('view', 'id' => $id) );
            }    
        }
        catch (DeletingDoctorWhichIsInOrdersException $e) {
            if (!Yii::app()->request->isAjaxRequest) {
                FlashMessageHelper::setErrorMessage(FlashMessages::DELETING_DOCTOR_WHICH_IN_ORDERS_ERROR);                
                $this->redirect(array('view', 'id' => $id) );
            }    
        }
        catch (Exception $e) {
            throw $e;
        }
           
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index') );
        }
    }
   
    private function loadModel($id)
    {
        $doctorManager = new DoctorManager();
        try {
            $model = $doctorManager->getDoctorWithSpecializationsById($id);
        }
        catch(RowIsNotExistsException $e) {
            throw new CHttpException(404, Messages::PAGE_NOT_EXIST_404);    
        }
        return $model;
    }
        
    protected function performAjaxValidation($model = null)
    {
        if (isset($_POST['ajax']) && ($_POST['ajax'] === self::CREATE_UPDATE_DOCTOR_FORM_ID) )
        {
            if ($model === null) {
                $model = new Doctor();
                
            }
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
}
