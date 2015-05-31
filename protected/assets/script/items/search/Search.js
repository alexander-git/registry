var Search = function (containerId, searchUrl, searchGetVarName, viewMode) {
    
    var AJAX_SEARCH_NOTHING_IS_FOUND_RESPONSE_MESSAGE = 'nothing is found';
    var GET_VAR_VALUE_FOR_SHOW_ALL_REQUEST = '';
    var RESULT_FADE_IN_TIME = 600;

    var ID = containerId;
    var SEARCH_URL = searchUrl;
    var Sel = new SearchSelectors(ID);
    var _eventGenerator = new EventGenerator();
    var VIEW_MODE = null;
    
    if (viewMode === undefined) {
        VIEW_MODE = SearchViewMode.NORMAL;
    } else {
        VIEW_MODE = viewMode;
    }
    
    this.open = function() {
        if (VIEW_MODE === SearchViewMode.DIALOG) {
            $(Sel.SEARCH_FULL_SELECTOR).dialog('option', 'position', 'center top+15%');
            $(Sel.SEARCH_FULL_SELECTOR).dialog('open');   
        }
    };
    
    this.addEventListener = function(eventListener) {
        _eventGenerator.addEventListener(eventListener);
    };
    
    this.removeEventLestiner = function(eventListener) {
        _eventGenerator.removeEventListener(eventListener);
    };
    
    // Функции getSelectedValue и getSelectedText существуют в двух вариантах  
    // так как с одной стороны есть обращения к функциям только из private(внутренних) функций,
    // которые не могут обращаться к this, но с другой стороны к getSelectedValue и getSelectedText
    // нужно иметь доступ извне.
    
    // Работает только если в качестве .search__result используется элемент select.
    this.getSelectedValue = function() {
        return getSelectedValue();
    };
    
    // Работает только если в качестве .search__result используется элемент select.
    this.getSelectedText = function() {
        return getSelectedText();
    };
    
    // Работает только если в качестве .search__result используется элемент select.
    function getSelectedValue() {
        var value = $(Sel.RESULT_FULL_SELECTOR).val();
        if (value === undefined) {
            return null;
        } else {
            return value;
        }
    };
    
    // Работает только если в качестве .search__result используется элемент select.
    function getSelectedText() {
        var text = $(Sel.RESULT_FULL_SELECTOR + ' :selected').html();
        if (text === undefined) {
            return null;
        } else {
            return text;
        }
    };
    
    $(Sel.SEARCH_BUTTON_FULL_SELECTOR).click(function(e) {   
        var textToSearch = $(Sel.TEXT_TO_SEARCH_FULL_SELECTOR).val();
        if (textToSearch === '') {
            return; //Ничего не введено - поиск не выполняем
        }

        beforeAjaxUpdate();
       
        var ajaxData = {};
        ajaxData[searchGetVarName] = textToSearch;
        ajaxRequest(ajaxData); 
    });  

    $(Sel.SHOW_ALL_BUTTON_FULL_SELECTOR).click(function(e) {
        beforeAjaxUpdate();
    
        var ajaxData = {};
        ajaxData[searchGetVarName] = GET_VAR_VALUE_FOR_SHOW_ALL_REQUEST; 
        ajaxRequest(ajaxData);  
    });
    
    // Работает только если в качестве .search_result используется элемент select
    $(Sel.SELECT_BUTTON_FULL_SELECTOR).click(function(e) {
        var value = getSelectedValue();
        var text = getSelectedText();
        if (value === null) {
            return;
        }
        
        _eventGenerator.generateEvent(SearchEvents.SELECT, 
            {
                'value' : value,
                'text' : text
            }
        );
        if (VIEW_MODE === SearchViewMode.DIALOG) {
            $(Sel.SEARCH_FULL_SELECTOR).dialog('close');
        }
    });
    
    $(Sel.QUIT_BUTTON_FULL_SELECTOR).click(function(e) {
        if (VIEW_MODE === SearchViewMode.DIALOG) {
            $(Sel.SEARCH_FULL_SELECTOR).dialog('close');
        }
    });
    
    // Получение результата на ajax-запросы
    ////////////////////////////////////////////////////////////////////////////
    function searchSuccess(data, textStatus, jqXHR) {
        afterAjaxUpdate();
        if (data !== AJAX_SEARCH_NOTHING_IS_FOUND_RESPONSE_MESSAGE) {
            $(Sel.RESULT_FULL_SELECTOR).html(data);
            $(Sel.RESULT_PANEL_FULL_SELECTOR).fadeIn(RESULT_FADE_IN_TIME);
        } else {
            $(Sel.NOTHIN_IS_FOUND_FULL_SELECTOR).fadeIn(RESULT_FADE_IN_TIME);
        }
    }
    
    // Основние функции работы с ajax
    ////////////////////////////////////////////////////////////////////////////
    function afterAjaxUpdate() {
        $(Sel.PROCESS_FULL_SELECTOR).hide();
    }

    function beforeAjaxUpdate() {
        $(Sel.RESULT_PANEL_FULL_SELECTOR).hide();
        $(Sel.RESULT_FULL_SELECTOR).html('');
        $(Sel.NOTHIN_IS_FOUND_FULL_SELECTOR).hide();
        $(Sel.ERROR_MESSAGE).hide();
        $(Sel.PROCESS_FULL_SELECTOR).show();
        
    }
    
    function ajaxRequestError(jqXHR, textStatus,errorThrown) {
        afterAjaxUpdate();
        $(Sel.ERROR_MESSAGE).show();
    }
    
    function ajaxRequest(data) {
        $.ajax({
            'url' : SEARCH_URL,
            'type' : 'GET',
            'data' :  data,
            'dataType' : 'html',
            'success' : searchSuccess,
            'error' : ajaxRequestError
        });  
    }
    
};
        