<?php

Yii::import('constant.Values');
Yii::import('constant.Messages');
Yii::import('constant.FlashMessages');
Yii::import('constant.Operations');
Yii::import('constant.Responses');
Yii::import('helpers.DateFormatHelper');
Yii::import('helpers.TimeFormatHelper');
Yii::import('helpers.JsonHelper');
Yii::import('helpers.AjaxParseHelper');
Yii::import('helpers.ConvertHelper');
Yii::import('helpers.FlashMessageHelper');
Yii::import('managers.templateWorkDay.TemplateWorkDayManager');

class TemplateWorkDayController extends AdminController
{
    const CREATE_UPDATE_TEMPLATE_WORK_DAY_FORM_ID = 'createUpdateTemplateWorkDayForm';

    public $layout = '//layouts/admin';
    public $templateWorkDayMenu = null;

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
                'roles' => array(Operations::VIEW_TEMPLATE_WORK_DAYS), 
            ),
            array(
                'allow',
                'actions' => array('create', 'update', 'delete'),
                'roles' => array(Operations::MANAGE_TEMPLATE_WORK_DAYS),
            ),
            array('deny', 'users' => array('*') ),
        );
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider(
            'TemplateWorkDay', 
            array(
                'pagination' => array(
                    'pageSize' => Values::TEMPLATES_WORK_DAY_PER_PAGE,
                ),
                'sort' => array(
                    'defaultOrder' => array(
                        'name' => CSort::SORT_ASC
                    ),     
                ),    
            )
        );

        $this->render('index', array('dataProvider'=>$dataProvider) );
    }
	
    public function actionView($id)
    {
        $model = $this->loadModel($id);       
        $this->render('view', array('model' => $model) );
    }

    public function actionCreate()
    {
        $this->performAjaxValidation();
        
        $isWasTimeInPost = isset($_POST['time']) && isset($_POST['timeStates']);
        if(isset($_POST['TemplateWorkDay']) ) {
            $templateWorkDayManager = new TemplateWorkDayManager();
            if (!$isWasTimeInPost) {
                $result = $templateWorkDayManager->cteateTemplateWorkDay($_POST['TemplateWorkDay']);
            } else {
                $result = $templateWorkDayManager->cteateTemplateWorkDay($_POST['TemplateWorkDay'], $_POST['time'], $_POST['timeStates'] ); 
            }
            $model = $result->model;
            if ($result->isSuccess) {
                FlashMessageHelper::setSuccessMessage(FlashMessages::TEMPLATE_WORK_DAY_CREATE_SUCCESS);
                $this->redirect(array('view', 'id'=>$model->id) );
            } 
        } else {
            $model = new TemplateWorkDay();
        }
        
        // Если было задано время - возвращаем его в вид,
        // чтобы отобразить. Пользователю не придётся вводить его заново в 
        // случае непрохождения валидации основной модели(т.е. TemplateWorkDay).
        $renderData = array();
        if ($isWasTimeInPost) {
            $renderData['time'] = $_POST['time'];
            $renderData['timeStates'] = $_POST['timeStates'];
        }
        $renderData['model'] = $model;
        $this->render('create', $renderData);
    }
    
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);

        if(isset($_POST['TemplateWorkDay'])) {
            $templateWorkDayManager = new TemplateWorkDayManager();
            
            $isWasTimeInPost = isset($_POST['time']) && isset($_POST['timeStates']);
            if (!$isWasTimeInPost) {
                $result = $templateWorkDayManager->updateTemplateWorkDayByModel($model, $_POST['TemplateWorkDay']);
            } else {
                $result = $templateWorkDayManager->updateTemplateWorkDayByModel($model, $_POST['TemplateWorkDay'], $_POST['time'], $_POST['timeStates']); 
            }
            $model = $result->model;
            if ($result->isSuccess) {
                FlashMessageHelper::setSuccessMessage(FlashMessages::TEMPLATE_WORK_DAY_UPDATE_SUCCESS);
                $this->redirect(array('view', 'id' => $model->id) );
            } 
        }
        
        $this->render('update', array('model' => $model) );
    }
    
    public function actionDelete($id)
    {
        $templateWorkDayManager = new TemplateWorkDayManager();
        try {
            $templateWorkDayManager->deleteTemplateWorkDayById($id);
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
        $templateWorkDayManager = new TemplateWorkDayManager();
        try {
            $model = $templateWorkDayManager->getTemplateWorkDayById($id);
        } catch (RowIsNotExistsException $e) {
            throw new CHttpException(404, Messages::PAGE_NOT_EXIST_404);      
        }
        return $model;
    }

    protected function performAjaxValidation($model = null)
    {
        if (isset($_POST['ajax']) && ($_POST['ajax'] === self::CREATE_UPDATE_TEMPLATE_WORK_DAY_FORM_ID) ) {
            if ($model === null) {
                // Если модель не задана, то просто создаётся новая.
                // В CActiveForm::validate() ей будут присвоены атрибуты из POST 
                // и она пройдёт валидацию.
                $model = new TemplateWorkDay();
            }
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
}
