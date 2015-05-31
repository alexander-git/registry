(function() {
            
    var NavigationData = function() {
        this.group = null;
        this.specialization = null;
        this.doctor = null;
        this.workDay = null;
        this.workTime = null;
    };
          
    var injectParams = [];
      
    var NavigationServiceProvider = function() {
      
        var _data = new NavigationData();
        var _navigationDataUrl = null;
        
        this.setNavigationDataUrl = function (value) {
            _navigationDataUrl = value;
        };
        
        this.$get  = ['$http', '$q', '$route', 'UrlService', function($http, $q, $route, UrlService) {                      
            
            var service = {};
            
            function isNeedGetGroup(currentParams) {
                if (currentParams.idGroup === undefined) {
                    return false;
                } 
                // Если группы нет или в данных по каким-то причинам храниться другая группа
                // добавляем параметр для получения нужной группы
                // Анологично со специализацией и т.д.
                if (
                        (_data.group === null) || 
                        (parseInt(_data.group.id) !== parseInt(currentParams.idGroup) ) 
                    ) 
                {
                    return true;
                } 
                
                return false;
            }
            
            function isNeedGetSpecialization(currentParams) {
                if (currentParams.idSpecialization === undefined) {
                    return false;
                }
                if (
                        (_data.specialization === null) || 
                        (parseInt(_data.specialization.id) !== parseInt(currentParams.idSpecialization) )
                    ) 
                {
                    return true;
                } 
                
                return false;
            }
            
            function isNeedGetDoctor(currentParams) {
                if (currentParams.idDoctor === undefined) {
                    return false;
                }
                if (currentParams.idDoctor === UrlService.ID_DOCTOR_WHEN_SPECIALIZATION_NOT_NEED_DOCTOR_ROUTE_PARAM_VALUE) {
                    return false;
                }
                if (
                        (_data.doctor === null) || 
                        (parseInt(_data.doctor.id) !== parseInt(currentParams.idDoctor) )
                    ) 
                { 
                    return true;
                } 
                
                return false;
            }
            
            function isNeedGetWorkDay(currentParams) {
                // Данные о рабочем дне обновляем каждый раз, так как с ним свзанное с ним время
                // извлекается при запросе. А состояние времени(занято, свободно) часто меняется.
                if (currentParams.date === undefined) {
                    return false;
                } else {
                    return true;
                }
            }
            
            function isNeedGetWorkTime(currentParams) {
                // Данные о времени обновляем каждый раз, так как эти данные часто меняются.
                if (currentParams.time === undefined) {
                    return false;
                } else {
                    return true;
                }
            }
            
            
            function prepareRequestParams($route) {
                // В соответствии с состоянием адресной строки выясняем нужно ли
                // запрсить с сервера какую-либо информацию.
                var requestData = {};
            
                var needUpdate = false;
                var currentParams = $route.current.params;
            
                if (isNeedGetGroup(currentParams) ) {
                    requestData['idGroup'] = currentParams.idGroup;
                    needUpdate = true;
                }
                if (isNeedGetSpecialization(currentParams) ) {
                    requestData['idSpecialization'] = currentParams.idSpecialization;
                    needUpdate = true;
                }
                
                if (isNeedGetDoctor(currentParams) ) {
                    requestData['idDoctor'] = currentParams.idDoctor;
                    needUpdate = true;
                }
                
                if (isNeedGetWorkDay(currentParams) ) { 
                    requestData['workDay'] = {};
                    requestData['workDay']['idDoctor'] = currentParams.idDoctor;
                    requestData['workDay']['idSpecialization'] = currentParams.idSpecialization;
                    requestData['workDay']['date'] = currentParams.date; 
                    
                    if (isNeedGetWorkTime(currentParams) ) {
                        requestData['time'] = currentParams.time;
                    }
                    
                    needUpdate = true;
                }
                
                if (needUpdate) {
                    return requestData ;
                } else {
                    return null;
                }
            }
            
            service.getNavigationData = function() {   
                var requestData = prepareRequestParams($route);
                
                if (requestData !== null) {
                    return $http({
                        'method' : 'POST',
                        'url' : _navigationDataUrl,
                        'data' : requestData
                    }).then(function(response) {
                        var data = response.data;

                        if (data.group !== undefined) {
                            _data.group = data.group;
                        }
                        if (data.specialization !== undefined) {
                            _data.specialization = data.specialization;
                        }
                        if (data.doctor !== undefined) {
                            _data.doctor = data.doctor;
                        }
                        if (data.workDay !== undefined) {
                            _data.workDay = data.workDay;
                        }
                        if (data.workTime !== undefined) {
                            _data.workTime = data.workTime;
                        }

                        return _data;
                    });
                } else {
                    // Обновлять ничего не нужно - все даннные актальны.  
                    // Поэтому просто возвращаем выполненное обещание.
                    var task = $q.defer();
                    task.resolve(_data);
                    return task.promise;
                }
            };
            
            service.setGroup = function(group) {
                _data.group = group;
            };
            
            service.setSpecialization = function(specialization) {
                _data.specialization = specialization;
                if (!specialization.needDoctor) {
                    _data.doctor = null;
                }
            };
            
            service.setDoctor = function(doctor) {
                _data.doctor = doctor;
            };
            
            service.getGroup = function() {
                return _data.group;
            };
            
            service.getSpecialization = function() {
                return _data.specialization;
            };
            
            service.getDoctor = function() {
                return _data.doctor;
            };
            
            service.setWorkDay = function(workDay) {
                _data.workDay = workDay;
            };
            
            service.getWorkDay = function() {
                return _data.workDay;
            };
            
            service.setWorkTime = function(workTime) {
                _data.workTime = workTime;
            };
            
            service.getWorkTime = function() {
                return _data.workTime;
            };
            
            service.getNavigationDataObject = function() {
                return _data;
            };
            
            return service;
        }];       
        
    };
    
    NavigationServiceProvider.$inject = injectParams;
    
    angular.module('navigation').provider('NavigationService', NavigationServiceProvider);
    
})(); 
 