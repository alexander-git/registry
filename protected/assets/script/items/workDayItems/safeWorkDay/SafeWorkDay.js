// SafeWorkDay позволяет изменять только информацию о состоянии 
// времени в рабочем дне. Причём нельзя добавлять новые элементы - можно только
// изменить их состояние(занят, свободен и т.д) или удалить. Менять состояние 
// дня - опубликован он или нет также нельзя.

var SafeWorkDay = function(id, urls, viewMode) {
      
    var VIEW_MODE = viewMode;
    var ID = id;
    var DURATION_OF_SHOW_INFO_MESSAGE = 5 * 1000;
    
    var AjaxRequestTimeStateValues = {
        'FREE' : TimeItemState.FREE,
        'BUSY' : TimeItemState.BUSY,
        'RECORD_IMPOSSIBLE' : TimeItemState.RECORD_IMPOSSIBLE
    };

    var Sel = new SafeWorkDaySelectors(ID);    // Селекторы и css-классы
 
    // Внутренние переменные
    //////////////////////////////////////////////////////////////////////////// 
    var _workDayModel;
    var _urls = urls;
    var _eventGenerator = new EventGenerator();
    var _timeEditor = new TimeEditor(ID); 
    
    init();
    
    function init() {
        var modifyTimeFunctions = new ModifyTimeFunctions();
        modifyTimeFunctions.makeFree = makeTimeFree;
        modifyTimeFunctions.makeBusy = makeTimeBusy;
        modifyTimeFunctions.makeRecordImpossible =  makeTimeRecordImpossible;
        modifyTimeFunctions.delete = deleteTime;
        _timeEditor.setModifyTimeFunctions(modifyTimeFunctions);
    }
          
    // Регистрация событий 
    ////////////////////////////////////////////////////////////////////////////
 
    // Щелчки по кнопкам
    ////////////////////////////////////////////////////////////////////////////
    $(Sel.NEXT_BUTTON_FULL_SELECTOR).click(function() {
        getWorkDayByAttributesAjaxRequest(1); 
    });
   
    $(Sel.PREVIOUS_BUTTON_FULL_SELECTOR).click(function() {
        getWorkDayByAttributesAjaxRequest(-1); 
    });
   
    $(Sel.QUIT_BUTTON_FULL_SELECTOR).click(function() {
        if (VIEW_MODE === SafeWorkDayViewMode.DIALOG) {
            $(Sel.SAFE_WORK_DAY_FULL_SELECTOR).dialog('close'); 
        }
    });
    
    //////////////////////////////////////////////////////////////////////////// 
     
    // Вызывается когда нужно подготовить SafeWorkDay для работы
    // с опредёлённым днём из расписания.
    this.prepare = function(workDayInfo, getWorkDayByAttributes) {
        _workDayModel = new WorkDayModel();
        _workDayModel.prepare(workDayInfo);

        updateGeneralInfoView(workDayInfo);
        updatePublishedView(null);
        hideDayIsNotExistsMessage();
        
        hideElementsRelatedToAjax();
        _timeEditor.prepare();
        
        if (VIEW_MODE === SafeWorkDayViewMode.DIALOG) {
            $(Sel.SAFE_WORK_DAY_FULL_SELECTOR).dialog('option', 'position', 'center top+5%');
            $(Sel.SAFE_WORK_DAY_FULL_SELECTOR).dialog('open'); 
        } else {
            // Другие режимы пока не поддерживаются.
            throw new Error();
        }
       
        if (!getWorkDayByAttributes) {
            var isDayExists = workDayInfo.idWorkDay !== null; 
            if (isDayExists) {
                beforeAjaxUpdate();
                var ajaxData = {
                    'idWorkDay' : _workDayModel.idWorkDay
                };
                ajaxRequest(_urls.getWorkDayById, ajaxData, getWorkDaySuccess);
            } else {
                showDayIsNotExistsMessage();
            }
        } else {
            getWorkDayByAttributesAjaxRequest(); 
        }
    };   
    
    this.addEventListener = function(eventListener) {
        _eventGenerator.addEventListener(eventListener);
    };
    
    this.removeEventListener = function(eventListener) {
        _eventGenerator.removeEventListener(eventListener);
    };

    ////////////////////////////////////////////////////////////////////////////

    function hideElementsRelatedToAjax() {
        $(Sel.ERROR_MESSAGE_FULL_SELECTOR).hide();
        $(Sel.INFO_MESSAGE_FULL_SELECTOR).hide();
        $(Sel.PROCESS_FULL_SELECTOR).hide();
    }
   
    function updateGeneralInfoView(data) {
        $(Sel.DATE_FULL_SELECTOR).text(data.date);
        $(Sel.SPECIALIZARTION_NAME_FULL_SELECTOR).text(data.specializationName);
        if (data.idDoctor !== null) {
            $(Sel.DOCTOR_INFO_FULL_SELECTOR).show();
            $(Sel.DOCTOR_NAME_FULL_SELECTOR).text(data.doctorName);
        } else {
            $(Sel.DOCTOR_INFO_FULL_SELECTOR).hide();
        }
    }
    
    function updatePublishedView(published) {
        if (published !== null) {
            $(Sel.PUBLISHED_INFO_FULL_SELECTOR).show();
            if (published) {
                $(Sel.PUBLISHED_FULL_SELECTOR).text(SafeWorkDayConst.YES_PUBLISHED_TEXT);
            } else {
                $(Sel.PUBLISHED_FULL_SELECTOR).text(SafeWorkDayConst.NO_PUBLISHED_TEXT);
            }
        } else {
            $(Sel.PUBLISHED_INFO_FULL_SELECTOR).hide();
        }
    }
    
    function showInfoMessage(message) {
        var infoMessage = $(Sel.INFO_MESSAGE_FULL_SELECTOR);
        infoMessage.text(message);
        infoMessage.show();
        setTimeout(function() { infoMessage.hide(); }, DURATION_OF_SHOW_INFO_MESSAGE);
    }
    
    function showDayIsNotExistsMessage() {
        $(Sel.DAY_IS_NOT_EXISTS_MESSAGE_FULL_SELECTOR).show();
    }
    
    function hideDayIsNotExistsMessage() {
        $(Sel.DAY_IS_NOT_EXISTS_MESSAGE_FULL_SELECTOR).hide();
    }
    
    function updateViewAccordingWorkDayModel() {
        updateGeneralInfoView(_workDayModel);
        updatePublishedView(_workDayModel.published);
        var isDayExists = _workDayModel.idWorkDay !== null;
        if (!isDayExists) {
            showDayIsNotExistsMessage();
        } else {
            hideDayIsNotExistsMessage();
        }
    }

    function getWorkDayByAttributesAjaxRequest(offsetInDays) {
        beforeAjaxUpdate();
        var ajaxData = {
            'date' : _workDayModel.date,
            'idSpecialization' : _workDayModel.idSpecialization,
        }; 
        // Если специализация не требует врача, то idDoctor 
        // просто не посылаем.
        if (_workDayModel.idDoctor !== null) { 
            ajaxData['idDoctor'] = _workDayModel.idDoctor; 
        }
         if (offsetInDays !== undefined) {
            ajaxData['offsetInDays'] = offsetInDays; 
        }
        
        ajaxRequest(_urls.getWorkDayByAttributes, ajaxData, getWorkDaySuccess);
    }
    
    function updateTimeStateAjaxRequest(timeTextView, state, successFunction) {
        beforeAjaxUpdate();
        var ajaxData = {
            'idWorkDay' : _workDayModel.idWorkDay,
            'time' : timeTextView,
            'state' : state
        }; 
       
        ajaxRequest(
            _urls.updateTimeState, 
            ajaxData, 
            function(data, textStatus, jqXHR) {
                successFunction();
                afterAjaxUpdate();
            }
        );
    }
    
    function deleteTimeAjaxRequest(timeTextView, successFunction) {
        beforeAjaxUpdate();
        var ajaxData = {
            'idWorkDay' : _workDayModel.idWorkDay,
            'time' : timeTextView
        }; 
       
        ajaxRequest(
            _urls.deleteTime, 
            ajaxData, 
            function(data, textStatus, jqXHR) {
                successFunction();
                afterAjaxUpdate();
            }
        );
    }
    
    // Функции используются для инициализации полей объекта 
    // ModifyTimeFunctions, который будет передан в timeEditor.
    function makeTimeFree(timeTextView, successFunction) {
        updateTimeStateAjaxRequest(timeTextView, AjaxRequestTimeStateValues.FREE, successFunction);
    }
    
    function makeTimeBusy(timeTextView, successFunction) {
        updateTimeStateAjaxRequest(timeTextView, AjaxRequestTimeStateValues.BUSY, successFunction);
    }
    
    function makeTimeRecordImpossible(timeTextView, successFunction) {
        updateTimeStateAjaxRequest(timeTextView, AjaxRequestTimeStateValues.RECORD_IMPOSSIBLE, successFunction);
    }
    
    function deleteTime(timeTextView, successFunction) {
        deleteTimeAjaxRequest(timeTextView, successFunction);
    }
    
    
    // Получение ответов на ajax-запросы
    //////////////////////////////////////////////////////////////////////////// 
    function getWorkDaySuccess(data, textStatus, jqXHR) {
        if (data.dayIsNotExists !== undefined) {   
            if (data.date !== undefined) {
                _workDayModel.date = data.date;
            }
            _workDayModel.setDayIsNotExists();
            
            updateViewAccordingWorkDayModel();
            _timeEditor.prepare();
            
            _eventGenerator.generateEvent(WorkDayEvents.WORK_DAY_IS_NOT_EXISTS, {
                'date' : _workDayModel.date,
                'idSpecialization' : _workDayModel.idSpecialization,
                'idDoctor' : _workDayModel.idDoctor
            });
            
        } else {
            _workDayModel.date = data.date;
            _workDayModel.idWorkDay = parseInt(data.id);
            _workDayModel.published = data.published;
            
            updateViewAccordingWorkDayModel();
            _timeEditor.prepare(data.time);

            _eventGenerator.generateEvent(WorkDayEvents.WORK_DAY_RECEIVED, {
                'date' : _workDayModel.date,
                'idSpecialization' : _workDayModel.idSpecialization,
                'idDoctor' : _workDayModel.idDoctor,
                'idWorkDay' : _workDayModel.idWorkDay,
                'published' : _workDayModel.published 
            });
            
        }
        afterAjaxUpdate();
    }
      
    // Основные функции используемые при ajax-запросах
    ////////////////////////////////////////////////////////////////////////////
    function ajaxRequest(url, data, successFunction) {
        $.ajax({
            'url' : url,
            'data' : data,
            'type' : 'POST',
            'dataType' : 'json',
            'success' : successFunction,
            'error' : ajaxRequestError
        });
    }
    
    function ajaxRequestError(jqXHR, textStatus, errorThrown) {
        $(Sel.ERROR_MESSAGE_FULL_SELECTOR).show();
        afterAjaxUpdate();
    }
    
    
    function beforeAjaxUpdate() {
       $(Sel.ERROR_MESSAGE_FULL_SELECTOR).hide();
       $(Sel.INFO_MESSAGE_FULL_SELECTOR).hide();
       $(Sel.PROCESS_FULL_SELECTOR).show();
    }
    
    function afterAjaxUpdate() {
        $(Sel.PROCESS_FULL_SELECTOR).hide();
    }
    
};
