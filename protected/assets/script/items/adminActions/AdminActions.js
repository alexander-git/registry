var AdminActions = function(urls) {
      
   var FADE_IN_MESSAGE_DURATION = 600;
   var SHOW_MESSAGE_DURATION = 5000;
      
   var Sel = new AdminActionSelectors();   
   var _urls = urls; 
          
    // Щелчки по кнопкам
    ////////////////////////////////////////////////////////////////////////////
    $(Sel.INSTALL_USER_ROLES_BUTTON_FULL_SELECTOR).click(function(e) {
        beforeAjaxUpdate();
        ajaxRequest(_urls.installUserRoles, {}, unstallRolesSuccess);
    });
    
    function showSuccessMessage(message) {
        var successMessage = $(Sel.SUCCESS_MESSAGE_FULL_SELECTOR);
        successMessage.html(message);
        successMessage.fadeIn(FADE_IN_MESSAGE_DURATION);
        setTimeout(function() { successMessage.fadeOut(FADE_IN_MESSAGE_DURATION); }, SHOW_MESSAGE_DURATION );
    }
   
    // Получение ответов на ajax-запросы
    //////////////////////////////////////////////////////////////////////////// 
    function unstallRolesSuccess(data, textStatus, jqXHR) {
        showSuccessMessage(AdminActionsConst.INSTULL_USER_ACTIONS_SUCCESS_MESSAGE);
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
       $(Sel.SUCCESS_MESSAGE_FULL_SELECTOR).hide();
       $(Sel.PROCESS_FULL_SELECTOR).show();
    }
    
    function afterAjaxUpdate() {
        $(Sel.PROCESS_FULL_SELECTOR).hide();
    }
    
};
