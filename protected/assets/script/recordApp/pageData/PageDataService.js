(function() {
            
    var injectParams = [];
      
    var PageDataServiceProvider = function() {
        
        var _groupsUrl = null;
        var _specializationsUrl = null;
        var _doctorsUrl = null;
        var _scheduleUrl = null;
        var _dayUrl = null;
        
        this.setGroupsUrl = function (value) {
            _groupsUrl = value;
        };
        
        this.setSpecializationsUrl = function (value) {
            _specializationsUrl = value;
        };
        
        this.setDoctorsUrl = function (value) {
            _doctorsUrl = value;
        };
        
        this.setScheduleUrl = function (value) {
            _scheduleUrl = value;
        };
        
        this.setDayUrl = function (value) {
            _dayUrl = value;
        };
        
        this.$get  = ['$http', function($http) {                      
            
            var service = {};
            
            service.getAllGroups = function() {    
                return $http({
                    'method' : 'GET',
                    'url' : _groupsUrl
                }).then(function(response) {
                    return response.data;
                });
            };
            
            service.getSpecializationByIdGroup = function(idGroup) {    
                return $http({
                    'method' : 'GET',
                    'url' : _specializationsUrl,
                    'params' : {
                        'idGroup' : idGroup
                    }
                }).then(function(response) {
                    return response.data;
                });
            };
            
            service.getDoctorsByIdSpecialization = function(idSpecialization) {    
                return $http({
                    'method' : 'GET',
                    'url' : _doctorsUrl,
                    'params' : {
                        'idSpecialization' : idSpecialization
                    }
                }).then(function(response) {
                    return response.data;
                });
            };
            
            service.getScheduleData = function(idSpecialization, idDoctor, dayOffset) {    
                return $http({
                    'method' : 'GET',
                    'url' : _scheduleUrl,
                    'params' : {
                        'idSpecialization' : idSpecialization,
                        'idDoctor' : idDoctor,
                        'dayOffset' : dayOffset
                    }
                }).then(function(response) {
                    return response.data;
                });
            };
            
            service.getDayDataByDate = function(date) {    
                return $http({
                    'method' : 'GET',
                    'url' : _dayUrl,
                    'params' : {
                        'date' : date
                    }
                }).then(function(response) {
                    return response.data;
                });
            };  
            
            return service;
        }];       
        
    };
    
    PageDataServiceProvider.$inject = injectParams;
    
    angular.module('pageData').provider('PageDataService', PageDataServiceProvider);
    
}()); 
 