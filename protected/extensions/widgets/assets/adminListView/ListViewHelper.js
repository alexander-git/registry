// Набор "статических" функций для работы с AdminListView и его наследниками.
var ListViewHelper = (function() {
    
    // Селекторы
    var ListViewSelectors = function() {
        //listViewAjaxInfo - отдельный блок он не лежит внутри listView
        this.AJAX_INFO_FULL_SELECTOR = '.listViewAjaxInfo';
        this.PROCESS_FULL_SELECTOR = this.AJAX_INFO_FULL_SELECTOR + ' .listViewAjaxInfo__process';
        this.ERROR_MESSAGE_FULL_SELECTOR = this.AJAX_INFO_FULL_SELECTOR + ' .listViewAjaxInfo__errorMessage';
             
        this.FILTER_PANEL_CLASS = 'filterPanel';
        this.FILTER_PANEL_FILTER_BUTTON_CLASS = 'filterPanel__filterButton';
        this.FILTER_PANEL_HIDDEN_HREF_CLASS = 'filterPanel__hiddenHref';
        
        this.FILTER_PANEL_SELECTOR = '.' + this.FILTER_PANEL_CLASS;
        this.FILTER_BUTTON_SELECTOR = '.' + this.FILTER_PANEL_FILTER_BUTTON_CLASS;
        this.FILTER_PANEL_HIDDEN_HREF_SELECTOR = '.' + this.FILTER_PANEL_HIDDEN_HREF_CLASS;
    };
    var Sel = new ListViewSelectors();
              
    function showProcess() {
        $(Sel.PROCESS_FULL_SELECTOR).css('visibility' , 'visible');
    }
    
    function hideProcess() {
        $(Sel.PROCESS_FULL_SELECTOR).css('visibility' , 'hidden'); 
    }
    
    function showError() {
        $(Sel.ERROR_MESSAGE_FULL_SELECTOR).fadeIn(300); 
    }
    
    function hideError() {    
        var errorElements = $(Sel.ERROR_MESSAGE_FULL_SELECTOR + ":visible");
        if (errorElements.length > 0) {
            errorElements.hide();
        }
    }   
        
    function beforeAjaxUpdate(id, data) {
        showProcess();
        hideError(); 
     }
     
    function afterAjaxUpdate() {
        hideProcess();
    }  
    
    function ajaxUpdateError(id, xhr, textStatus, errorThrown, errorMessage) {
        showError();
        hideProcess();
    }
    
    // Добавляет к url спсок GET параметров.
    // Не проверяет есть ли уже в url хотя бы один параметр.
    // Т.е все параметры будут добавляться через &.
    function addParamsToUrl(url, listParams) {
        var paramsStr = '';
        for (var paramName in listParams) {
            paramsStr += '&';
            paramsStr += paramName + '=' + listParams[paramName];
        }
        return url + paramsStr;
    }
    
    function filterPanelButtonClick(listId, useAjaxUpdate) {
        // Находим панель фильтрации
        var filterPanel = $('#' + listId + ' ' + Sel.FILTER_PANEL_SELECTOR);
        // Находим все элементы select
        var selectElements = filterPanel.find('select');

        // Формируем параметры на основании значений выбранных в списках
        var listParams = [];
        selectElements.each(function(index) {
            var name = $(this).attr('name');
            var value = $(this).val();
            listParams[name] = value;
        });
        
        var baseUrl = filterPanel.find(Sel.FILTER_PANEL_HIDDEN_HREF_SELECTOR).attr('href');
      
        if (useAjaxUpdate) {
            filterPanelPerformFilterWithAjax(baseUrl, listParams, listId);
        } else {
             // Формируем url для отправки контроллеру
            var url = addParamsToUrl(baseUrl, listParams);
            filterPanelPerformFilter(url);
        }
    }
    
    function filterPanelPerformFilter(url) {
        window.location.href = url;
    }
    
    function filterPanelPerformFilterWithAjax(url, listParams, listId) {
        $.fn.yiiListView.update(
            listId, 
            {   
                'url' : url,
                'data' : listParams,
                // На сервере для анализа данных исспользуется массив $_GET,
                // поэтому данные в data через POST передавать нельзя
                'type' : 'GET',  
                'cache' : false 
            }
        ); 
    }
    
    return {
        'beforeAjaxUpdate' : beforeAjaxUpdate,
        'afterAjaxUpdate' : afterAjaxUpdate,  
        'ajaxUpdateError' : ajaxUpdateError,
        'filterPanelButtonClick' : filterPanelButtonClick
    };
	
})();