var DateIntervalAction = function (containerId, requestUrl) {
    
    var ID = containerId;
    var REQUEST_URL = requestUrl;
    var Sel = new DateIntervalActionSelectors(ID);
    
    // Функция которая выполняется перед запросом.
    // Должна возвращать массив ключ->значение. Данные из него будут отправлены вместе с запросом.
    var _prepareAdditionalDataBeforeRequestFunction = null;
    // Обязательно ли функция должна вернуть какие-то данные для выполнения запроса или это опционально
    var _isRequiredAdditionalDataBeforeRequest = false;
    
    this.setPrepareAdditionalDataBeforeRequestFunction = function(func) {
        _prepareAdditionalDataBeforeRequestFunction = func;
    };
    
    this.setIsRequiredAdditionalDataBeforeRequest = function(value) {
        _isRequiredAdditionalDataBeforeRequest = value;
    };
   
    $(Sel.PERFORM_BUTTON_FULL_SELECTOR).click(function(e) {   
        var dateBegin = $(Sel.DATE_BEGIN_FULL_SELECTOR).val();
        var dateEnd = $(Sel.DATE_END_FULL_SELECTOR).val();
        var ajaxData = {
            'DateIntervalActionForm[dateBegin]' : dateBegin,
            'DateIntervalActionForm[dateEnd]' : dateEnd
        };
        
        if (_isRequiredAdditionalDataBeforeRequest) {
            // Дополнительные данные должны быть обязательно, но функция для их получения не задана
            if (_prepareAdditionalDataBeforeRequestFunction === null) {
                return;
            }
        }
        // Если нужно получаем дополнительные данные для запроса 
        if (_prepareAdditionalDataBeforeRequestFunction !== null) {
            var additionalData = _prepareAdditionalDataBeforeRequestFunction();
            if (_isRequiredAdditionalDataBeforeRequest && (additionalData === null) ) {
                 // Дополнительные данные должны быть обязательно, но функция фонкция их не вернула
                 return;
            }
            
            for (var prop in additionalData) {
                ajaxData[prop] = additionalData[prop];
            }
        }
        
        beforeAjaxUpdate();
        ajaxRequest(ajaxData); 
    }); 
   
    // Получение результата на ajax-запросы
    ////////////////////////////////////////////////////////////////////////////
    function actionSuccess(data, textStatus, jqXHR) {
        afterAjaxUpdate();
        if (data.success !== undefined) {
            $(Sel.SUCCESS_MESSAGE_FULL_SELECTOR).fadeIn(600);
            setTimeout(function() { $(Sel.SUCCESS_MESSAGE_FULL_SELECTOR).fadeOut(600); }, 3000);
        } else if (data.error !== undefined) {
            $(Sel.INPUT_ERROR_FULL_SELECTOR).html(data.error);
            $(Sel.INPUT_ERROR_FULL_SELECTOR).fadeIn(600);
        }
    }
    
    // Основние функции работы с ajax
    ////////////////////////////////////////////////////////////////////////////
    function afterAjaxUpdate() {
        $(Sel.PROCESS_FULL_SELECTOR).hide();
    }

    function beforeAjaxUpdate() {
        $(Sel.INPUT_ERROR_FULL_SELECTOR).hide();
        $(Sel.SUCCESS_MESSAGE_FULL_SELECTOR).hide();
        $(Sel.ERROR_MESSAGE_FULL_SELECTOR).hide();
        $(Sel.PROCESS_FULL_SELECTOR).show();      
    }
    
    function ajaxRequestError(jqXHR, textStatus,errorThrown) {
        afterAjaxUpdate();
        $(Sel.ERROR_MESSAGE_FULL_SELECTOR).show();
    }
    
    function ajaxRequest(data) {
        $.ajax({
            'url' : REQUEST_URL,
            'type' : 'POST',
            'data' :  data,
            'dataType' : 'json',
            'success' : actionSuccess,
            'error' : ajaxRequestError
        });  
    }
    
};
        