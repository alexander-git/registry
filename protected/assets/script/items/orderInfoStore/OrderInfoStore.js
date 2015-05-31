var OrderInfoStore = function() {
  
    var ID_DOCTOR_TEXT_VALUE_WHEN_ID_DOCTOR_IS_NULL = 'null';
  
    var Sel = new OrderInfoStoreSelectors();
   
    var _dataContainerElement = null;
    
    this.prepare = function(orderInfoStoreElement) {
        _dataContainerElement = $(orderInfoStoreElement).find(Sel.DATA_CONTAINER_SELECTOR);
    };
    
    this.getIdOrder = function() {
        var e = $(_dataContainerElement).find(Sel.ID_ORDER_SELECTOR);
        return getElementAsIntegerOrNull(e);
    };
    
    this.getDate = function() {
        var e = $(_dataContainerElement).find(Sel.DATE_SELECTOR);
        return getElementTextOrNull(e);
    };
    
    this.getTime = function() {
        var e = $(_dataContainerElement).find(Sel.TIME_SELECTOR);
        return getElementTextOrNull(e);
    };
    
    this.getIdSpecialization = function() {
        var e = $(_dataContainerElement).find(Sel.ID_SPECIALIZATION_SELECTOR);
        return getElementAsIntegerOrNull(e);
    };
    
    this.getIdDoctor = function() {
        var e = $(_dataContainerElement).find(Sel.ID_DOCTOR_SELECTOR);
        if (e.length === 0) {
            return null;
        } else if (e.text() === ID_DOCTOR_TEXT_VALUE_WHEN_ID_DOCTOR_IS_NULL) {
            return null;
        } else {
            return parseInt(e.text());
        }
    };
    
    this.getSpecializationName = function() {
        var e = $(_dataContainerElement).find(Sel.SPECIALIZATION_NAME_SELECTOR);
        return getElementTextOrNull(e);
    };
    
    this.getDoctorName = function() {
        var e = $(_dataContainerElement).find(Sel.DOCTOR_NAME_SELECTOR);
        return getElementTextOrNull(e);
    };
    
    this.getFirstname = function() {
        var e = $(_dataContainerElement).find(Sel.FIRSTNAME_SELECTOR);
        return getElementTextOrNull(e);
    };
    
    this.getSurname = function() {
        var e = $(_dataContainerElement).find(Sel.SURNAME_SELECTOR);
        return getElementTextOrNull(e);
    };
    
    this.getPatronymic = function() {
        var e = $(_dataContainerElement).find(Sel.PATRONYMIC_SELECTOR);
        return getElementTextOrNull(e);
    };
    
    this.getPhone = function() {
        var e = $(_dataContainerElement).find(Sel.PHONE_SELECTOR);
        return getElementTextOrNull(e);
    };
    
    
    this.getOrderId = function() {
        var e = $(_dataContainerElement).find(Sel.ID_ORDER_SELECTOR);
        return getElementAsIntegerOrNull(e);
    };
    
    this.getProcessed = function() {
        var e = $(_dataContainerElement).find(Sel.FIRSTNAME_SELECTOR);
        return getElementTextOrNull(e);
    };
    
    this.getState = function() {
        var e = $(_dataContainerElement).find(Sel.STATE_SELECTOR);
        return getElementTextOrNull(e);
    };
    
    function getElementTextOrNull(element) {
        if (element.length === 0) {
            return null;
        } else {
            return element.text();
        }
    }
    
    function getElementAsIntegerOrNull(element) {
        if (element.length === 0) {
            return null;
        } else {
            return parseInt(element.text());
        }
    }
    
};