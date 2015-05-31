var WorkDay = function(id, urls, viewMode) {
      
    var VIEW_MODE = viewMode;
    var ID = id;
    var DURATION_OF_SHOW_INFO_MESSAGE = 5 * 1000;

    var Sel = new WorkDaySelectors(ID);    // Селекторы и css-классы
 
    // Внутренние переменные
    //////////////////////////////////////////////////////////////////////////// 
    var _useMode = null;
    var _workDayModel = null;
    var _urls = urls;
    var _eventGenerator = new EventGenerator();
    var _timeEditor = new TimeEditor(ID); 
                 
    // Регистрация событий 
    ////////////////////////////////////////////////////////////////////////////
 
    // Щелчки по кнопкам
    ////////////////////////////////////////////////////////////////////////////
    $(Sel.PERFORM_BUTTON_FULL_SELECTOR).click(function(e) {
        if (_useMode === WorkDayUseMode.CREATE) {
            createWorkDay();
        } else if (_useMode === WorkDayUseMode.UPDATE) {
            updateWorkDay();
        }
    });
    
    $(Sel.NEXT_BUTTON_FULL_SELECTOR).click(function() {
        getWorkDayByAttributesAjaxRequest(1); 
    });
   
    $(Sel.PREVIOUS_BUTTON_FULL_SELECTOR).click(function() {
        getWorkDayByAttributesAjaxRequest(-1); 
    });
    
    
    $(Sel.QUIT_BUTTON_FULL_SELECTOR).click(function() {
        if (VIEW_MODE === WorkDayViewMode.DIALOG) {
            $(Sel.WORK_DAY_FULL_SELECTOR).dialog('close'); 
        }
    });
    
    ////////////////////////////////////////////////////////////////////////////
    
    // Инициализация WorkDay перед работой 
    this.prepare = function(useMode, workDayInfo) {
        _useMode = useMode;
        _workDayModel = new WorkDayModel();
        _workDayModel.prepare(workDayInfo);
        

        updateGeneralInfoView(workDayInfo);
        if (_useMode === WorkDayUseMode.CREATE) {
            updatePublishedView(false);
            showDayIsNotExistsMessage();
        } else if (_useMode === WorkDayUseMode.UPDATE) {
            // Установим сейчас переданное значение, но после загрузки 
            // оно может измениться. Потом мы обновим его.
            // Также нужно понимать, что загрузка может пройти неудачно.
            updatePublishedView(workDayInfo.published);
            hideDayIsNotExistsMessage();
        } 

        hideElementsRelatedToAjax();
        _timeEditor.prepare();
        if (VIEW_MODE === WorkDayViewMode.DIALOG) {
            $(Sel.WORK_DAY_FULL_SELECTOR).dialog('option', 'position', 'center top+5%');
            $(Sel.WORK_DAY_FULL_SELECTOR).dialog('open'); 
        }
       
        if (_useMode === WorkDayUseMode.UPDATE) {
            beforeAjaxUpdate();
            var ajaxData = {
                'idWorkDay' : _workDayModel.idWorkDay
            };
            ajaxRequest(_urls.getWorkDayById, ajaxData, getWorkDaySuccess);
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
        if (published) {
            $(Sel.PUBLISHED_FULL_SELECTOR).attr('checked', 'checked');
        } else {
            $(Sel.PUBLISHED_FULL_SELECTOR).removeAttr('checked');
        }
    }
    
    function updateViewAccordingWorkDayModel() {
        updateGeneralInfoView(_workDayModel);
        
        var isDayExists = _workDayModel.idWorkDay !== null;
        if (isDayExists) {
            updatePublishedView(_workDayModel.published);
            hideDayIsNotExistsMessage();
        } else {
            // Если день не существует, 
            // то по умолчанию делаем его перед созданием неопубликованным.
            updatePublishedView(false);
            showDayIsNotExistsMessage();
        }
    }
    
    
    function showDayIsNotExistsMessage() {
        $(Sel.DAY_IS_NOT_EXISTS_MESSAGE_FULL_SELECTOR).show();
    }
    
    function hideDayIsNotExistsMessage() {
        $(Sel.DAY_IS_NOT_EXISTS_MESSAGE_FULL_SELECTOR).hide();
    }
    
    
    function showInfoMessage(message) {
        var infoMessage = $(Sel.INFO_MESSAGE_FULL_SELECTOR);
        infoMessage.text(message);
        infoMessage.show();
        setTimeout(function() { infoMessage.hide(); }, DURATION_OF_SHOW_INFO_MESSAGE);
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
    
    function createWorkDay() {
        var published = getPublished();
         _workDayModel.prepareChanges({ 'published' : published } );

         var ajaxData = {
             'date' : _workDayModel.date,
             'idSpecialization' : _workDayModel.idSpecialization,
             'published' : published,
             'time[]' : _timeEditor.getTimeTextViews(),
             'timeStates[]' : _timeEditor.getTimeStates()
         };
         if (_workDayModel.idDoctor !== null) {
            ajaxData['idDoctor'] = _workDayModel.idDoctor;
         } 

         beforeAjaxUpdate();
         ajaxRequest(_urls.createWorkDay, ajaxData, createWorkDaySuccess);
    }
    
    function updateWorkDay() {
        var published = getPublished();
        _workDayModel.prepareChanges({ 'published' : published } );

        var ajaxData = {
            'id' : _workDayModel.idWorkDay,
            'published' : published,
            'time[]' : _timeEditor.getTimeTextViews(),
            'timeStates[]' : _timeEditor.getTimeStates()
        };

        beforeAjaxUpdate();
        ajaxRequest(_urls.updateWorkDay, ajaxData, updateWorkDaySuccess);
    }
    
    function getPublished() {
        return $(Sel.PUBLISHED_FULL_SELECTOR).is(':checked');
    }
    
    // Получение ответов на ajax-запросы
    //////////////////////////////////////////////////////////////////////////// 
    function getWorkDaySuccess(data, textStatus, jqXHR) {
        if (data.dayIsNotExists !== undefined) {   
            if (data.date !== undefined) {
                _workDayModel.date = data.date;
            }
            _workDayModel.setDayIsNotExists();
            
            _useMode = WorkDayUseMode.CREATE;
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
            
            _useMode = WorkDayUseMode.UPDATE;
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
      
    function createWorkDaySuccess(data, textStatus, jqXHR) {
        // Теперь день будет не создаваться, а обновляться
        _useMode = WorkDayUseMode.UPDATE;
        
        _workDayModel.idWorkDay = parseInt(data.idWorkDay);
        _workDayModel.acceptChanges();
        
        hideDayIsNotExistsMessage();
        // Т.к. за время отрправки/получения ответа на запрос 
        // пользователь мог изменить состояние элементов управления, то 
        // мы не делаем updatePublishedView и т.д.
        
        _eventGenerator.generateEvent(WorkDayEvents.WORK_DAY_CREATE, {
            'date' : _workDayModel.date,
            'idSpecialization' : _workDayModel.idSpecialization,
            'idDoctor' : _workDayModel.idDoctor,
            'idWorkDay' : _workDayModel.idWorkDay,
            'published' : _workDayModel.published 
        });
        
        showInfoMessage(WorkDayConst.CREATE_WORK_DAY_SUCCESS);
        afterAjaxUpdate();
    }
    
    function updateWorkDaySuccess(data, textStatus, jqXHR) {
        showInfoMessage(WorkDayConst.UPDATE_WORK_DAY_SUCCESS);
        afterAjaxUpdate();
        _workDayModel.acceptChanges();
        
        _eventGenerator.generateEvent(WorkDayEvents.WORK_DAY_UPDATE, {
            'date' : _workDayModel.date,
            'idSpecialization' : _workDayModel.idSpecialization,
            'idDoctor' : _workDayModel.idDoctor,
            'idWorkDay' : _workDayModel.idWorkDay,
            'published' : _workDayModel.published
        });
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
