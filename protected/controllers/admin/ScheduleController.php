<?php

Yii::import('constant.Values');
Yii::import('constant.Messages');
Yii::import('constant.Operations');
Yii::import('helpers.DateFormatHelper');
Yii::import('helpers.TimeFormatHelper');
Yii::import('helpers.JsonHelper');
Yii::import('helpers.AjaxParseHelper');
Yii::import('helpers.ModelHelper');
Yii::import('managers.schedule.ScheduleManager');
Yii::import('managers.templateWorkDay.TemplateWorkDayManager');
Yii::import('utils.ResponseWriter');
Yii::import('utils.Application');
Yii::import('utils.JsonEncoder');

class ScheduleController extends AdminController
{
    public $layout = '//layouts/admin';
    public $scheduleMenu = null;
    
    const DAY_IS_NOT_EXISTS_RESPONSE_JSON_PROPERTY_NAME = 'dayIsNotExists';
    const TEMPLATE_IS_NOT_EXISTS_RESPONSE_JSON_PROPERTY_NAME = 'templateIsNotExists';
    
    
    const NEXT_GET_VAR_REQUEST_VALUE = 'next';
    const PREV_GET_VAR_REQUEST_VALUE = 'prev';
    const BEGIN_GET_VAR_REQUEST_VALUE = 'begin';
    
    // Используется в разных местах - и в css-классах и внутри тегов
    // и для обозначения индекса массивов. 
    // Но значение самого idDoctor(если для  специализации он не нужен)
    // в каких-либо возвращаемых значениях(в Json, например),
    // будет равно просто null, а не 'null'
    const ID_DOCTOR_TEXT_VIEW_WHEN_SPECIALIZATION_DOES_NOT_NEED_DOCTOR = 'null';
    
    const STATE_STORE_PUBLISHED_VALUE = 'published';
    const STATE_STORE_NOT_PUBLISHED_VALUE = 'notPublsed';
    const STATE_STORE_NOT_CREATED_VALUE = 'notCreated';
    const ID_WORK_DAY_STORE_NOT_CREATED_VALUE = '';
    
    const STATE_VIEW_PUBLISHED_VALUE = '+';
    const STATE_VIEW_NOT_PUBLISHED_VALUE = '.';
    const STATE_VIEW_NOT_CREATED_VALUE = ' ';
          
    public function init() {
        parent::init();
                
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
            'ajaxOnly + getCommon',
            'ajaxOnly + getGroup',
            'ajaxOnly + getSpecialization',
            'ajaxOnly + getDoctor',
            'ajaxOnly + getWorkDayById',
            'ajaxOnly + getWorkDayByAttributes',
            'ajaxOnly + createWorkDay',
            'ajaxOnly + updateWorkDay',
            'ajaxOnly + deleteWorkDays',
            'ajaxOnly + updatePublishedInWorkDays',
            'ajaxOnly + getTemplateWorkDay',
            'ajaxOnly + acceptTemplateWorkDay',
            'ajaxOnly + deleteForCommon',
            'ajaxOnly + deleteForGroup',
            'ajaxOnly + deleteForSpecialization',
            'ajaxOnly + deleteForDoctor',
            'ajaxOnly + updateWorkTimeState',
            'ajaxOnly + deleteWorkTime'
        );
    }
    
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array(
                    'index',
                    'common', 
                    'group',
                    'specialization',
                    'doctor',
                    'getCommon',
                    'getGroup',
                    'getSpecialization',
                    'getDoctor',
                    'getWorkDayById',
                    'getWorkDayByAttributes'
                ),
                'roles' => array(Operations::VIEW_SCHEDULE), 
            ),
            array(
                'allow',
                'actions' => array(
                    'manage', 
                    'createWorkDay', 
                    'updateWorkDay', 
                    'deleteWorkDays',
                    'updatePublishedInWorkDays',
                    'getTemplateWorkDay',
                    'acceptTemplateWorkDay',
                    'deleteForCommon',
                    'deleteForGroup',
                    'deleteForSpecialization',
                    'deleteForDoctor',
                    'updateWorkTimeState',
                    'deleteWorkTime'
                ),
                'roles' => array(Operations::MANAGE_SCHEDULE), 
            ),
            array('deny', 'users' => array('*') ),
        );
    }
    
    public function actionIndex() {
        $this->render('index');
    }
    
    public function actionManage() {
        $this->render('manage');
    }
      
    public function actionCommon()
    {        
        $scheduleManager = new ScheduleManager();
        $tableBasis = $scheduleManager->getBasisForCommonSchedule();
        
        $dates = $this->createDatesStartingWithCurrent();
        $beginDate = $dates[0];
        $endDate = $dates[count($dates) - 1];
        
        $workDays = $scheduleManager->getWorkDaysForCommonSchedule($beginDate, $endDate);
        $workDaysPHPArray = $this->createWorkDaysPHPArray($workDays, $dates);
        
        $this->render(
            'common', 
            array(
                'model' => $tableBasis,
                'dates' => $dates,
                'workDays' => $workDaysPHPArray 
            )
        );
    }	
    
    public function actionGroup($idGroup)
    {        
        $scheduleManager = new ScheduleManager();
        $tableBasis = $scheduleManager->getBasisForGroupSchedule($idGroup);
        
        $dates = $this->createDatesStartingWithCurrent();
        $beginDate = $dates[0];
        $endDate = $dates[count($dates) - 1];
        
        $workDays = $scheduleManager->getWorkDaysForGroupSchedule($beginDate, $endDate, $idGroup);
        $workDaysPHPArray = $this->createWorkDaysPHPArray($workDays, $dates);
        
        $this->render(
            'group', 
            array(
                'model' => $tableBasis,
                'dates' => $dates,
                'workDays' => $workDaysPHPArray,
                'idGroup' => $idGroup
            )
        );
    }
    
    public function actionSpecialization($idSpecialization)
    {        
        $scheduleManager = new ScheduleManager();
        $tableBasis = $scheduleManager->getBasisForSpecializationSchedule($idSpecialization);
        
        $dates = $this->createDatesStartingWithCurrent();
        $beginDate = $dates[0];
        $endDate = $dates[count($dates) - 1];
        
        $workDays = $scheduleManager->getWorkDaysForSpecializationSchedule($beginDate, $endDate, $idSpecialization);
        $workDaysPHPArray = $this->createWorkDaysPHPArray($workDays, $dates);
        
        $this->render(
            'specialization', 
            array(
                'model' => $tableBasis,
                'dates' => $dates,
                'workDays' => $workDaysPHPArray,
                'idSpecialization' => $idSpecialization
            )
        );
    }
    
    public function actionDoctor($idDoctor) {
        $scheduleManager = new ScheduleManager();
        $tableBasis = $scheduleManager->getBasisForDoctorSchedule($idDoctor);
        
        $dates = $this->createDatesStartingWithCurrent();
        $beginDate = $dates[0];
        $endDate = $dates[count($dates) - 1];
        
        $workDays = $scheduleManager->getWorkDaysForDoctorSchedule($beginDate, $endDate, $idDoctor);
        $workDaysPHPArray = $this->createWorkDaysPHPArray($workDays, $dates);
        
        $this->render(
            'doctor', 
            array(
                'model' => $tableBasis,
                'dates' => $dates,
                'workDays' => $workDaysPHPArray,
                'idDoctor' => $idDoctor
            )
        ); 
    }
    
    public function actionGetCommon() {
        $date = $_POST['date'];
        $get = $_POST['get'];
        
        $dateVars = $this->prepareDifferentDateVariables($date, $get);
                
        $scheduleManager = new ScheduleManager();
        $workDays = $scheduleManager->getWorkDaysForCommonSchedule($dateVars['beginDate'], $dateVars['endDate']);
        $jsonEncoder = new JsonEncoder();
        $workDaysJson = $jsonEncoder->prepareWorkDaysToJsonEncode($workDays);
        
        $response = array(
            'dates' => $dateVars['datesText'], 
            'dateHeads' => $dateVars['dateHeads'], 
            'interval' => $dateVars['interval'],
            'workDays' => $workDaysJson
        );
        
        echo CJSON::encode($response);
    }
    
    public function actionGetGroup($idGroup) {
        $date = $_POST['date'];
        $get = $_POST['get'];
        
        $dateVars = $this->prepareDifferentDateVariables($date, $get);
     
        $scheduleManager = new ScheduleManager();
        $workDays = $scheduleManager->getWorkDaysForGroupSchedule($dateVars['beginDate'], $dateVars['endDate'], $idGroup);
        
        $jsonEncoder = new JsonEncoder();
        $workDaysJson = $jsonEncoder->prepareWorkDaysToJsonEncode($workDays);
    
        $response = array(
            'dates' => $dateVars['datesText'], 
            'dateHeads' => $dateVars['dateHeads'], 
            'interval' => $dateVars['interval'],
            'workDays' => $workDaysJson
        );
        
        echo CJSON::encode($response);   
    }
    
    public function actionGetSpecialization($idSpecialization) {
        $date = $_POST['date'];
        $get = $_POST['get'];
        
        $dateVars = $this->prepareDifferentDateVariables($date, $get);
     
        $scheduleManager = new ScheduleManager();
        $workDays = $scheduleManager->getWorkDaysForSpecializationSchedule($dateVars['beginDate'], $dateVars['endDate'], $idSpecialization);
       
        $jsonEncoder = new JsonEncoder();
        $workDaysJson = $jsonEncoder->prepareWorkDaysToJsonEncode($workDays);
        
        $response = array(
            'dates' => $dateVars['datesText'], 
            'dateHeads' => $dateVars['dateHeads'], 
            'interval' => $dateVars['interval'],
            'workDays' => $workDaysJson
        );
        
        echo CJSON::encode($response);   
    }
    
    public function actionGetDoctor($idDoctor) {
        $date = $_POST['date'];
        $get = $_POST['get'];
        
        $dateVars = $this->prepareDifferentDateVariables($date, $get);
     
        $scheduleManager = new ScheduleManager();
        $workDays = $scheduleManager->getWorkDaysForDoctorSchedule($dateVars['beginDate'], $dateVars['endDate'], $idDoctor);
        
        $jsonEncoder = new JsonEncoder();
        $workDaysJson = $jsonEncoder->prepareWorkDaysToJsonEncode($workDays);
        
        $response = array(
            'dates' => $dateVars['datesText'], 
            'dateHeads' => $dateVars['dateHeads'], 
            'interval' => $dateVars['interval'],
            'workDays' => $workDaysJson
        );
        
        echo CJSON::encode($response);   
    }
    
    public function actionGetWorkDayById() {
        $idWorkDay = $_POST['idWorkDay'];
        $scheduleManager = new ScheduleManager();
        $jsonEncoder = new JsonEncoder();
        
        try {
            $workDay = $scheduleManager->getWorkDayWithTimeById($idWorkDay);
        } 
        catch (RowIsNotExistsException $e) {
            $dayIsNotExistsJson = array(self::DAY_IS_NOT_EXISTS_RESPONSE_JSON_PROPERTY_NAME => Messages::WORK_DAY_IS_NOT_EXISTS);
            echo CJSON::encode($dayIsNotExistsJson);
            return;
        }
        
        $workDayJson = $jsonEncoder->prepareWorkDayWithTimeToJsonEncode($workDay);
        echo CJSON::encode($workDayJson);
    }
    
    public function actionGetWorkDayByAttributes() {
        $date = DateFormatHelper::getDateFromCommonTextView($_POST['date']);
        $idSpecialization = intval($_POST['idSpecialization']);
        if (isset($_POST['idDoctor']) ) {
            $idDoctor = intval($_POST['idDoctor']);
        } else {
            $idDoctor = null;
        }
        
        if(isset($_POST['offsetInDays']) ) {
            $offsetInDays = intval($_POST['offsetInDays']);
            $date = DateFormatHelper::shiftDateForSeveralDays($date, $offsetInDays);
        }
            
        $scheduleManager = new ScheduleManager();
        try {
            $workDay = $scheduleManager->getWorkDayWithTimeByAttributes($date, $idSpecialization, $idDoctor);
        } 
        catch (RowIsNotExistsException $e) {
            $dateTextView = DateFormatHelper::getDateCommonTextView($date);
            $responseJson = array(
                self::DAY_IS_NOT_EXISTS_RESPONSE_JSON_PROPERTY_NAME => Messages::WORK_DAY_IS_NOT_EXISTS,
                'date' => $dateTextView,
                'idDoctor' => $idDoctor,
                'idSpecialization' => $idSpecialization
            );
            echo CJSON::encode($responseJson);
            return;
        }
        
        $jsonEncoder = new JsonEncoder();
        $workDayJson = $jsonEncoder->prepareWorkDayWithTimeToJsonEncode($workDay);
        echo CJSON::encode($workDayJson);
    }
    
    public function actionCreateWorkDay() {        
        $date = DateFormatHelper::getDateFromCommonTextView($_POST['date']);
        $published  = AjaxParseHelper::getBoolean($_POST['published']);
        $idSpecialization = AjaxParseHelper::getInteger($_POST['idSpecialization']);
        if (!isset($_POST['idDoctor']) ) {
            $idDoctor = null;
        } else {
            $idDoctor = AjaxParseHelper::getInteger($_POST['idDoctor']);
        }
        
        $isWasTimeInPost = isset($_POST['time']) && isset($_POST['timeStates']);
        
        $scheduleManager = new ScheduleManager();
        if (!$isWasTimeInPost) {
            $result = $scheduleManager->createWorkDay($date, $idSpecialization, $idDoctor, $published);
        } else {
            $result =  $scheduleManager->createWorkDay($date, $idSpecialization, $idDoctor, $published, $_POST['time'], $_POST['timeStates']);      
        }
        
        $model = $result->model;
        if (!$result->isSuccess) {
            throw new ExecutionException();
        } 
        
        echo CJSON::encode(array('idWorkDay' => $model->id) );
    }
        
    public function actionUpdateWorkDay() {
        $idWorkDay = $_POST['id'];
        $published  = AjaxParseHelper::getBoolean($_POST['published']);
        $isWasTimeInPost = isset($_POST['time']) && isset($_POST['timeStates']);
        
        $scheduleManager = new ScheduleManager();
        if (!$isWasTimeInPost) {
            $result = $scheduleManager->updateWorkDayById($idWorkDay, $published);
        } else {
            $result = $scheduleManager->updateWorkDayById($idWorkDay, $published, $_POST['time'], $_POST['timeStates']);      
        }

        if (!$result->isSuccess) {
            throw new ExecutionException();
        } 
         
        $rw = new ResponseWriter();
        $rw->writeSuccessJson();
    }
    
    public function actionDeleteWorkDays() {
        $ids = $this->getIdsArrayFromPost();
        $scheduleManager = new ScheduleManager();
        $scheduleManager->deleteWorkDays($ids);
        $rw = new ResponseWriter();
        $rw->writeSuccessJson();
    } 
        
    public function actionUpdatePublishedInWorkDays() {        
        $published  = AjaxParseHelper::getBoolean($_POST['published']);
        $ids = $this->getIdsArrayFromPost();
        $scheduleManager = new ScheduleManager();
        $scheduleManager->updatePublishedInWorkDays($ids, $published);
        $rw = new ResponseWriter();
        $rw->writeSuccessJson();
    }
    
    public function actionGetTemplateWorkDay() {
        $idTemplateWorkDay = $_POST['idTemplateWorkDay'];
        $templateWorkDayManager = new TemplateWorkDayManager();
        $jsonEncoder = new JsonEncoder();
        
        try {
            $templateWorkDay = $templateWorkDayManager->getTemplateWorkDayWithTimeById($idTemplateWorkDay);
        } 
        catch (RowIsNotExistsException $e) {
            $templateIsNotExistsJson = array(self::TEMPLATE_IS_NOT_EXISTS_RESPONSE_JSON_PROPERTY_NAME => Messages::WORK_DAY_IS_NOT_EXISTS);
            echo CJSON::encode($templateIsNotExistsJson);
            return;
        }
        
        $workDayJson = $jsonEncoder->prepareTemplateWorkDayWithTimeToJsonEncode($templateWorkDay);
        echo CJSON::encode($workDayJson);
    }
    
    
    public function actionAcceptTemplateWorkDay() {
        $idTemplateWorkDay = $_POST['idTemplateWorkDay'];
        
        if (isset($_POST['idsWorkDay']) ) {
            $idsWorkDay = $_POST['idsWorkDay'];
        } else {
            $idsWorkDay = null;
        }
        
        if (isset($_POST['dates']) && isset($_POST['idsSpecialization']) && isset($_POST['idsDoctor'])) {
            $numberOfNewDays =  count($_POST['dates']);
            $dates = array();
            $idsSpecialization = array();
            $idsDoctor = array();
            for ($i = 0; $i < $numberOfNewDays; $i++) {
                $dates []= DateFormatHelper::getDateFromCommonTextView($_POST['dates'][$i]);
                $idsSpecialization []= AjaxParseHelper::getInteger($_POST['idsSpecialization'][$i]);
                $idsDoctor []= AjaxParseHelper::getIntegerOrNull($_POST['idsDoctor'][$i]);
            }
        } else {
            $dates = null;
            $idsSpecialization = null;
            $idsDoctor = null;
        }
        
        $scheduleManager = new ScheduleManager();
        $createdWorkDays = $scheduleManager->actionAcceptTemplateWorkDay($idTemplateWorkDay, $idsWorkDay, $dates, $idsSpecialization, $idsDoctor);  
        
        $jsonEncoder = new JsonEncoder();
        $createdWorkDaysJson = array();
        foreach($createdWorkDays as $wd) {
            $createdWorkDaysJson []= $jsonEncoder->prepareWorkDayToJsonEncode($wd);
        }
            
        echo CJSON::encode(array('createdWorkDays' => $createdWorkDaysJson) );
    }
    
    public function actionDeleteForCommon() {
        $formModel = $this->readDateActionFormModel();
        
        $beginDate = DateFormatHelper::getDateFromCommonTextView($formModel->dateBegin);
        $endDate = DateFormatHelper::getDateFromCommonTextView($formModel->dateEnd);
        $scheduleManager = new ScheduleManager();
        $scheduleManager->deleteFromCommonSchedule($beginDate, $endDate);
        $rw = new ResponseWriter();
        $rw->writeSuccessJson();
    }
    
    public function actionDeleteForGroup() {
        $idGroup = AjaxParseHelper::getInteger($_POST['idGroup']);
        $formModel = $this->readDateActionFormModel();
        
        $beginDate = DateFormatHelper::getDateFromCommonTextView($formModel->dateBegin);
        $endDate = DateFormatHelper::getDateFromCommonTextView($formModel->dateEnd);
        $scheduleManager = new ScheduleManager();
        $scheduleManager->deleteFromGroupSchedule($beginDate, $endDate, $idGroup);
        $rw = new ResponseWriter();
        $rw->writeSuccessJson();
    }
    
    public function actionDeleteForSpecializaton() {
        $idSpecialization= AjaxParseHelper::getInteger($_POST['idSpecialization']);
        $formModel = $this->readDateActionFormModel();

        $beginDate = DateFormatHelper::getDateFromCommonTextView($formModel->dateBegin);
        $endDate = DateFormatHelper::getDateFromCommonTextView($formModel->dateEnd);
        $scheduleManager = new ScheduleManager();
        $scheduleManager->deleteFromSpecializationSchedule($beginDate, $endDate, $idSpecialization);
        $rw = new ResponseWriter();
        $rw->writeSuccessJson();
    }
    
    public function actionDeleteForDoctor() {
        $idDoctor = AjaxParseHelper::getInteger($_POST['idDoctor']);
        $formModel = $this->readDateActionFormModel();
        
        $beginDate = DateFormatHelper::getDateFromCommonTextView($formModel->dateBegin);
        $endDate = DateFormatHelper::getDateFromCommonTextView($formModel->dateEnd);
        $scheduleManager = new ScheduleManager();
        $scheduleManager->deleteFromDoctorSchedule($beginDate, $endDate, $idDoctor);
        $rw = new ResponseWriter();
        $rw->writeSuccessJson();
    }
    
    public function actionUpdateWorkTimeState() {
        $idWorkDay = intval($_POST['idWorkDay']);
        $timeShortTextView = $_POST['time'];
        $state = $_POST['state'];
        $scheduleManager = new ScheduleManager();
        $scheduleManager->updateTimeState($idWorkDay, $timeShortTextView, $state);
        $rw = new ResponseWriter();
        $rw->writeSuccessJson();
    }
  
    public function actionDeleteWorkTime() {
        $idWorkDay = intval($_POST['idWorkDay']);
        $timeShortTextView = $_POST['time'];

        $scheduleManager = new ScheduleManager();
        $scheduleManager->deleteTime($idWorkDay, $timeShortTextView);
        $rw = new ResponseWriter();
        $rw->writeSuccessJson();
    }
    
    private function getIdsArrayFromPost() {
        if (isset($_POST['id']) ) {
            $ids = array($_POST['id']);
        } else if (isset($_POST['ids']) ) {
            $ids = $_POST['ids'];
        } else {
            throw new LogicException();
        }
        return $ids;
    }
    
    private function prepareDifferentDateVariables($date, $get) {
        if (!DateFormatHelper::checkDateInCommonTextView($date) ) {
            throw new InvalidArgumentException(Messages::NOT_CORRECT_DATE_FORMAT);
        }
        $basisDate = DateFormatHelper::getDateFromCommonTextView($date);
        
        // Определяем смещение начальной и канечной даты
        // относительно даты переданной функции в аргументе $date
        if ($get === self::NEXT_GET_VAR_REQUEST_VALUE) {
            $begin  = Values::ADMIN_SCHEDULE_DEFAULT_NUMBER_OF_DAYS;
            $end = 2 * Values::ADMIN_SCHEDULE_DEFAULT_NUMBER_OF_DAYS - 1;
        } else if ($get === self::PREV_GET_VAR_REQUEST_VALUE) {
            $begin = -Values::ADMIN_SCHEDULE_DEFAULT_NUMBER_OF_DAYS;
            $end = -1;
        } else if ($get === self::BEGIN_GET_VAR_REQUEST_VALUE) {
            $begin = 0;
            $end = Values::ADMIN_SCHEDULE_DEFAULT_NUMBER_OF_DAYS - 1;  
        } else {
            throw new LogicException();
        }
        
        $datesText = $this->getArrayOfCommonTextViewDates($basisDate, $begin, $end);
        $dateHeads = $this->getArrayOfDateHeads($basisDate, $begin, $end);
        
        $beginDate = DateFormatHelper::shiftDateForSeveralDays($basisDate, $begin);
        $endDate = DateFormatHelper::shiftDateForSeveralDays($basisDate, $end);
        $interval = DateFormatHelper::getIntervalOfDatesTextView($beginDate, $endDate);
        
        return array(
            'beginDate' => $beginDate,
            'endDate' => $endDate, 
            'datesText' => $datesText, 
            'dateHeads' => $dateHeads,
            'interval' => $interval
        );
    }
    
    // Преобразует заданные рабочие дни в массив, который используется
    // при начальном отображении рабочих дней в расписании.
    // При получении расписания через ajax не используется.
    function createWorkDaysPHPArray($workDays, $dates) {
        $dbDatesToIndex = $this->createArrayToGetDateIndexOnDateDBView($dates);
        
        $workDaysArray = array();
        foreach($workDays as $wd) {
            if ($wd->idDoctor !== null) {
               $idDoctor = $wd->idDoctor;
            } else {
                $idDoctor = self::ID_DOCTOR_TEXT_VIEW_WHEN_SPECIALIZATION_DOES_NOT_NEED_DOCTOR;
            }

            $idSpecialization = $wd->idSpecialization;
            $dateIndex = $dbDatesToIndex[$wd->date];
            $published = $wd->published;
            $id = $wd->id;
            
            $workDaysArray[$dateIndex][$idSpecialization][$idDoctor] = array(
                'published' => $published,
                'id' => $id
            );
        }   
        
        return $workDaysArray;
    }
    
    // Создаёт массив с элементами ключ которых - представление даты в базе данных 
    // а значение индекс столбца таблицы с рассписанием, т.е $dbDatesToIndex['YYYY-MM-DD'] = index,
    // на основе массива с датами(формата PHP).
    // Нужен для того, чтобы узнать индекс столбца для 
    // даты полученной из базы данных.
    private function createArrayToGetDateIndexOnDateDBView($dates) {
        $dbDatesToIndex = array();
        for ($i = 0; $i < count($dates); $i++) {
            $dbDate = DateFormatHelper::getDateDBView($dates[$i]);
            $dbDatesToIndex[$dbDate] = $i;
        }
        return $dbDatesToIndex;
    }
               
    private function getArrayOfCommonTextViewDates($basisDate, $begin, $end) {
        $dates = array();  
        for ($i = $begin; $i <= $end; $i++) {
            $offestDate = DateFormatHelper::shiftDateForSeveralDays($basisDate, $i);
            $dates[] = DateFormatHelper::getDateCommonTextView($offestDate);
        }
        return $dates;
    }
    
    private function getArrayOfDateHeads($basisDate, $begin, $end) {
        $dates = array();  
        for ($i = $begin; $i <= $end; $i++) {
            $offestDate = DateFormatHelper::shiftDateForSeveralDays($basisDate, $i);
            $dates[] = DateFormatHelper::getDateScheduleHeadCellTextView($offestDate);
        }
        return $dates;    
    }
        
    private function createDatesStartingWithCurrent() {
        $currentDate = Application::getInstance()->getCurrentDateTime();
        $dates = array();
        for ($i = 0; $i < Values::ADMIN_SCHEDULE_DEFAULT_NUMBER_OF_DAYS; $i++) {
            $offestDate = DateFormatHelper::shiftDateForSeveralDays($currentDate, $i);
            $dates[] = $offestDate;
        }
        
        return $dates;
    }
     
}
