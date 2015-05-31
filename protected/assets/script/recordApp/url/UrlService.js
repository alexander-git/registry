(function() {

    var injectParams = ['$routeParams'];

    function UrlService($routeParams) {
        
        var ID_DOCTOR_WHEN_SPECIALIZATION_NOT_NEED_DOCTOR_ROUTE_PARAM_VALUE = 'null';
        
        function createGroupUrlCommon(group) {
            return '/group/' + group.id + '/';
        }
        
        function createSpecializationUrlCommon(idGroup, specialization) {
            var url = '/group/' + idGroup + '/specialization/' + specialization.id + '/'; 
            if (!specialization.needDoctor) {
                url += 'doctor/' + ID_DOCTOR_WHEN_SPECIALIZATION_NOT_NEED_DOCTOR_ROUTE_PARAM_VALUE + '/schedule/0/';
            }
            return url;
        }
        
        function createDoctorUrlCommon(idGroup, idSpecialization, doctor) {
            return '/group/' + idGroup + '/specialization/' + idSpecialization + '/doctor/' + doctor.id + '/schedule/0/';
        }
        
        function createScheduleUrlCommon(idGroup, idSpecialization, idDoctor, dayOffset) {
            return '/group/' + idGroup + '/specialization/' + idSpecialization + '/doctor/' + idDoctor + '/schedule/' + dayOffset + '/';
        }
        
        function createDateUrlCommon(idGroup, idSpecialization, idDoctor, date) {
            return '/group/' + idGroup + '/specialization/' + idSpecialization + '/doctor/' + idDoctor + '/date/' + date + '/';
        }
        
        function createTimeUrlCommon(idGroup, idSpecialization, idDoctor, date, timeShortTextView) {
            var time = timeShortTextViewToTimeUrlView(timeShortTextView);
            return '/group/' + idGroup + '/specialization/' + idSpecialization + '/doctor/' + idDoctor + '/date/' + date + '/time/' + time + '/';
        }
        
        function createSuccessUrlCommon() {
            return '/success/';
        }
        
        // Функции использующиеся для создания ссылок.
        ////////////////////////////////////////////////////////////////////////
        
        function createGroupUrlForHref(group) {
            return '#' + createGroupUrlCommon(group);
        }
        
        function createSpecializationUrlForHref(idGroup, specialization) {
            return '#' + createSpecializationUrlCommon(idGroup, specialization);
        }
        
        function createDoctorUrlForHref(idGroup, idSpecialization, doctor) {
            return '#' + createDoctorUrlCommon(idGroup, idSpecialization, doctor);
        }
        
        function createScheduleUrlForHref(idGroup, idSpecialization, idDoctor, dayOffset) {
            return '#' + createScheduleUrlCommon(idGroup, idSpecialization, idDoctor, dayOffset);
        }
        
        function createDateUrlForHref(idGroup, idSpecialization, idDoctor, date) {
            return '#' + createDateUrlCommon(idGroup, idSpecialization, idDoctor, date);
        }
        
        function createTimeUrlForHref(idGroup, idSpecialization, idDoctor, date, timeShortTextView) {
            return '#' + createTimeUrlCommon(idGroup, idSpecialization, idDoctor, date, timeShortTextView);
        }
        
        function createSuccessUrlForHref() {
            return '#' + createSuccessUrlCommon();
        }
        
        ////////////////////////////////////////////////////////////////////////
        
        function timeShortTextViewToTimeUrlView(timeShortTextView) {
            // Меням двоеточие на тире, так как двоеточие в url лучше не использовать. 
            // То есть, к примеру, 11:00 будет заменено на 11-00.
            return timeShortTextView.replace(/\:/, '-');
        }
        
        function getDoctorIdOnDataObject(dataObject) {
            if (!dataObject.specialization.needDoctor) {
               return ID_DOCTOR_WHEN_SPECIALIZATION_NOT_NEED_DOCTOR_ROUTE_PARAM_VALUE;
            } else {
                return dataObject.doctor.id;
            }
        }
        
        var service = {};
        
        service.ID_DOCTOR_WHEN_SPECIALIZATION_NOT_NEED_DOCTOR_ROUTE_PARAM_VALUE = ID_DOCTOR_WHEN_SPECIALIZATION_NOT_NEED_DOCTOR_ROUTE_PARAM_VALUE;
        
        service.createGroupUrl = function(group) {
            return createGroupUrlForHref(group);
        };
        
        service.createGroupUrlOnDataObject = function(data) {
            return createGroupUrlForHref(data.group);
        };
        
        service.createSpecializationUrl = function(specialization) {
            return createSpecializationUrlForHref($routeParams.idGroup, specialization);
        };
        
        service.createSpecializationUrlOnDataObject = function(data) {
            return createSpecializationUrlForHref(data.group.id, data.specialization);
        };
             
        service.createDoctorUrl = function(doctor) {
            return createDoctorUrlForHref($routeParams.idGroup, $routeParams.idSpecialization, doctor); 
        };
        
        service.createDoctorUrlOnDataObject = function(data) {
            return createDoctorUrlForHref(data.group.id, data.specialization.id, data.doctor);
        };
        
        service.createScheduleUrl = function(dayOffset) {
            return createScheduleUrlForHref($routeParams.idGroup, $routeParams.idSpecialization, $routeParams.idDoctor, dayOffset);
        };
        
        service.createDateUrl = function(date) {
            return createDateUrlForHref($routeParams.idGroup, $routeParams.idSpecialization, $routeParams.idDoctor, date);
        };
        
        service.createDateUrlOnDataObject = function(data) {
            var doctorId = getDoctorIdOnDataObject(data);
            return createDateUrlForHref(data.group.id, data.specialization.id, doctorId, data.workDay.date);
        };
        
        service.createTimeUrl = function(time) {
            return createTimeUrlForHref($routeParams.idGroup, $routeParams.idSpecialization, $routeParams.idDoctor, $routeParams.date, time);
        };
        
        service.createTimeUrlOnDataObject = function(data) {
            var doctorId = getDoctorIdOnDataObject(data);
            return createTimeUrlForHref(data.group.id, data.specialization.id, doctorId, data.workDay.date, data.workTime.timeTextView);
        };
        
        service.createSuccessUrl = function() {
            return createSuccessUrlForHref();
        };
        
        service.createSuccessUrlForLocation = function() {
            return createSuccessUrlCommon();
        };
        
        
        return service;
    };

    UrlService.$inject = injectParams;
    
    angular.module('url').factory('UrlService', UrlService);

})();