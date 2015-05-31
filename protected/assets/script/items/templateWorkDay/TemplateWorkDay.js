// TemplateWorkDay предназначен только для просмотра шаблона, но не
// создания и редактирования.
var TemplateWorkDay = function(id, urls, viewMode) {
      
    var VIEW_MODE = viewMode;
    var ID = id;
    var DURATION_OF_SHOW_INFO_MESSAGE = 5 * 1000;

    var Sel = new TemplateWorkDaySelectors(ID);    // Селекторы и css-классы
 
    // Внутренние переменные
    //////////////////////////////////////////////////////////////////////////// 
    var _templateWorkDayModel = null;
    var _urls = null;
    var _timeEditor = null;
    
    init();
    
    function init() {
        _urls = urls;
        _timeEditor = new TimeEditor(ID);
        if (VIEW_MODE === TemplateWorkDayViewMode.NORMAL) {
            _timeEditor.setNeedCompletleyHideInputErrorMessage(true);
        } else if (VIEW_MODE === TemplateWorkDayViewMode.DIALOG) {
            _timeEditor.setNeedCompletleyHideInputErrorMessage(false);
        }
    }
          
    // Регистрация событий 
    ////////////////////////////////////////////////////////////////////////////
 
    // Щелчки по кнопкам
    ////////////////////////////////////////////////////////////////////////////
    $(Sel.QUIT_BUTTON_FULL_SELECTOR).click(function() {
        if (VIEW_MODE === TemplateWorkDayViewMode.DIALOG) {
            $(Sel.TEMPLATE_WORK_DAY_FULL_SELECTOR).dialog('close'); 
        }
    });
    
    ////////////////////////////////////////////////////////////////////////////
   
    // Инициализация TemplateWorkDay перед работой 
    this.prepare = function(templateWorkDayInfo) {
        _templateWorkDayModel = new TemplateWorkDayModel();
        _templateWorkDayModel.prepare(templateWorkDayInfo);
  
        updateGeneralInfoView(_templateWorkDayModel);
        hideTemplateIsNotExistsMessage();
      
        hideElementsRelatedToAjax();
        _timeEditor.prepare();
        if (VIEW_MODE === TemplateWorkDayViewMode.DIALOG) {
            $(Sel.TEMPLATE_WORK_DAY_FULL_SELECTOR).dialog('option', 'position', 'center top+5%');
            $(Sel.TEMPLATE_WORK_DAY_FULL_SELECTOR).dialog('open'); 
        }
       
        getTemplateWorkDay();
    };   
    
    ////////////////////////////////////////////////////////////////////////////
    
    function hideElementsRelatedToAjax() {
        $(Sel.ERROR_MESSAGE_FULL_SELECTOR).hide();
        $(Sel.INFO_MESSAGE_FULL_SELECTOR).hide();
        $(Sel.PROCESS_FULL_SELECTOR).hide();
    }

    function showInfoMessage(message) {
        var infoMessage = $(Sel.INFO_MESSAGE_FULL_SELECTOR);
        infoMessage.text(message);
        infoMessage.show();
        setTimeout(function() { infoMessage.hide(); }, DURATION_OF_SHOW_INFO_MESSAGE);
    }
    
    function updateGeneralInfoView(data) {
        if (data.name !== null) {
            $(Sel.TEMPLATE_NAME_FULL_SELECTOR).text(data.name);
        }     
    }
    
    function showTemplateIsNotExistsMessage() {
        $(Sel.TEMPLATE_IS_NOT_EXISTS_MESSAGE_FULL_SELECTOR).show();
    }
    
    function hideTemplateIsNotExistsMessage() {
        $(Sel.TEMPLATE_IS_NOT_EXISTS_MESSAGE_FULL_SELECTOR).hide();
    }
    
    function updateViewAccordingTemplateWorkDayModel() {
        updateGeneralInfoView(_templateWorkDayModel);
        
        var isTemplateExists = _templateWorkDayModel.idTemplateWorkDay !== null;
        if (isTemplateExists) {
            hideTemplateIsNotExistsMessage();
        } else {
           showTemplateIsNotExistsMessage();
        }
    }
    
    // ajax-запросы
    ////////////////////////////////////////////////////////////////////////////
    function getTemplateWorkDay() {
        beforeAjaxUpdate();
        var ajaxData = {
            'idTemplateWorkDay' : _templateWorkDayModel.idTemplateWorkDay
        };
        ajaxRequest(_urls.getTemplateWorkDay, ajaxData, getTemplateWorkDaySuccess);
    }
       
    // Получение ответов на ajax-запросы
    //////////////////////////////////////////////////////////////////////////// 
    function getTemplateWorkDaySuccess(data, textStatus, jqXHR) {
        if (data.templateIsNotExists !== undefined) {   
            _templateWorkDayModel.setTemplateIsNotExists();
            
            updateViewAccordingTemplateWorkDayModel();
            _timeEditor.prepare();
        } else {
            _templateWorkDayModel.idTemplateWorkDay = parseInt(data.id);
            _templateWorkDayModel.name = data.name;
  
            updateViewAccordingTemplateWorkDayModel();
            _timeEditor.prepare(data.time);
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
