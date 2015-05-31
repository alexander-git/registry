var EventGenerator = function() {
    
    var _eventListeners = [];
    
    this.addEventListener = function(eventListener) {
        for (var i = 0; i < _eventListeners.length; i++) {
            if (_eventListeners[i] === eventListener) {
                return;
            }
        }
        _eventListeners.push(eventListener);
    };
    
    this.removeEventListener = function(eventListener) {
        for (var i = 0; i < _eventListeners.length; i++) {
            if (_eventListeners[i] === eventListener) {
                _eventListeners.splice(i, 1);
                break;
            }
        }
    };
    
    this.generateEvent = function(eventType, params) {
        var data = {
            'type' : eventType
        };

        if (params !== undefined) {
            for (var prop in params) {
                data[prop] = params[prop];
            }
        }
        
        for (var i = 0; i < _eventListeners.length; i++) {
            if (_eventListeners[i] !== null) {
                $(_eventListeners[i]).triggerHandler(data);
            }
        }   
    };
    
};