<?php

Yii::import('constant.Values');
Yii::import('constant.Messages');
Yii::import('constant.FlashMessages');
Yii::import('constant.Operations');
Yii::import('utils.ResponseWriter');
Yii::import('helpers.FlashMessageHelper');
Yii::import('managers.specialization.SpecializationManager');


class SpecializationController extends AdminController
{
    const CREATE_UPDATE_SPECIALIZATION_FORM_ID = 'createUpdateSpecializationForm';

    public $layout = '//layouts/admin';
    public $specializationMenu = null;
        
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
                'roles' => array(Operations::VIEW_SPECIALIZATIONS), 
            ),
            array(
                'allow',
                'actions' => array('create', 'update', 'delete'),
                'roles' => array(Operations::MANAGE_SPECIALIZATIONS),
            ),
            array('deny', 'users' => array('*') ),
        );
    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->render('view', array('model' => $model) );
    }

    public function actionCreate()
    {
        $this->performAjaxValidation();
        
        if(isset($_POST['Specialization']) ) {
            $specializationManager = new SpecializationManager();
            $result = $specializationManager->createSpecialization($_POST['Specialization']);
            $model = $result->model;
            if($result->isSuccess) {
                FlashMessageHelper::setSuccessMessage(FlashMessages::SPECIALIZATION_CREATE_SUCCESS);
                $this->redirect(array('view', 'id' => $model->id) );
            } 
        } else {
            $model = new Specialization();
        }
        
        $this->render('create', array('model' => $model) );
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);

        if(isset($_POST['Specialization']) ) {
            $specializationManager = new SpecializationManager();
            $result = $specializationManager->updateSpecializationByModel($model, $_POST['Specialization']);
            $model = $result->model;
            if ($result->isSuccess) {
                FlashMessageHelper::setSuccessMessage(FlashMessages::SPECIALIZATION_UPDATE_SUCCESS);
                $this->redirect( array('view', 'id'=>$model->id) );      
            }
        }
      
        $this->render('update', array('model' => $model) );
    }

    public function actionDelete($id)
    {
        $specializationManager = new SpecializationManager();
        try {
             $specializationManager->deleteSpecializationById($id);
        } 
        catch(DeletingSpecializationWhichHasDoctorsException $e) {
            if (!Yii::app()->request->isAjaxRequest) {
                FlashMessageHelper::setErrorMessage(FlashMessages::DELETING_SPECIALIZATION_WHICH_HAS_DOCTORS_ERROR);                
                $this->redirect(array('view', 'id' => $id) );
            }
        }
        catch (DeletingSpecializationWhichIsInWorkDaysException $e) {
            if (!Yii::app()->request->isAjaxRequest) {
                FlashMessageHelper::setErrorMessage(FlashMessages::DELETING_SPECIALIZATION_WHICH_IN_WORK_DAYS_ERROR);                
                $this->redirect(array('view', 'id' => $id) );
            }    
        }
        catch (DeletingSpecializationWhichIsInOrdersException $e) {
            if (!Yii::app()->request->isAjaxRequest) {
                FlashMessageHelper::setErrorMessage(FlashMessages::DELETING_SPECIALIZATION_WHICH_IN_ORDERS_ERROR);                
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

    public function actionIndex()
    {     
        // Создание условия
        $specializationTableAlias = 'specialization';
        $enabledCondition = $this->prepareEnableConditionOnGetVariable($specializationTableAlias);
        $idGroupCondtion = $this->prepareIdGroupConditionOnGetVariable($specializationTableAlias);
        $condition = $this->andConditions($enabledCondition, $idGroupCondtion);        
        
        $dataProvider = new CActiveDataProvider(
            'Specialization', 
            array(
                'pagination' => array(
                    'pageSize' => Values::SPECIALIZATIONS_PER_PAGE,
                ),
                'sort' => array(
                    'defaultOrder' => array(
                        'name' => CSort::SORT_ASC
                    ),     
                ),    
                'criteria' => array(
                    'with' => array(
                        'group' => array(
                            'select' => 'name',
                        ),
                    ),
                    'condition' => $condition,
                    'alias' => $specializationTableAlias,
                ),
            )
        );
       
        $this->render('index',  array('dataProvider' => $dataProvider) );
    }
    
    private function loadModel($id)
    {
        $specializationManager = new SpecializationManager();
        try {
            $model = $specializationManager->getSpecializationWithGroupAndDoctorsById($id);
        }
        catch (RowIsNotExistsException $e) {
            throw new CHttpException(404, Messages::PAGE_NOT_EXIST_404);
        }
        return $model;
    }
    
    protected function performAjaxValidation($model = null)
    {
        if (isset($_POST['ajax']) && ($_POST['ajax'] === self::CREATE_UPDATE_SPECIALIZATION_FORM_ID) )  
        {
            if ($model === null) {
                $model = new Specialization();
            }
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
}
