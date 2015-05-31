var WorkDayModel = function() {
    
    this.idWorkDay = null;
    this.date = null;
    this.idSpecialization = null;
    this.specializationName = null;
    this.idDoctor = null;
    this.doctorName = null;
    this.published = null;
    
    var _changes = null;
    
    this._resetProperties = function() {
        this.idWorkDay = null;
        this.date = null;
        this.idSpecialization = null;
        this.specializationName = null;
        this.idDoctor = null;
        this.doctorName = null;
        this.published = null;
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
        
        if (data.idWorkDay !== undefined) {
            this.idWorkDay = data.idWorkDay;
        }
        if (data.date !== undefined) {
            this.date = data.date;
        }
        if (data.idSpecialization !== undefined) {
            this.idSpecialization = data.idSpecialization;
        }
        if (data.specializationName !== undefined) {
            this.specializationName = data.specializationName;
        }
        if (data.idDoctor !== undefined) {
            this.idDoctor = data.idDoctor;
        }
        if (data.doctorName !== undefined) {
            this.doctorName = data.doctorName;
        }
        if (data.published !== undefined) {
            this.published = data.published;
        }
    };
    
    this.setDayIsNotExists = function() {
        this.idWorkDay = null;
        this.published = null;
    };

};
