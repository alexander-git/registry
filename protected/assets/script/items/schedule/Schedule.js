var Schedule = function(urls) {
    
    // Константы используемые при отправке ajax-запросов, изменении состояния ячеек рассписания и т.д
    ////////////////////////////////////////////////////////////////////////////
    var NEXT_GET_VAR_REQUEST_VALUE = 'next';
    var PREV_GET_VAR_REQUEST_VALUE = 'prev';
    var BEGIN_GET_VAR_REQUEST_VALUE = 'begin';
    
    var ID_DOCTOR_TEXT_VIEW_WHEN_SPECIALIZATION_DOES_NOT_NEED_DOCTOR = 'null';
    var STATE_STORE_PUBLISHED_VALUE = 'published';
    var STATE_STORE_NOT_PUBLISHED_VALUE = 'notPublsed';
    var STATE_STORE_NOT_CREATED_VALUE = 'notCreated';
    var ID_WORK_DAY_STORE_NOT_CREATED_VALUE = '';
    
    var STATE_VIEW_PUBLISHED_VALUE = '+';
    var STATE_VIEW_NOT_PUBLISHED_VALUE = '.';
    var STATE_VIEW_NOT_CREATED_VALUE = ' ';
    
    var DURATION_OF_SHOW_AJAX_ERROR_MESSAGE = 5 * 1000;
    
    var Sel = new ScheduleSelectors(); // Селекторы и css-классы
    
    // Режимы работы
    //////////////////////////////////////////////////////////////////////////// 
    var NORMAL_MODE = 'normalMode';
    var SELECT_DESELECT_CELL_MODE = 'selectDeselectCellMode';
    var BEGIN_SELECT_AREA_MODE = 'beginSelectAreaMode';
    var END_SELECT_AREA_MODE = 'endSelectAreaMode';
    var BEGIN_DESELECT_AREA_MODE = 'beginDeselectAreaMode';
    var END_DESELECT_AREA_MODE = 'endDeselectAreaMode';
    var SAFE_UPDATE_DAY_MODE = 'safeUpdateDayMode';
    var CREATE_UPDATE_DAY_MODE = 'createUpdateDayMode';
    var DELETE_DAY_MODE = 'deleteDayMode';
    var PUBLISH_DEPUBLISH_DAY_MODE = 'publishDepublishDayMode';
    
    // Инициализация
    ////////////////////////////////////////////////////////////////////////////
    var _mode = NORMAL_MODE;
    var _urls;
    var _dates = initDates();
    var _selectedCellBegin;
    var _selectedCellEnd;
    var _modifyDayDialog = null;
    var _safeModifyDayDialog = null;
    var _viewTemplateWorkDayDialog = null;
    var _selectTemplateWorkDayDialog = null;
    // Текущий шаблон
    var _templateWorkDayInfo = null;
    // Выполняется ли в данный момент ajax-запрос
    var _isAjaxRequestPerformed = false;
    // Ячейка которая обрабатывается в данный момент ajax-запросом
    var _ajaxProcessedCells = null;
    
    // Объект для приёма событий от внешних объектов(диалоговых окон, например)
    var _eventListener = {};
    
    init(urls);
    
    function init(urls) {
        goToNormalMode();   
        _urls = urls;
    }
    
    function initDates() {
        // Создание массива с текущими датами даты по возрастанию значения
        var dates = new Array();
        $(Sel.DATES_STORE_ITEM_FULL_SELECTOR).each(function() {
            var number = parseInt($(this).find(Sel.DATES_STORE_DATE_NUMBER_SELECTOR).text() );
            var value = $(this).find(Sel.DATES_STORE_DATE_SELECTOR_PREFIX + number).text();
            dates[number] = value;
        });

       return dates;
    }
    
    this.setModifyDayDialog = function(modifyDayDialog) {
        _modifyDayDialog = modifyDayDialog;
        // Диалог будет уведомлять о произошедших событиях
        _modifyDayDialog.addEventListener(_eventListener);
    };
    
    this.setSafeModifyDayDialog = function(safeWorkDayDialog) {
        _safeModifyDayDialog = safeWorkDayDialog;
        _safeModifyDayDialog.addEventListener(_eventListener);
    };
    
    this.setViewTemplateWorkDayDialog = function(viewTemplateWorkDayDialog) {
        _viewTemplateWorkDayDialog = viewTemplateWorkDayDialog; 
    };
    
    this.setSelectTemplateWorkDayDialog = function(selectTemplateWorkDayDialog) {
        _selectTemplateWorkDayDialog = selectTemplateWorkDayDialog;
        _selectTemplateWorkDayDialog.addEventListener(_eventListener);
    };
    
    // Функиии для работы с внутренними перемненными
    ////////////////////////////////////////////////////////////////////////////
    function getDates() {
        return _dates;
    }
    
    function setDates(dates) {
        _dates = dates;
    }
    
    function createDatesTextViewToDateNumberArray() {
        var result = [];
        var dates = getDates();
        for (var i = 0;  i < dates.length; i++) {
            result[dates[i]] = i;
        }
        return result;
    }
    
    function getAjaxProcessedCells() {
        return _ajaxProcessedCells;
    }
    
    function setManyCellsToAjaxProcess(cells) {
        _ajaxProcessedCells = cells;
    }
    
    function setOneCellToAjaxProcess(cell) {
        _ajaxProcessedCells = [];
        _ajaxProcessedCells.push(cell);
    }
    
    function addCellToAjaxProcess(cell) {
        if (_ajaxProcessedCells === null) {
            _ajaxProcessedCells = [];
        }
         _ajaxProcessedCells.push(cell);
    }
    
    function isTemplateWorkDaySelected() {
        return _templateWorkDayInfo !== null;
    }
    
    // Регистрация событий от внешних объектов
    ////////////////////////////////////////////////////////////////////////////     
    $(_eventListener).on(WorkDayEvents.WORK_DAY_CREATE, function(e) {
        var cellSelector = createCellSelector(e.date, e.idSpecialization, e.idDoctor);
        var cell = $(cellSelector);
        updateSelectableCell(cell, e.published, e.idWorkDay);
    });
    
    $(_eventListener).on(WorkDayEvents.WORK_DAY_UPDATE, function(e) {
        var cellSelector = createCellSelector(e.date, e.idSpecialization, e.idDoctor);
        var cell = $(cellSelector);
        updateSelectableCell(cell, e.published, e.idWorkDay);
    });
    
    $(_eventListener).on(WorkDayEvents.WORK_DAY_RECEIVED, function(e) {
        var cellSelector = createCellSelector(e.date, e.idSpecialization, e.idDoctor);
        var cell = $(cellSelector);
        updateSelectableCell(cell, e.published, e.idWorkDay);
    });
    
    $(_eventListener).on(WorkDayEvents.WORK_DAY_IS_NOT_EXISTS, function(e) {
        var cellSelector = createCellSelector(e.date, e.idSpecialization, e.idDoctor);
        var cell = $(cellSelector);
        cellToNotCreatedState(cell);
    });
    
    $(_eventListener).on(SearchEvents.SELECT, function(e) {
        var idTemplateWorkDay = e.value;
        var name = e.text;
        _templateWorkDayInfo = {
            'idTemplateWorkDay' : idTemplateWorkDay,
            'name' : name
        };
        
        $(Sel.SELECT_TEMPLATE_WORK_DAY_INPUT_FULL_SELECTOR).val(name);
    });
    
    
    // Регистрация событий для элементов в рассписании
    ////////////////////////////////////////////////////////////////////////////
    
    // Щелчки по кнопкам
    ////////////////////////////////////////////////////////////////////////////
    $(Sel.NORMAL_MODE_BUTTON_FULL_SELECTOR).click(function() {
        goToNormalMode();
    });

    $(Sel.CELL_SELECT_DESELECT_BUTTON_FULL_SELECTOR).click(function() {
        if (checkRepeatedButtonClick(this) ) {
            return;
        }
        goToSelectDeselectCellMode();
    });

    $(Sel.AREA_SELECT_BUTTON_FULL_SELECTOR).click(function() {
        if (checkRepeatedButtonClick(this) ) {
            return;
        }
        goToBeginSelectAreaMode();
    });

    $(Sel.AREA_DESELECT_BUTTON_FULL_SELECTOR).click(function() {    
        if (checkRepeatedButtonClick(this) ) {
            return;
        }
        goToBeginDeselectAreaMode();
    });

    $(Sel.COMPLETELY_DESELECT_BUTTON_FULL_SELECTOR).click(function() {   
        clearSelectionCompletely();
    });
    
    $(Sel.SAFE_UPDATE_DAY_BUTTON_FULL_SELECTOR).click(function() {
        if (checkRepeatedButtonClick(this) ) {
            return;
        }
        goToSafeUpdateDayMode();
    });

    $(Sel.CREATE_UPDATE_DAY_BUTTON_FULL_SELECTOR).click(function() { 
        if (checkRepeatedButtonClick(this) ) {
            return;
        }
        goToCreateUpdateDayMode();
    });

    $(Sel.DELETE_DAY_BUTTON_FULL_SELECTOR).click(function() { 
        if (checkRepeatedButtonClick(this) ) {
            return;
        }
        goToDeleteDayMode();
    });

    $(Sel.PUBLISH_DEPUBLISH_DAY_BUTTON_FULL_SELECTOR).click(function() { 
        if (checkRepeatedButtonClick(this) ) {
            return;
        }
        goToPublishDepublishDayMode();
    });
        
    $(Sel.DELETE_SELECTED_BUTTON_FULL_SELECTOR).click(function() { 
        deleteSelectedIfPossible();
    });
    
    $(Sel.PUBLISH_SELECTED_BUTTON_FULL_SELECTOR).click(function() { 
        publishSelectedIfPossible();
    });

    $(Sel.DEPUBLISH_SELECTED_BUTTON_FULL_SELECTOR).click(function() { 
        depublishSelectedIfPossible();
    });
    
    $(Sel.ACCEPT_TEMPLATE_WORK_DAY_TO_SELECTED_BUTTON_FULL_SELECTOR).click(function() {
        acceptTemplateWorkDayToSelectedIfPossible();
    });
    
    $(Sel.VIEW_TEMPLATE_WORK_DAY_BUTTON_FULL_SELECTOR).click(function() {
        if (_templateWorkDayInfo === null) {
            return;
        }
        _viewTemplateWorkDayDialog.prepare(_templateWorkDayInfo);
    });
    
    $(Sel.SELECT_TEMPLATE_WORK_DAY_BUTTON_FULL_SELECTOR).click(function() {
        _selectTemplateWorkDayDialog.open();
    });
    
    $(Sel.CLEAR_TEMPLATE_WORK_DAY_BUTTON_FULL_SELECTOR).click(function() {
         _templateWorkDayInfo = null;
         $(Sel.SELECT_TEMPLATE_WORK_DAY_INPUT_FULL_SELECTOR).val('');
    }); 

    $(Sel.NEXT_DATE_BUTTON_FULL_SELECTOR).click(function() {
        var date = $(Sel.INITIAL_DATE_FULL_SELECTOR).text();
        beforeAjaxUpdate();
        postAjaxRequestToUpdateSchedule(date, NEXT_GET_VAR_REQUEST_VALUE);
    });

    $(Sel.PREV_DATE_BUTTON_FULL_SELECTOR).click(function() {
        var date = $(Sel.INITIAL_DATE_FULL_SELECTOR).text();
        beforeAjaxUpdate();
        postAjaxRequestToUpdateSchedule(date, PREV_GET_VAR_REQUEST_VALUE);
    });

    $(Sel.JUMP_DATE_BUTTON_FULL_SELECTOR).click(function() {
        var date = $(Sel.JUMP_DATE_INPUT_FIELD_FULL_SELECTOR).val();
        beforeAjaxUpdate();
        postAjaxRequestToUpdateSchedule(date, BEGIN_GET_VAR_REQUEST_VALUE);  
    });

    // Щелчок по ячейке таблицы
    ////////////////////////////////////////////////////////////////////////////
    $(Sel.SELECTABLE_CELL_FULL_SELECTOR).click(function() {
        var cell = this;
    
        if (_mode === SELECT_DESELECT_CELL_MODE) {
            selectDeselectCell(cell);
        } else if (_mode === BEGIN_SELECT_AREA_MODE) {
            _selectedCellBegin = cell;
            goToEndSelectAreaMode();
        } else if (_mode === END_SELECT_AREA_MODE) {
            _selectedCellEnd = cell;
            drawSelectionOnArea();
            goToBeginSelectAreaMode();                
        } else if (_mode === BEGIN_DESELECT_AREA_MODE) {
            _selectedCellBegin = cell;
            goToEndDeselectAreaMode();
        } else if (_mode === END_DESELECT_AREA_MODE) {
            _selectedCellEnd = cell;
            clearSelectionOnArea();
            goToBeginDeselectAreaMode();
        } else if (_mode === SAFE_UPDATE_DAY_MODE) {
            prepareToWorkSafeModifyDayDialog(cell);
        } else if (_mode === CREATE_UPDATE_DAY_MODE) {
            prepareToWorkWithModifyDayDialog(cell);
        } else if (_mode === DELETE_DAY_MODE) {
            deleteWorkDayIfPossible(cell);
        } else if (_mode === PUBLISH_DEPUBLISH_DAY_MODE ) {
            publishDepublishWorkDayIfPossible(cell);
        } 
    });
    
    // Изменение режима работы 
    ////////////////////////////////////////////////////////////////////////////
    function goToNormalMode() {
        _mode = NORMAL_MODE;
        deselectButtonsOnInstrumentalPanel();
        makeButtonActiveOnSelector(Sel.NORMAL_MODE_BUTTON_FULL_SELECTOR);
        prepareCorsurToWorkWithSelectableCellsAccordingCurrentMode();
    }
    
    function goToSelectDeselectCellMode() {
        _mode = SELECT_DESELECT_CELL_MODE;
        deselectButtonsOnInstrumentalPanel();
        makeButtonActiveOnSelector(Sel.CELL_SELECT_DESELECT_BUTTON_FULL_SELECTOR);
        prepareCorsurToWorkWithSelectableCellsAccordingCurrentMode();
    }
    
    function goToBeginSelectAreaMode() {
        _mode = BEGIN_SELECT_AREA_MODE;
        deselectButtonsOnInstrumentalPanel();
        makeButtonActiveOnSelector(Sel.AREA_SELECT_BUTTON_FULL_SELECTOR);
        prepareCorsurToWorkWithSelectableCellsAccordingCurrentMode();
    }
    
    function goToEndSelectAreaMode() {
        _mode = END_SELECT_AREA_MODE;
        prepareCorsurToWorkWithSelectableCellsAccordingCurrentMode();
    }
       
    function goToBeginDeselectAreaMode() {
        _mode = BEGIN_DESELECT_AREA_MODE;
        deselectButtonsOnInstrumentalPanel();
        makeButtonActiveOnSelector(Sel.AREA_DESELECT_BUTTON_FULL_SELECTOR);
        prepareCorsurToWorkWithSelectableCellsAccordingCurrentMode();
    }
    
    function goToEndDeselectAreaMode() {
        _mode = END_DESELECT_AREA_MODE;
        prepareCorsurToWorkWithSelectableCellsAccordingCurrentMode();
    }
    
    function goToSafeUpdateDayMode() {
        _mode = SAFE_UPDATE_DAY_MODE;
        deselectButtonsOnInstrumentalPanel();
        makeButtonActiveOnSelector(Sel.SAFE_UPDATE_DAY_BUTTON_FULL_SELECTOR);
        prepareCorsurToWorkWithSelectableCellsAccordingCurrentMode();
    }
    
    function goToCreateUpdateDayMode() {
        _mode = CREATE_UPDATE_DAY_MODE;
        deselectButtonsOnInstrumentalPanel();
        makeButtonActiveOnSelector(Sel.CREATE_UPDATE_DAY_BUTTON_FULL_SELECTOR);
        prepareCorsurToWorkWithSelectableCellsAccordingCurrentMode();
    }
    
    function goToDeleteDayMode() {
        _mode = DELETE_DAY_MODE;
        deselectButtonsOnInstrumentalPanel();
        makeButtonActiveOnSelector(Sel.DELETE_DAY_BUTTON_FULL_SELECTOR);
        prepareCorsurToWorkWithSelectableCellsAccordingCurrentMode();
    }
    
    function goToPublishDepublishDayMode() {
        _mode = PUBLISH_DEPUBLISH_DAY_MODE;
        deselectButtonsOnInstrumentalPanel();
        makeButtonActiveOnSelector(Sel.PUBLISH_DEPUBLISH_DAY_BUTTON_FULL_SELECTOR);
        prepareCorsurToWorkWithSelectableCellsAccordingCurrentMode();
    }
    
    // Изменение курсора
    ////////////////////////////////////////////////////////////////////////////
    function prepareCorsurToWorkWithSelectableCellsAccordingCurrentMode() {
        switch(_mode) {
            case NORMAL_MODE :
                $(Sel.SELECTABLE_CELL_FULL_SELECTOR).css('cursor', 'auto');
                break;
            case SELECT_DESELECT_CELL_MODE :
            case BEGIN_SELECT_AREA_MODE :
            case BEGIN_DESELECT_AREA_MODE :
            case SAFE_UPDATE_DAY_MODE :
            case CREATE_UPDATE_DAY_MODE :
            case DELETE_DAY_MODE :
            case PUBLISH_DEPUBLISH_DAY_MODE :
                $(Sel.SELECTABLE_CELL_FULL_SELECTOR).css('cursor', 'pointer');
                break;
            case END_SELECT_AREA_MODE :
            case END_DESELECT_AREA_MODE :
               $(Sel.SELECTABLE_CELL_FULL_SELECTOR).css('cursor', 'crosshair');
               break;
        }
    }
    
    // Вспомогательные функции
    ////////////////////////////////////////////////////////////////////////////
    function checkRepeatedButtonClick(button) {
        if ($(button).hasClass(Sel.INSTRUMENTS_ACTIVE_BUTTON_CLASS) ) {
            goToNormalMode();
            return true;
        } else {
            return false;
        }
    }
    
    function makeButtonActiveOnSelector(selector) {
        $(selector).addClass(Sel.INSTRUMENTS_ACTIVE_BUTTON_CLASS);
    }
    
    function deselectButtonsOnInstrumentalPanel() {
        $(Sel.INSTRUMENTS_ACTIVE_BUTTON_SELECTOR).removeClass(Sel.INSTRUMENTS_ACTIVE_BUTTON_CLASS);
    }
      
    // Работа с выделением
    ////////////////////////////////////////////////////////////////////////////
    function getSelectedAreaCoordinates() {
        var c1 = getCellCoordinates(_selectedCellBegin);
        var c2 = getCellCoordinates(_selectedCellEnd);
        
        var topRow = Math.min(c1.row, c2.row);
        var bottomRow = Math.max(c1.row, c2.row);
        var leftCol = Math.min(c1.col, c2.col);
        var rightCol = Math.max(c1.col, c2.col);
        
        return {
            'topRow' : topRow,
            'bottomRow' : bottomRow,
            'leftCol' : leftCol,
            'rightCol' : rightCol,
        };
    }
     
    function selectDeselectCell(cell) {
        if (isCellSelected(cell) ) {
            clearSelectionOnCell(cell);
        } else {
            drawSelectenOnCell(cell);
        }
    }
    
    function isCellSelected(cell) {
        var c = getCellCoordinates(cell);
        var selected = $(Sel.CELL_POSITION_FULL_SELECTOR_PREFIX + c.row + '_' + c.col).hasClass(Sel.SELECTABLE_CELL_SELECTED_CLASS);
        return selected;
    }
     
    function drawSelectenOnCell(cell) {
        var c = getCellCoordinates(cell);
        $(Sel.CELL_POSITION_FULL_SELECTOR_PREFIX + c.row + '_' + c.col).addClass(Sel.SELECTABLE_CELL_SELECTED_CLASS);
    }
     
    function clearSelectionOnCell(cell) {
        var c = getCellCoordinates(cell);
        $(Sel.CELL_POSITION_FULL_SELECTOR_PREFIX + c.row + '_' + c.col).removeClass(Sel.SELECTABLE_CELL_SELECTED_CLASS);
    }
    
     function drawSelectionOnArea() {
        var c = getSelectedAreaCoordinates();      
        for (var i = c.topRow; i <= c.bottomRow; i++) {
            for (var j = c.leftCol; j <= c.rightCol; j++) {
                $(Sel.CELL_POSITION_FULL_SELECTOR_PREFIX + i + '_' + j).addClass(Sel.SELECTABLE_CELL_SELECTED_CLASS);
            }
        }
    }
    
    function clearSelectionOnArea() {
        var c = getSelectedAreaCoordinates();      
        for (var i = c.topRow; i <= c.bottomRow; i++) {
            for (var j = c.leftCol; j <= c.rightCol; j++) {
                $(Sel.CELL_POSITION_FULL_SELECTOR_PREFIX + i + '_' + j).removeClass(Sel.SELECTABLE_CELL_SELECTED_CLASS);
            }
        }
    }
    
    function clearSelectionCompletely() {
        $(Sel.SELECTABLE_CELL_FULL_SELECTOR).removeClass(Sel.SELECTABLE_CELL_SELECTED_CLASS);
    }
    
    // Действия
    //////////////////////////////////////////////////////////////////////////// 
    function prepareToWorkSafeModifyDayDialog(cell) {
        var workDayInfo = getWorkDayInfo(cell);
        _safeModifyDayDialog.prepare(workDayInfo, false);
    }
    
    function prepareToWorkWithModifyDayDialog(cell) {       
        var workDayInfo = getWorkDayInfo(cell);
        
        var isDayCreated = workDayInfo['idWorkDay'] !== null;
        var workDayUseMode;
        if (isDayCreated) {
            workDayUseMode = WorkDayUseMode.UPDATE;
        } else {
            workDayUseMode = WorkDayUseMode.CREATE;
        }
        
        _modifyDayDialog.prepare(workDayUseMode, workDayInfo);
    }
    
    function getWorkDayInfo(cell) {
       var infoStore = $(cell).find(Sel.CELL_INFO_STORE_SELECTOR);
        var dateNumber = $(infoStore).find(Sel.DATE_NUMBER_STORE_SELECTOR).text();
        var state = $(infoStore).find(Sel.STATE_STORE_SELECTOR).text();
       
        var date = getDates()[dateNumber];
        var rowInfoStore = $(cell).parent('tr').find(Sel.ROW_INFO_STORE_SELECTOR);
        var idSpecialization = parseInt($(rowInfoStore).find(Sel.ID_SPECIALIZATION_STORE_SELECTOR).text());
        var specializationName = $(rowInfoStore).find(Sel.SPECIALIZATION_NAME_SELECTOR).text();
        var idDoctorText = $(rowInfoStore).find(Sel.ID_DOCTOR_STORE_SELECTOR).text();
        var doctorName = $(rowInfoStore).find(Sel.DOCTOR_NAME_STORE_SELECTOR).text();
       
        var idDoctor;
        if (idDoctorText === ID_DOCTOR_TEXT_VIEW_WHEN_SPECIALIZATION_DOES_NOT_NEED_DOCTOR) {
             idDoctor = null;
        } else {
            idDoctor = parseInt(idDoctorText);
        }
               
        var workDayInfo = {
            'idWorkDay' : null,
            'date' : date,
            'idSpecialization' : idSpecialization,
            'specializationName' : specializationName,
            'idDoctor' : idDoctor,
            'doctorName' : doctorName,
            'published' : null
        };
        
        var isDayCreated = (state === STATE_STORE_PUBLISHED_VALUE) || (state === STATE_STORE_NOT_PUBLISHED_VALUE);
        if (isDayCreated) {
            var idWorkDay = parseInt($(infoStore).find(Sel.ID_WORK_DAY_STORE_SELECTOR).text() );
            workDayInfo['idWorkDay'] = idWorkDay;
            if (state === STATE_STORE_PUBLISHED_VALUE) {
                workDayInfo['published'] = true;
            } else if (state ===  STATE_STORE_NOT_PUBLISHED_VALUE) {
                workDayInfo['published'] = false;
            }
        }
        return workDayInfo;
    }
    
    function deleteWorkDayIfPossible(cell) {
        if (_isAjaxRequestPerformed || !isCellCreated(cell) ) {
            return;
        }
        
        var idWorkDay = getIdWorkDayFromCell(cell);
        beforeAjaxUpdate();
        setOneCellToAjaxProcess(cell);
        var ajaxData = {
            'id' : idWorkDay
        };
        postAjaxToDeleteWorkDays(ajaxData); 
    }
    
    function publishDepublishWorkDayIfPossible(cell) {
        if (_isAjaxRequestPerformed || !isCellCreated(cell) ) {
            return;
        }
        
        var idWorkDay = getIdWorkDayFromCell(cell);
        var published = isCellPublished(cell);
        beforeAjaxUpdate();
        setOneCellToAjaxProcess(cell);
        var ajaxData = {
            'id' : idWorkDay,
            'published' : !published
        };
        if (published) {
            postAjaxToUpdatePublishedInWorkDays(ajaxData, depublishWorkDaySuccess);
        } else {
            postAjaxToUpdatePublishedInWorkDays(ajaxData, publishWorkDaySuccess);
        }
    }
    
    function deleteSelectedIfPossible() {
        if (_isAjaxRequestPerformed || !isExistsSelectedCreatedCells() ) {
            return;
        }
        if (!confirm(Const.CONFIRM_QUESTION) ) {
            return;
        }
        
        var cells = getSelectedCreatedCells();
        var idsWorkDay = getIdsWorkDayFromCells(cells);
        
        beforeAjaxUpdate();
        setManyCellsToAjaxProcess(cells);
        var ajaxData = {
            'ids[]' : idsWorkDay,
        };
        postAjaxToDeleteWorkDays(ajaxData);
    }
    
    function publishSelectedIfPossible() {
        if (_isAjaxRequestPerformed || !isExistsSelectedCreatedCells() ) {
            return;
        }
        if (!confirm(Const.CONFIRM_QUESTION) ) {
            return;
        }
        
        var cells = getSelectedCreatedCells();
        var idsWorkDay = getIdsWorkDayFromCells(cells);
        
        beforeAjaxUpdate();
        setManyCellsToAjaxProcess(cells);
        var ajaxData = {
            'ids[]' : idsWorkDay,
            'published' : true
        };
        postAjaxToUpdatePublishedInWorkDays(ajaxData, publishWorkDaySuccess);
    }
    
    function depublishSelectedIfPossible() {
        if (_isAjaxRequestPerformed || !isExistsSelectedCreatedCells() ) {
            return;
        }
        if (!confirm(Const.CONFIRM_QUESTION) ) {
            return;
        }
        
        var cells = getSelectedCreatedCells();
        var idsWorkDay = getIdsWorkDayFromCells(cells);
        
        beforeAjaxUpdate();
        setManyCellsToAjaxProcess(cells);
        var ajaxData = {
            'ids[]' : idsWorkDay,
            'published' : false
        };
        postAjaxToUpdatePublishedInWorkDays(ajaxData, depublishWorkDaySuccess);
    }
    
    function acceptTemplateWorkDayToSelectedIfPossible() {
        if (_isAjaxRequestPerformed || !isTemplateWorkDaySelected() || !isExistSelectedCells() ) {
            return;
        }
        if (!confirm(Const.CONFIRM_QUESTION) ) {
            return;
        }
        
        var idsWorkDay = [];
        var dates = [];
        var idsSpecialization = [];
        var idsDoctor = [];
        
        var cells = getSelectedCells();
        
        for (var i = 0; i < cells.length; i++) {
            var cell = cells[i];
            if (isCellCreated(cell) ) {
                idsWorkDay.push(getIdWorkDayFromCell(cell) );
            } else {
                dates.push(getDateFromCell(cell) );
                idsSpecialization.push(getIdSpecializationFromCell(cell) );
                idsDoctor.push(getIdDoctorFromCell(cell) );
            }
        }
        
        beforeAjaxUpdate();
        setManyCellsToAjaxProcess(cells);
        var ajaxData = {
            'idTemplateWorkDay' : _templateWorkDayInfo.idTemplateWorkDay,
            'idsWorkDay' : idsWorkDay,
            'dates' : dates,
            'idsSpecialization' : idsSpecialization,
            'idsDoctor' : idsDoctor
        };
        
        
        postAjaxToAcceptTemplateWorkDay(ajaxData);
    }
    
    // Работа с отдельной ячейкой
    ////////////////////////////////////////////////////////////////////////////
    function getCellCoordinates(cell) {
        var cellInfoStore = $(cell).find(Sel.CELL_INFO_STORE_SELECTOR);
        var row = parseInt($(cellInfoStore).find(Sel.ROW_STORE_SELECTOR).text() );
        var col = parseInt($(cellInfoStore).find(Sel.COL_STORE_SELECTOR).text() );
        return {
            row : row,
            col : col
        };
    }
     
    function isCellCreated(cell) {
        var infoStore = $(cell).find(Sel.CELL_INFO_STORE_SELECTOR);
        var state = $(infoStore).find(Sel.STATE_STORE_SELECTOR).text();
        if (state === STATE_STORE_NOT_CREATED_VALUE) { // Щелчёк по ячейке с незаданным расписанием        
             return false;
        }  else {
            return true;
        }
    }
    
    function isCellPublished(cell) {
        var infoStore = $(cell).find(Sel.CELL_INFO_STORE_SELECTOR);
        var state = $(infoStore).find(Sel.STATE_STORE_SELECTOR).text();
        if (state === STATE_STORE_PUBLISHED_VALUE) {        
             return true;
        }  else {
            return false;
        }
    }
    
    function getDateFromCell(cell) {
        var infoStore = $(cell).find(Sel.CELL_INFO_STORE_SELECTOR);
        var dateNumber = $(infoStore).find(Sel.DATE_NUMBER_STORE_SELECTOR).text();
       
        var date = getDates()[dateNumber];
        
        return date;
    }
    
    function getIdWorkDayFromCell(cell) {
        var infoStore = $(cell).find(Sel.CELL_INFO_STORE_SELECTOR);
        var idWorkDay = parseInt($(infoStore).find(Sel.ID_WORK_DAY_STORE_SELECTOR).text() );
        return idWorkDay;
    }
    
    function getIdSpecializationFromCell(cell) {
        var rowInfoStore = $(cell).parent('tr').find(Sel.ROW_INFO_STORE_SELECTOR);
        var idSpecialization = parseInt($(rowInfoStore).find(Sel.ID_SPECIALIZATION_STORE_SELECTOR).text());
        return idSpecialization;
    }
    
    function getIdDoctorFromCell(cell) {
        var rowInfoStore = $(cell).parent('tr').find(Sel.ROW_INFO_STORE_SELECTOR);
        var idDoctorText = $(rowInfoStore).find(Sel.ID_DOCTOR_STORE_SELECTOR).text();

        var idDoctor;
        if (idDoctorText === ID_DOCTOR_TEXT_VIEW_WHEN_SPECIALIZATION_DOES_NOT_NEED_DOCTOR) {
             idDoctor = null;
        } else {
            idDoctor = parseInt(idDoctorText);
        }
        
        return idDoctor;
    }
    
    function updateSelectableCell(cell, published, idWorkDay) {
        var state;
        var stateView;
        if (published) {
            state = STATE_STORE_PUBLISHED_VALUE;
            stateView = STATE_VIEW_PUBLISHED_VALUE;
        } else {
            state = STATE_STORE_NOT_PUBLISHED_VALUE;
            stateView = STATE_VIEW_NOT_PUBLISHED_VALUE;
        }

        $(cell).find(Sel.CELL_STATE_VIEW_SELECTOR).text(stateView);
        var infoStore = $(cell).find(Sel.CELL_INFO_STORE_SELECTOR);
        $(infoStore).find(Sel.STATE_STORE_SELECTOR).text(state);
        if (idWorkDay !== undefined) {
            $(infoStore).find(Sel.ID_WORK_DAY_STORE_SELECTOR).text(idWorkDay);
        }
    }
    
    function cellToNotCreatedState(cell) {
        $(cell).find(Sel.CELL_STATE_VIEW_SELECTOR).text(STATE_VIEW_NOT_CREATED_VALUE);
        var infoStore = $(cell).find(Sel.CELL_INFO_STORE_SELECTOR);
        $(infoStore).find(Sel.STATE_STORE_SELECTOR).text(STATE_STORE_NOT_CREATED_VALUE);
        $(infoStore).find(Sel.ID_WORK_DAY_STORE_SELECTOR).text(ID_WORK_DAY_STORE_NOT_CREATED_VALUE);
    }
    
    function updateCellPublishedState(cell, published) {
        var state;
        var stateView;
        if (published) {
            state = STATE_STORE_PUBLISHED_VALUE;
            stateView = STATE_VIEW_PUBLISHED_VALUE;
        } else {
            state = STATE_STORE_NOT_PUBLISHED_VALUE;
            stateView = STATE_VIEW_NOT_PUBLISHED_VALUE;
        }
        
        $(cell).find(Sel.CELL_STATE_VIEW_SELECTOR).text(stateView);
        var infoStore = $(cell).find(Sel.CELL_INFO_STORE_SELECTOR);
        $(infoStore).find(Sel.STATE_STORE_SELECTOR).text(state); 
    }
    
    function cellToPublishedState(cell) {
        updateCellPublishedState(cell, true);
    }
    
    function cellToNotPublishedState(cell) {
        updateCellPublishedState(cell, false);
    }
    
    ////////////////////////////////////////////////////////////////////////////
    
    function createCellSelector(date, idSpecialization, idDoctor, datesTextToDateNumber) {
        if (datesTextToDateNumber === undefined) {
            datesTextToDateNumber = createDatesTextViewToDateNumberArray();
        }
        
        if (idDoctor === null) {
            idDoctor = ID_DOCTOR_TEXT_VIEW_WHEN_SPECIALIZATION_DOES_NOT_NEED_DOCTOR;
        }

        var cellSelector = '.date_' + datesTextToDateNumber[date];
        cellSelector += '_specialization_' + idSpecialization;
        cellSelector += '_doctor_' + idDoctor;
        
        return cellSelector;
    }
    
    function getSelectedCells() {
        return $(Sel.SELECTED_CELL_FULL_SELECTOR);
    }
    
    function isExistSelectedCells() {
         return (getSelectedCells().length !== 0);
    }
    
    function getSelectedCreatedCells() {
        var cells = [];
        $(Sel.SELECTED_CELL_FULL_SELECTOR).each(function() {
            if (isCellCreated(this) ) {
                cells.push(this);
            }
        });
        
        return cells;
    }
    
    function isExistsSelectedCreatedCells() {
        return (getSelectedCreatedCells().length !== 0);
    }
    
    function updateAllSelectableCells(workDays) {
        selectableCellsToNotCreatedState();
        
        // Меняем состояние ячеек для которых создано рассписание
        updateSelectableCells(workDays);
    }
    
    function updateSelectableCells(workDays) {
        var datesTextToDateNumber = createDatesTextViewToDateNumberArray();
        for (var i = 0; i < workDays.length; i++) {
            var id = workDays[i].id;
            var idSpecialization = workDays[i].idSpecialization;
            var idDoctor = workDays[i].idDoctor;
            var published = workDays[i].published;
            var date = workDays[i].date;
          
            var cellSelector = createCellSelector(date, idSpecialization, idDoctor, datesTextToDateNumber);
            var cell = $(cellSelector);
            updateSelectableCell(cell, published, id);
        }
    }
    
    function getIdsWorkDayFromCells(cells) {
        var idsWorkDay = [];
        
        var idWorkDay;
        for (var i in cells) {
            idWorkDay = getIdWorkDayFromCell(cells[i]);
            idsWorkDay.push(idWorkDay);
        }
        
        return idsWorkDay;
    }
    
    function cellsToNotCreatedState(cells) {
        for (var i in cells) {
            cellToNotCreatedState(cells[i]);
        }
    }
    
    function selectableCellsToNotCreatedState() {
        $(Sel.SELECTABLE_CELL_FULL_SELECTOR).each(function() {
            cellToNotCreatedState(this);
        });
    }
    
     function cellsToPublishedState(cells) {
        for (var i in cells) {
            cellToPublishedState(cells[i]);
        }
    }
    
    function cellsToNotPublishedState(cells) {
        for (var i in cells) {
            cellToNotPublishedState(cells[i]);
        }
    }
    
    // Отправка ajax-запросов
    ////////////////////////////////////////////////////////////////////////////
    function postAjaxRequestToUpdateSchedule(date, get) {
        var ajaxData = {
                'date' : date,
                'get' : get
        };
        postAjaxRequest(_urls.getSchedule, ajaxData, getScheduleSuccess);
    }	
    
    function postAjaxToDeleteWorkDays(data) {
        postAjaxRequest(_urls.deleteWorkDays, data, deleteWorkDaySuccess);
    }
    
    function postAjaxToUpdatePublishedInWorkDays(data, successFunction) {
        postAjaxRequest(_urls.updatePublishedInWorkDays, data, successFunction);
    }
    
    function postAjaxToAcceptTemplateWorkDay(data) {
        postAjaxRequest(_urls.acceptTemplateWorkDay, data, acceptTemplateWorkDaySuccess);
    }
    
    // Получение ответов на ajax-запросы
    //////////////////////////////////////////////////////////////////////////// 
    function getScheduleSuccess(data, textStatus, jqXHR) {
        // Установливаем заголовки начальных ячеек таблицы
        // и запоминаем даты
        for (var i = 0; i < data.dates.length; i++) {
            $(Sel.DATE_HEAD_CELLS_FULL_SELECTOR_PREFIX + i).html(data.dateHeads[i]);
            $(Sel.DATES_STORE_DATE_FULL_SELECTOR_PREFIX + i).html(data.dates[i]);
        }
        setDates(data.dates);
        
        // Устанвливаем период времени за который отображается рассписание
        $(Sel.DATE_INTERVAL_FULL_SELECTOR).html(data.interval);
       
        updateAllSelectableCells(data.workDays);
        afterAjaxUpdate();
    }
    
    function deleteWorkDaySuccess(data, textStatus, jqXHR) {
        cellsToNotCreatedState(getAjaxProcessedCells());
        afterAjaxUpdate();
    }
    
    function publishWorkDaySuccess(data, textStatus, jqXHR) {
        cellsToPublishedState(getAjaxProcessedCells());
        afterAjaxUpdate();
    }
    
    function depublishWorkDaySuccess(data, textStatus, jqXHR) {
        cellsToNotPublishedState(getAjaxProcessedCells());
        afterAjaxUpdate();
    }
    
    function acceptTemplateWorkDaySuccess(data, textStatus, jqXHR) {
        getAjaxProcessedCells();
        updateSelectableCells(data.createdWorkDays);
        afterAjaxUpdate();
    }
    
    // Основные функции используемые при ajax-запросах
    ////////////////////////////////////////////////////////////////////////////
    function postAjaxRequest(url, data, successFunction) {
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
        var errorMessage = $(Sel.ERROR_MESSAGE_FULL_SELECTOR);
        errorMessage.show();
        setTimeout(function() { errorMessage.hide(); }, DURATION_OF_SHOW_AJAX_ERROR_MESSAGE);
        afterAjaxUpdate();
    }
    
    function beforeAjaxUpdate() {
       $(Sel.ERROR_MESSAGE_FULL_SELECTOR).hide();
       $(Sel.LOADING_PROCESS_FULL_SELECTOR).removeClass('-hidden');
       _isAjaxRequestPerformed = true;
    }
    
    function afterAjaxUpdate() {
        $(Sel.LOADING_PROCESS_FULL_SELECTOR).addClass('-hidden');
        _isAjaxRequestPerformed = false;
    }

};