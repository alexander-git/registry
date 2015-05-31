<?php

Yii::import('ext.actions.AdvancedCaptchaAction');

Yii::import('constant.Values');
Yii::import('utils.Application');
Yii::import('utils.JsonEncoder');
Yii::import('utils.ResponseWriter');
Yii::import('helpers.DateFormatHelper');
Yii::import('helpers.TimeFormatHelper');
Yii::import('helpers.DateTimeFormatHelper');
Yii::import('helpers.DateTimeHelper');
Yii::import('managers.group.GroupManager');
Yii::import('managers.specialization.SpecializationManager');
Yii::import('managers.doctor.DoctorManager');
Yii::import('managers.visitorSchedule.VisitorScheduleManager');
Yii::import('managers.order.OrderManager');
Yii::import('managers.order.OrderAttributes');

class RecordController extends VisitorController
{
    const ID_DOCTOR_WHEN_SPECIALIZATION_NOT_NEED_DOCTOR_REQUEST_PARAM_VALUE = 'null';
    
    public $layout = "recordApp";
     
    public function filters()
    {
        return array(
            // Из-за особенностей пересылки  в angular фильтр ajax-only
            // не работает. Поэтому таких правил не добавляем. 
            /*
            'ajaxOnly + navigationData',
             */
        );
    }
    
    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'AdvancedCaptchaAction',
                'foreColor' => 0x006A86,
                'testLimit' => 1,
            ),
        );
    }
    
    public function actionIndex()
    {
        $currentDateTime = Application::getInstance()->getCurrentDateTime();
        $this->render('index', array('currentDateTime' => $currentDateTime) );
    }

    public function actionGroups() {
        $groupManager = new GroupManager();
        $groups = $groupManager->getGroupsByEnabled(true);
        $jsonEncoder = new JsonEncoder();
        $groupsJson = $jsonEncoder->prepareGroupsToJsonEncode($groups);
        echo CJSON::encode($groupsJson);
    }
    
    public function actionSpecializations($idGroup) {
        $specializationManager = new SpecializationManager();
        $specializations = $specializationManager->getSpecializationsByIdGroupAndEnabled($idGroup, true);
        $jsonEncoder = new JsonEncoder();
        $specializationsJson = $jsonEncoder->prepareSpecializationsToJsonEncode($specializations);
        echo CJSON::encode($specializationsJson);
    }
    
    public function actionDoctors($idSpecialization) {
        $doctorManager = new DoctorManager();
        $doctors = $doctorManager->getDoctorsByIdSpecializationAndEnabled($idSpecialization, null);
        $jsonEncoder = new JsonEncoder();
        $doctorsJson = $jsonEncoder->prepareDoctorsWithoutInfoToJsonEncode($doctors);
        echo CJSON::encode($doctorsJson);
    }
    
    public function actionSchedule() { 
        //Смещение в днях от текущей даты
        $dayOffset = intval($_GET['dayOffset']);
        if ($dayOffset < 0) {
            $dayOffset = 0;
        }
        
        $idSpecialization = intval($_GET['idSpecialization']);
        $idDoctor = $_GET['idDoctor'];
        if ($idDoctor === self::ID_DOCTOR_WHEN_SPECIALIZATION_NOT_NEED_DOCTOR_REQUEST_PARAM_VALUE) {
            $idDoctor = null;
        } else {
            $idDoctor = intval($idDoctor);
        }
        
        // Создадим даты для расписания
        $dates = $this->createDatesWithOffsetFromCurrent($dayOffset);
        $numberOfDates = count($dates);
        $beginDate = $dates[0];
        $endDate = $dates[$numberOfDates - 1];
        
        // Готовим интервал дат для отображения и заголовки ячеек таблицы
        $interval = DateFormatHelper::getIntervalOfDatesTextView($beginDate, $endDate);
        $dateHeads = $this->createArrayOfDateHeads($dates);
        
        // Получаем нужные данные
        $visitorScheduleManager = new VisitorScheduleManager();
        $workDays = $visitorScheduleManager->getWorkDaysForSchedule($beginDate, $endDate, $idSpecialization, $idDoctor);
        $freeTimeCounts = $visitorScheduleManager->getCountsOfFreeWorkTimeForSchedule($beginDate, $endDate, $idSpecialization, $idDoctor);
        $allTimeCounts = $visitorScheduleManager->getCountsOfAllWorkTimeForSchedule($beginDate, $endDate, $idSpecialization, $idDoctor);
       
        // Создам массивы в которых в случае отсутствия данных для нужной даты
        // элемент с индексом соответсвующей дате будет null
        $dbDatesToIndex = $this->createArrayToGetDateIndexOnDateDBView($dates);
        $workDaysFull = $this->createWorkDaysFullArray($workDays, $dbDatesToIndex);
        $freeTimeCountsFullArray = $this->createTimeCountsFullArray($freeTimeCounts, $dbDatesToIndex);
        $allTimeCountsFullArray = $this->createTimeCountsFullArray($allTimeCounts, $dbDatesToIndex);
        
        $this->prepareScheduleDataAccordingStartingOffsetInDays($dayOffset, $workDaysFull, $freeTimeCountsFullArray, $allTimeCountsFullArray);
        
        // Готовим рабочие дни к кодированию в json
        $jsonEncoder = new JsonEncoder();
        $workDaysJson = array();
        foreach ($workDaysFull as $wd) {
            if ($wd === null) { 
                //Если элемент равен null, то он уже готов к записи. Поэтому просто запишем null
                $workDaysJson []= null;
            } else {
                $workDaysJson []= $jsonEncoder->prepareWorkDayToJsonEncode($wd);
            }
        }
        
        echo CJSON:: encode(
                array(
                    'workDays' => $workDaysJson,
                    'intervalHtmlView' => $interval,
                    'dateHeads' => $dateHeads,
                    'freeTimeCounts' => $freeTimeCountsFullArray,
                    'allTimeCounts' => $allTimeCountsFullArray
                )
            );
    }
    
    public function actionDay() {
        $dateText = $_GET['date'];
        if (!DateFormatHelper::checkDateInCommonTextView($dateText) ) {
            throw new ExecutionException();
        }
        $date = DateFormatHelper::getDateFromCommonTextView($dateText);
        if ($this->isDateLeatherThenCurrentDate($date) ) {
            throw new ExecutionException();
        }
        
        // Получаем предыдущую и следующую дату.
        // Их текстовое представление будут использоваться в ссылках.
        $previousDate = DateFormatHelper::shiftDateForSeveralDays($date, -1);
        $nextDate = DateFormatHelper::shiftDateForSeveralDays($date, +1);
        
        
        // Если предыдущая дата не должна быть доступна, то вернём null
        $previosDateText = null;  
        if ($this->isDateLeatherThenCurrentDate($previousDate) ) {
            $previosDateText = null;
        } else {
            $previosDateText = DateFormatHelper::getDateCommonTextView($previousDate);
        }
        $nextDateText = DateFormatHelper::getDateCommonTextView($nextDate);
        
        $result['dateTextView'] = DateFormatHelper::getDateTextViewWithRussianMounth($date);
        $result['previousDate'] = $previosDateText;
        $result['nextDate'] = $nextDateText;
        
        echo CJSON::encode($result);
    }
    
    public function actionMakeOrder() {
        // Так делаем из-за особенностей отправки Post-запроса angular-ом.
        $params = CJSON::decode(trim(file_get_contents('php://input') ), true); 
        if (!isset($params['captchaCode']) ) {
            throw new ExcecutionException(); 
        }
        $captchaForm = new OrderFormCaptcha();
        $captchaForm->captchaCode = $params['captchaCode'];
        
        // Проверяем captcha
        $captchaValid = true;
        if (!$captchaForm->validate() ) {
           $captchaErrorMessage = $captchaForm->getError('captchaCode');
           $captchaValid = false;
        } 
        
        $idSpecialization = intval($params['Order']['idSpecialization']);
        $idDoctor = null;
        if ($params['Order']['idDoctor'] === null) {
            $idDoctor = null;
        } else {
            $idDoctor = intval($params['Order']['idDoctor']);
        }
        
        if (!DateFormatHelper::checkDateInCommonTextView($params['Order']['date']) ) {
            // Проверяем правильно ли вообще введена дата. Т.е нет ли там 30 февраля и т.д.
            throw new ExecutionException();
        }
        $date = DateFormatHelper::getDateFromCommonTextView($params['Order']['date']);
 
        if (!TimeFormatHelper::checkTimeInShortTextView($params['Order']['time']) ) {
            throw new ExcecutionException();
        } 
        $timeShortTextView = $params['Order']['time'];
        
        if(!$this->checkDataStateForOrder($idSpecialization, $idDoctor, $date, $timeShortTextView) ) {
            throw new ExecutionException();
        }

        $orderAttributes = new OrderAttributes();
        $orderAttributes->idSpecialization = $idSpecialization;
        $orderAttributes->idDoctor = $idDoctor;
        $orderAttributes->date = $date;
        $orderAttributes->timeShortTextView = $timeShortTextView;
        $orderAttributes->firstname =  $params['Order']['firstname'];
        $orderAttributes->surname = $params['Order']['surname'];
        if (isset($params['Order']['patronymic']) ) {
            $orderAttributes->patronymic = $params['Order']['patronymic'];
        } else {
            $orderAttributes->patronymic = '';
        }
        $orderAttributes->phone = $params['Order']['phone'];
        
        $phonePattern = ApplicationConfig::getInstance()->getPhonePattern();
        $isPhonePatternEmpty = ($phonePattern === null) || ($phonePattern === '');
        $orderManager = new OrderManager();
        
        // Если captcha введена неверно, то провалидируем значения формы 
        // и отправим найденные ошибки пользователю. 
        if (!$captchaValid) {
            if ($isPhonePatternEmpty) {
                $validationOrderResult = $orderManager->validateOrderAttributesForMakeNewOrder($orderAttributes);
            } else {
                $validationOrderResult = $orderManager->validateOrderAttributesForMakeNewOrder($orderAttributes, $phonePattern);  
            }
            $validationErros = $validationOrderResult->getErrorsAsArray();
            
            $errors = array();
            if ($validationErros !== null) {
                $errors = $validationErros;
                $errors['captchaCode'] = $captchaErrorMessage;
            } else {
                 $errors['captchaCode'] = $captchaErrorMessage;            
            }
            
            echo CJSON::encode(array('errors' => $errors) );
            return;
        }
        
        $isNeedMakeTimeBusy = ApplicationConfig::getInstance()->getMakeTimeBusyOnOrder();
        if ($isPhonePatternEmpty) {
            $makeNewOrderResult = $orderManager->createNewOrder($orderAttributes, null, $isNeedMakeTimeBusy);
        } else {
            $makeNewOrderResult = $orderManager->createNewOrder($orderAttributes, $phonePattern, $isNeedMakeTimeBusy);
        }

        if (!$makeNewOrderResult->isSuccess) {
            $errors = $makeNewOrderResult->validationResult->getErrorsAsArray();
            echo CJSON::encode(array('errors' => $errors) );
            return;
        } else {
            $responseWriter = new ResponseWriter();
            $responseWriter->writeSuccessJson();
            return;
        }
    }
    
    public function actionNavigationData() { 
        // Ангуляр передает данные с использованием Content-Type: application/json 
        // и строки JSON, которую РНР не преобразуют в объект.
        // Поэтому когда данные передаются angular-методом 
        // $http(с настройкой 'method' - POST) напрямую массив $_POST использовать нельзя.
        $params = json_decode(trim(file_get_contents('php://input')), true);
                
        $result = array();
        $jsonEncoder = new JsonEncoder();
        
        if (isset($params['idGroup']) ) {
            $groupManager = new GroupManager();
            $group = $groupManager->getGroupById($params['idGroup']);
            if (!$group->enabled) {
                throw new ExecutionException();
            }
            $result['group'] = $jsonEncoder->prepareGroupToJsonEncode($group);
        }
        
        if (isset($params['idSpecialization']) ) {
            $specializationManager = new SpecializationManager();
            $specialization = $specializationManager->getSpecializationById($params['idSpecialization']);
            if (!$specialization->enabled) {
                throw new ExecutionException();
            }
            $result['specialization'] = $jsonEncoder->prepareSpecializationToJsonEncode($specialization);
        }
    
        if (isset($params['idDoctor']) && ($params['idDoctor'] !== self::ID_DOCTOR_WHEN_SPECIALIZATION_NOT_NEED_DOCTOR_REQUEST_PARAM_VALUE) ) {
            $doctorManager = new DoctorManager();
            $doctor = $doctorManager->getDoctorById($params['idDoctor']);
            if (!$doctor->enabled) {
                throw new ExecutionException();
            }
            $result['doctor'] = $jsonEncoder->prepareDoctorWithoutInfoToJsonEncode($doctor);
        }
        
        // Возможно $workDay понадобиться дальше если запрошено время, поэтому создаём переменную для него.
        // Если день не найден, то она так и останется равной null.
        $workDay = null;
        // Если нужно получаем рабочий день на основе даты, id Специализации и id Врача.
        if (isset($params['workDay']) ) {
            $parmasWorkDay = $params['workDay'];
            if (!isset($parmasWorkDay['idDoctor']) || !isset($parmasWorkDay['idSpecialization']) ) {
                throw new ExecutionException();
            }
            $idSpecialization = $parmasWorkDay['idSpecialization'];
            if ($parmasWorkDay['idDoctor'] === self::ID_DOCTOR_WHEN_SPECIALIZATION_NOT_NEED_DOCTOR_REQUEST_PARAM_VALUE) {
                $idDoctor = null;
            } else {
                $idDoctor = intval($parmasWorkDay['idDoctor']);
            }
            
            if (!DateFormatHelper::checkDateInCommonTextView($parmasWorkDay['date']) ) {
                // Проверяем правильно ли вообще введена дата. Т.е нет ли там 30 февраля и т.д.
                throw new ExecutionException();
            }
            
            $date = DateFormatHelper::getDateFromCommonTextView($parmasWorkDay['date']);
            
            // Порядок проверки 
            // 1)Если запрашиваемы дата меньше текущей выбрасывается исключение
            // 2)Если дата не должа отображаться из-за установленного в настройках смещения
            //   то возвращаем null
            // 3)Если день не опубликован(но разумеется его дата доступна), то возвращаем null
          
            // Проверяем не пытается ли пользователь с помощью манипуляций значениями в 
            // адресной строке получить доступ к дате котрая меньше текущей.
            if ($this->isDateLeatherThenCurrentDate($date) ) {
                throw new ExecutionException();
            }
            $workDay = null;
            // Проверяем случай когда когда дата больше текущей но из-за смещения недоступна
            // $workDay в этом случае будет пустым
            if(!$this->isDateIsAccessibleInVisitorSchedule($date) ) {
                $workDay = null;
            } else {      
                // Иначе извлекаем его из базы данных
                $visitorScheduleManager = new VisitorScheduleManager();
                try {
                    $workDay = $visitorScheduleManager->getWorkDayWithTimeByAttribres($idSpecialization, $idDoctor, $date);
                    // Если день не опубикован то пользователю отображать его не надо
                    if (!$workDay->published) {
                        $workDay = null;   
                    }
                } catch (RowIsNotExistsException $e) {
                    $workDay = null;
                }
            }
            
            if ($workDay !== null) {
                $result['workDay'] = $jsonEncoder->prepareWorkDayWithTimeToJsonEncode($workDay);
            } else {
                $result['workDay'] = null;   
            }
        }
        
        // Если нужно ищем определённое время свзяанное с данным рабочим днём
        if (isset($params['time']) ) {
            // Рабочий день обязательно должен существавать иначе это неверный запрос
            if (!isset($params['workDay']) || ($workDay === null) ) {
                throw new ExcecutionException();   
            }
            
            if (!TimeFormatHelper::checkTimeInUrlView($params['time']) ) {
                throw new ExcecutionException();
            } 
            $timeText = TimeFormatHelper::timeUrlViewViewToTimeShortTextView($params['time']);
            
            $workTime = null;
            foreach($workDay->time as $t) {
                $convertedTime = TimeFormatHelper::timeDBViewToTimeShortTextView($t->time);
                if ($convertedTime === $timeText) {
                    $workTime = $t;
                    break;
                }
            }
            
            // Если $workTime === null, то это значит, что пользователь запрашивает время
            // несуществующее в БД - скорее всего с помощью манипуляций адресной строкой.
            // Хотя теоретически между временем запроса пользователя и поиском 
            // WorkTime с таким временем может быть и удалён из базы данных оператором.
            if ($workTime === null) {
                throw new ExcecutionException();
            }
            
            $result['workTime'] = $jsonEncoder->prepareWorkTimeToJsonEncocode($workTime); 
        }
        
        echo CJSON::encode($result);
    }
    
    // Создаёт массив(список проиндексированный с 0) по следующим правилам: 
    // 1)Количество элементов такое же как в массиве $dbDatesToIndex.
    // 2)Каждый элемент ассоциирован с датой. Дата увеличивается с минимальной
    //   до максимальной с шагом в 1 день. Т.е нулевой элемент связан с минимальнйо датой,
    //   первый с минимальной датой + 1 и т.д.
    // 3)Если в $workDays есть элемент с нужной датой, то в он записывется в элемент результирующего 
    //   массива с соответствующим индексом.
    // 4)Если элемента с нужной датой в $workDays нет, то он заполняется null-ом. 
    private function createWorkDaysFullArray($workDays, $dbDatesToIndex) {
        $sizeOfFullArray = count($dbDatesToIndex);
        $result = array_fill(0, $sizeOfFullArray, null);
        foreach ($workDays as $wd) {
            $index = $dbDatesToIndex[$wd->date];
            $result[$index] = $wd;
        }
        return $result;
    }
    
    // $timeCountsArray - массив(список) массивов. Элементами главного массива являются массивы
    // состоящие из трёх элементов - id, date, count.
    // Правила анологичны функции createWorkDaysFullArray, только в результирующий массив 
    // записывается не элемент из $timeCountsArray, а только значение count из этого элемента
    private function createTimeCountsFullArray($timeCountsArray, $dbDatesToIndex) {
        $sizeOfFullArray = count($dbDatesToIndex);
        $result = array_fill(0, $sizeOfFullArray, null);
        foreach ($timeCountsArray as $tc) {
            $index = $dbDatesToIndex[$tc['date']];
            $result[$index] = $tc['count'];
        }
        return $result;
    }
    
    // Если нужно показывать пользователю расписание не с текущей даты 
    // а с некоторым смещением от неё, то устанавливаем данные для расписания,
    // даты у которых меньше (текущей + смещение) в null.
    // Если смещение в настройках установленно в 0, то никаких изменений в данных разумеется не будет.
    // Также никаких изменений в данных не будет если запрашивается расписание с началной датай
    // большей чем текущая дата + смещение.
    // $currentOffset - смещение для расписание заданное при запросе
    // $startingOffset - берётся из настроек
    private function prepareScheduleDataAccordingStartingOffsetInDays(
            $currentOffset, 
            &$workDaysFull, 
            &$freeTimeCountsFullArray, 
            &$allTimeCountsFullArray
        )
    {
        $startingOffset = ApplicationConfig::getInstance()->getStartingOffsetInDaysOfScheduleForVisitors();
        $index = 0;
        while ($currentOffset < $startingOffset) {
            $workDaysFull[$index] = null;
            $freeTimeCountsFullArray[$index] = null;
            $allTimeCountsFullArray[$index] = null;
            ++$index;
            ++$currentOffset;
        }
    }
    
    private function createDatesWithOffsetFromCurrent($dayOffset = 0) {
        $currentDate = Application::getInstance()->getCurrentDate();
        $numberDates = Values::VISITOR_SCHEDULE_DEFAULT_NUMBER_OF_DAYS;
        
        $dates = array();
        for ($i = $dayOffset; $i < $dayOffset + $numberDates; $i++) {
            $date = DateFormatHelper::shiftDateForSeveralDays($currentDate, $i);
            $dates[] = $date;
        }
        
        return $dates;
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
                   
    private function createArrayOfDateHeads($dates) {
        $dateHeads = array();  
        for ($i = 0; $i < count($dates); $i++) {
            $date = $dates[$i];
            $dateHeads[$i]['dayOfWeek'] = DateFormatHelper::getRussianDayOfWeekLongName($date);
            $dateHeads[$i]['date'] = DateFormatHelper::getDayNumberAndRussianMounthNameWithEndingTextView($date);
        }
        return $dateHeads;    
    }
    
    // Сравнивает только даты - время не учитывает
    private function isDateLeatherThenCurrentDate($date) {
        // Получаем сегодняшнюю дату со временим установленным на начало суток  
        $currentDate = Application::getInstance()->getCurrentDate();
        // Сбрасываем время у полученной даты к началу суток
        $dateWithResetTime = DateFormatHelper::getCopyOfDateWithResetTime($date);
        
        
        // Код, который работает в любой версии php >= 5.2
        $compareResult = DateTimeHelper::compare($dateWithResetTime, $currentDate);
        if ($compareResult === -1) {
            return true;
        } else {
            return false;
        }
        
        /*
        // Первоночально написанный код для весии php >= 5.3  
        // Вычитает из аргумента функции объект.
        // $dateWithResetTime - $currentDate
        $interval = $currentDate->diff($dateWithResetTime); 
        if ($interval->invert) {
            return true;
        } else {
            return false;
        }
        */
    }
            
    private function isDateIsAccessibleInVisitorSchedule($date) {
        // Получаем сегодняшнюю дату со временим установленным на начало суток  
        $currentDate = Application::getInstance()->getCurrentDate();
        // Сбрасываем время у полученной даты к началу суток
        $dateWithResetTime = DateFormatHelper::getCopyOfDateWithResetTime($date);
        
        $startingOffset = ApplicationConfig::getInstance()->getStartingOffsetInDaysOfScheduleForVisitors();
        $minAccessibleData = DateFormatHelper::shiftDateForSeveralDays($currentDate, $startingOffset);
       
        
        // Код, который работает в любой версии php >= 5.2
        $compareResult = DateTimeHelper::compare($dateWithResetTime, $minAccessibleData);
        if ($compareResult === -1) {
            return false;
        } else {
            return true;
        }
        
        /*
        // Первоночально написанный код для весии php >= 5.3  
        // Вычитает из аргумента функции объект. Т.е. $dateWithResetTime - $minAccessibleData
        $interval = $minAccessibleData->diff($dateWithResetTime); 
        if ($interval->invert) {
            return false;
        } else {
            return true;
        } 
        */
    }
    
    // Проверяет данные нужные для оформления заявки.
    // Если они не соответствуют друг-другу или при таком состоянии базы данных 
    // создание заявки не может быть выполнено, то вернёт false.
    private function checkDataStateForOrder($idSpecialization, $idDoctor, $date, $timeShortTextView) {
        // Специализация должна быть включена и у неё должна быть установлена "запись на время". 
        $specializationManager = new SpecializationManager();
        try {
            $specialization = $specializationManager->getSpecializationWithGroupById($idSpecialization);
        } 
        catch (RowIsNotExistsException $e) {
            throw new ExecutionException();
        }
        if (!$specialization->enabled) {
            throw new ExecutionException();
        }
        if (!$specialization->recordOnTime) {
            throw new ExecutionException();
        }
        // Для специализации должна быть указана группа.
        if ($specialization->group === null) {
            throw new ExecutionException();
        }
        // Группа должна быть включена.
        if (!$specialization->group->enabled) {
            throw new ExecutionException();
        }

        if (!$specialization->needDoctor) {
            // Для специализации не нужне врач, но он указан.
            if ($idDoctor !== null) {
                throw new ExecutionException();
            }
        } else {
            $doctorManager = new DoctorManager();
            try {
                $doctor = $doctorManager->getDoctorWithSpecializationsById($idDoctor);
            }
            catch (RowIsNotExistsException $e) {
                throw new ExcecutionException(); 
            }
            // Врач должен быть включён.
            if (!$doctor->enabled) {
                throw new ExecutionException();
            }

            // Врач должен иметь нужную специализацию.
            $isDoctorHasThatSpecialization = false;
            foreach ($doctor->specializations as $s) {
                if (intval($s->id) === $idSpecialization) {
                    $isDoctorHasThatSpecialization = true;
                    break;
                }
            }
            if (!$isDoctorHasThatSpecialization) {
                throw new ExecutionException();
            }
        }
            
        // Проверяем не пытается ли пользователь с помощью манипуляций значениями в 
        // адресной строке получить доступ к дате котрая меньше текущей.
        if ($this->isDateLeatherThenCurrentDate($date) ) {
            throw new ExecutionException();
        }
        
        // Проверяем случай когда когда дата больше текущей, но из-за смещения недоступна.
        if(!$this->isDateIsAccessibleInVisitorSchedule($date) ) {
            throw new ExecutionException();
        }     
        
        // День должен быть опубликован.
        $visitorScheduleManager = new VisitorScheduleManager();
        try {
            $workDay = $visitorScheduleManager->getWorkDayWithTimeByAttribres($idSpecialization, $idDoctor, $date);
            if (!$workDay->published) {
                throw new ExecutionException();
            }
        } catch (RowIsNotExistsException $e) {
            // День должен существовать.
            throw new ExecutionException();
        }
        
        $workTime = null;
        foreach($workDay->time as $t) {
            $convertedTime = TimeFormatHelper::timeDBViewToTimeShortTextView($t->time);
            if ($convertedTime === $timeShortTextView) {
                $workTime = $t;
                break;
            }
        }
        // Время не найдено.
        if ($workTime === null) {
            throw new ExecutionException();
        }
        
        return true;
    }
    
}