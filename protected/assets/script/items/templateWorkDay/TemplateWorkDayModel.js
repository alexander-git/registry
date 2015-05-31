var TemplateWorkDayModel = function() {
    
    this.idTemplateWorkDay = null;
    this.name = null;

    var _changes = null;
    
    this._resetProperties = function() {
        this.idTemplateWorkDay = null;
        this.name = null;
    };
    
    this.prepareChanges = function(changes) {
        _changes = changes;
    };
    
    this.acceptChanges = function () {
        for (var prop in _changes) {
            this[prop] = _changes[prop];
        }
    };
   
    this.prepare = function(data) {
        this._resetProperties();
        
        if (data.idTemplateWorkDay !== undefined) {
            this.idTemplateWorkDay = data.idTemplateWorkDay;
        }
        if (data.name !== undefined) {
            this.name = data.name;
        }
    };
    
    this.setTemplateIsNotExists = function() {
        this.idTemplateWorkDay = null;
        this.name = null;
    };
    
};
