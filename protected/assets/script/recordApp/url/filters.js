(function() {
 
    var groupUrlFilter = function(UrlService) {
        return function(group) {
            return UrlService.createGroupUrl(group);
        };
    };
    groupUrlFilter.$inject = ['UrlService'];


    var specializationUrlFilter = function(UrlService) {
        return function(specialization) {
            return UrlService.createSpecializationUrl(specialization);
        };
    };
    specializationUrlFilter.$inject = ['UrlService'];


    var doctorUrlFilter = function(UrlService) {
        return function(doctor) {
            return UrlService.createDoctorUrl(doctor);
        };
    };
    doctorUrlFilter.$inject = ['UrlService'];
    
    var scheduleUrlFilter = function(UrlService) {
        return function(dayOffset) {
            return UrlService.createScheduleUrl(dayOffset);
        };
    };
    scheduleUrlFilter.$inject = ['UrlService'];
    
    var dateUrlFilter = function(UrlService) {
        return function(date) {
            return UrlService.createDateUrl(date);
        };
    };
    dateUrlFilter.$inject = ['UrlService'];
    
    var timeUrlFilter = function(UrlService) {
        return function(time) {
            return UrlService.createTimeUrl(time);
        };
    };
    timeUrlFilter.$inject = ['UrlService'];
    
    var url = angular.module('url');
    
    url.filter('groupUrl', groupUrlFilter);
    url.filter('specializationUrl', specializationUrlFilter);
    url.filter('doctorUrl', doctorUrlFilter);
    url.filter('scheduleUrl', scheduleUrlFilter);
    url.filter('dateUrl', dateUrlFilter);
    url.filter('timeUrl', timeUrlFilter);

})();