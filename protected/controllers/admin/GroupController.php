<?php

Yii::import('constant.Values');
Yii::import('constant.Messages');
Yii::import('constant.FlashMessages');
Yii::import('constant.Operations');
Yii::import('helpers.FlashMessageHelper');
Yii::import('managers.group.GroupManager');


class GroupController extends AdminController
{
    const CREATE_UPDATE_GROUP_FORM_ID = 'createUpdateGroupForm';

    public $layout = '//layouts/admin';
    public $groupMenu = null;
    
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
            'accessControl', 
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('index', 'view'),
                'roles' => array(Operations::VIEW_GROUPS), 
            ),
            array(
                'allow',
                'actions' => array('create', 'update', 'delete'),
                'roles' => array(Operations::MANAGE_GROUPS),
            ),
            array('deny', 'users' => array('*') ),
        );
    }
    
    public function actionIndex()
    {
        $condition = $this->prepareEnableConditionOnGetVariable();
        
        $dataProvider = new CActiveDataProvider(
            'Group', 
            array(
                'pagination' => array(
                    'pageSize' => Values::GROUPS_PER_PAGE,
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

        $this->render('index', array('dataProvider' => $dataProvider) );
    }
     
    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->render('view',  array('model' => $model) );
    }
    
    public function actionCreate()
    {
        $this->performAjaxValidation();
        
        if(isset($_POST['Group']) ) {
            $groupManager = new GroupManager();
            $result = $groupManager->createGroup($_POST['Group']);
            $model = $result->model;
            if ($result->isSuccess) {
                FlashMessageHelper::setSuccessMessage(FlashMessages::GROUP_CREATE_SUCCESS);
                $this->redirect(array('view', 'id' => $model->id) );
            }
        } else {
            $model = new Group();
        }

        $this->render('create', array('model' => $model) );
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        
        if(isset($_POST['Group']) ) {
            $groupManager = new GroupManager();
            $result = $groupManager->updateGroupByModel($model, $_POST['Group']);
            $model = $result->model;
            if ($result->isSuccess) {
                FlashMessageHelper::setSuccessMessage(FlashMessages::GROUP_UPDATE_SUCCESS);
                $this->redirect(array('view', 'id' => $model->id) );
            }
        }

        $this->render('update', array('model'=>$model) );
    }

    public function actionDelete($id)
    {
        $groupManager = new GroupManager();
        try {
            $groupManager->deleteGroupById($id);
        } 
        catch(DeletingGroupWhichHasSpecializationsException $e) {
            if (!Yii::app()->request->isAjaxRequest) {
                FlashMessageHelper::setErrorMessage(FlashMessages::DELETING_GROUP_WHICH_HAS_SPECIALIZATIONS_ERROR);                
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

    public function loadModel($id)
    {
        $groupManager = new GroupManager();
        try {
            // Специализации для группы, если они окажутся нужны, будем загружать "лениво"
            $model = $groupManager->getGroupById($id);
        }
        catch(RowIsNotExistsException $e) {
            throw new CHttpException(404, Messages::PAGE_NOT_EXIST_404);    
        }
        return $model;
    }

    protected function performAjaxValidation($model = null)
    {
        if (isset($_POST['ajax']) && ($_POST['ajax'] === self::CREATE_UPDATE_GROUP_FORM_ID) ) {
            if ($model === null) {
                $model = new Group();
            }
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
}
