<?php

Yii::import('constant.Values');
Yii::import('constant.Messages');
Yii::import('constant.FlashMessages');
Yii::import('constant.Operations');
Yii::import('utils.ResponseWriter');
Yii::import('helpers.DateFormatHelper');
Yii::import('helpers.TimeFormatHelper');
Yii::import('helpers.DateTimeFormatHelper');
Yii::import('helpers.AjaxParseHelper');
Yii::import('helpers.FlashMessageHelper');
Yii::import('managers.order.OrderManager');
Yii::import('managers.order.OrderAttributes');


class OrderController extends AdminController
{
    const CREATE_UPDATE_ORDER_FORM_ID = 'createUpdateOrderForm';

    public $layout = '//layouts/admin';
    public $orderMenu = null;
    
    public function init() {
        parent::init();
        
        $this->attachBehavior(
            'makerConditionBehavior', 
            array(
                'class' => 'ext.behaviors.MakerConditionBehavior',
            )
        );
        
        $this->attachBehavior(
            'readDataIntervalActionFormModelBehavior', 
            array(
                'class' => 'ext.behaviors.ReadDataIntervalActionFormModelBehavior',
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
                'roles' => array(Operations::VIEW_ORDERS), 
            ),
            array(
                'allow',
                'actions' => array('create', 'update', 'delete', 'manage', 'deleteOrders'),
                'roles' => array(Operations::MANAGE_ORDERS),
            ),
            array('deny', 'users' => array('*') ),
        );
    }

    
    public function actionIndex()
    {
        // Создание условия.
        $orderTableAlias = 'o';
        $specializationTableAlias = 's';
        $doctorTableAlias = 'd';
        $processedCondition = $this->prepareOrderProcessedConditionOnGetVariable($orderTableAlias);
        $stateCondtion = $this->prepareOrderStateConditionOnGetVariable($orderTableAlias);
        $condition = $this->andConditions($processedCondition, $stateCondtion);        
        
        $sort = new CSort();
        $sort->attributes = array(
            'orderDateTime' => array(
                'asc' => 'orderDateTime ASC',
                'desc' => 'orderDateTime DESC'
            ),
            'dateTime' => array(
                'asc' => 'date ASC, TIME ASC',
                'desc' => 'date DESC, time DESC'
            )
        
        );
        $sort->defaultOrder = array('orderDateTime' => CSort::SORT_DESC);
        
        
        $dataProvider = new CActiveDataProvider(
            'Order', 
            array(
                'pagination' => array(
                    'pageSize' => Values::ORDERS_PER_PAGE,
                ),
                'sort' => $sort,
                'criteria' => array(
                    'with' => array(
                        'doctor' => array(
                            'select' => 'id, firstname, surname, patronymic, additional, speciality',
                            'alias' => $doctorTableAlias
                        ),
                        'specialization' => array(
                            'select' => 'id, name, additional, needDoctor',
                            'alias' => $specializationTableAlias
                        ),
                    ),
                    'condition' => $condition,
                    'alias' => $orderTableAlias,
                ),
            )
        );
       
        $this->render('index',  array('dataProvider' => $dataProvider) );
    }

    public function actionView($id)
    {
        $this->render(
            'view',
            array('model' => $this->loadModel($id) )
        );
    }

    public function actionCreate()
    {
        $this->performAjaxValidation();

        if(isset($_POST['Order']) ) {
            Yii::log(print_r($_POST['Order'], true), 'error');
          
            $orderManager = new OrderManager();
            $result = $orderManager->createOrder($_POST['Order']);
            $model = $result->model;
            
            // Т.к. в процессе создания(и валидации) модели данные 
            // дат и времени преобразуются в вид пригодный для записи в БД, то
            // вернём их к виду, соответствующему вводу пользователя.
            $this->setOrderModelFieldsOnPostData($model);
            
            if($result->isSuccess) {
                FlashMessageHelper::setSuccessMessage(FlashMessages::ORDER_CREATE_SUCCESS);
                $this->redirect(array('view', 'id' => $model->id) );
            } 
        } else {
            $model = new Order();
        }
        
        $this->render('create', array('model' => $model) );
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);

        $isModelPreparedToShowInForm = false;
        if(isset($_POST['Order']) ) {
            $orderManager = new OrderManager();
            $result = $orderManager->updateOrderByModel($model, $_POST['Order']);
            $model = $result->model;
              
            // Т.к. в процессе создания(и валидации) модели данные 
            // дат и времени преобразуются в вид пригодный для записи в БД, то
            // вернём их к виду, соответствующему вводу пользователя.
            $this->setOrderModelFieldsOnPostData($model);
            $isModelPreparedToShowInForm = true;
            
            if ($result->isSuccess) {
                FlashMessageHelper::setSuccessMessage(FlashMessages::ORDER_UPDATE_SUCCESS);
                $this->redirect( array('view', 'id'=>$model->id) );      
            }
        }
        if (!$isModelPreparedToShowInForm) {
            $this->prepareOrderModelToShowInForm($model);     
        }
        
        $this->render('update', array('model' => $model) );
    }
    
  
    public function actionDelete($id)
    {
        $orderManager = new OrderManager();
        try {
             $orderManager->deleteOrderById($id);
        } 
        catch (Exception $e) {
            throw $e;
        }
           
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(array('index') );
        }
    }
    
    public function actionManage() {
        $this->render('manage');
    }
    
    public function actionDeleteOrders() {
        $processed = null;
        if ($_POST['processed'] === 'all') {
            $processed = null;
        } else {
            $processed = AjaxParseHelper::getBoolean($_POST['processed']);
        }
        
        $state = null;
        if ($_POST['state'] === 'all') {
            $state = null;
        } else {
            $state  = $_POST['state'];
        }
        
        $formModel = $this->readDateActionFormModel();
        
        $beginDate = DateFormatHelper::getDateFromCommonTextView($formModel->dateBegin);
        $endDate = DateFormatHelper::getDateFromCommonTextView($formModel->dateEnd);
        $orderManager = new OrderManager();
        $orderManager->deleteOrders($beginDate, $endDate, $processed, $state);
        $rw = new ResponseWriter();
        $rw->writeSuccessJson();
    }
 
    private function loadModel($id)
    {
        $orderManager = new OrderManager();
        try {
            $model = $orderManager->getOrderWithSpecializationAndDoctorById($id);
        }
        catch (RowIsNotExistsException $e) {
            throw new CHttpException(404, Messages::PAGE_NOT_EXIST_404);
        }
        return $model;
    }

    private function setOrderModelFieldsOnPostData($model) {
        $model->date = $_POST['Order']['date'];
        $model->time = $_POST['Order']['time'];
        $model->orderDateTime = $_POST['Order']['orderDateTime'];
    }
    
    private function prepareOrderModelToShowInForm($model) {
        if ( ($model->date !== null) && ($model->date !== '') ) {
            $model->date = DateFormatHelper::dateDBViewToDateCommonTextView($model->date);    
        } 
        if ( ($model->time !== null) && ($model->time !== '') ) {
            $model->time = TimeFormatHelper::timeDBViewToTimeShortTextView($model->time);    
        }
        if ( ($model->orderDateTime !== null) && ($model->orderDateTime !== '') ) {
            $model->orderDateTime = DateTimeFormatHelper::dateTimeDBViewToDateTimeCommonTextView($model->orderDateTime);    
        }
    }
    
    protected function performAjaxValidation($model = null)
    {
        if (
                isset($_POST['ajax']) && 
                ($_POST['ajax'] === self::CREATE_UPDATE_ORDER_FORM_ID) 
            ) 
        {
            if ($model === null) {
                $model = new Order();
            }
            
            // Укажем некоторые атрибуты для валидации т.к все проверять  
            // через ajax не нужно - различные атрибуты даты и времени не проверяем, поскольку
            // вводим их в одном формате(удобном для пользователю), а в базе данных 
            // они храняться в другом.            
            echo CActiveForm::validate(
                $model,
                 array(
                    'idSpecialization',
                    'idDoctor',
                    'firstname',
                    'surname',
                    'patronymic',
                    'phone',
                    'processed',
                    'state',
                )
            ); 
            
            Yii::app()->end();
        }
    }
    
    
}
