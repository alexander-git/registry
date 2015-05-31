var app = angular.module('recordApp', [
    'ngRoute', 
    'ngAnimate',
    'simplePages',
    'order',
    'pageData',
    'navigation', 
    'url', 
    'common'
]);

app.config(['$routeProvider', function($routeProvider) {
   
    $routeProvider.when('/', {
        templateUrl : '/recordAppViews/index.html',
        // В текущей версии workAreaContentUrl из правил для
        // маршрутов не используется, а устанавливается в контроллерах.
        workAreaContentUrl : '/recordAppViews/group.html', 
        controller : 'GroupController',
        resolve : {
            groups : ['PageDataService', function(PageDataService) {
                return PageDataService.getAllGroups();
            }],

            // Нужно только для того, чтобы при необходимости привести 
            // даннные, связанные с текущим адресом, в актуальное состояние. 
            // Напрямую эта инъекция в этом и других(но не всех) маршрутах не используется.  
            navigationData : ['NavigationService', function(NavigationService) {
                return NavigationService.getNavigationData();
            }]
        }
       
    });
    
    $routeProvider.when('/group/:idGroup/', {
        templateUrl : '/recordAppViews/index.html',
        workAreaContentUrl : '/recordAppViews/specialization.html',
        controller : 'SpecializationController',
        resolve : {
            specializations : ['PageDataService', '$route', function(PageDataService, $route) {
                return PageDataService.getSpecializationByIdGroup($route.current.params.idGroup);
            }],
       
            navigationData : ['NavigationService', function(NavigationService) {
                return NavigationService.getNavigationData();
            }]
        }
    });
    
    $routeProvider.when('/group/:idGroup/specialization/:idSpecialization/', {
        templateUrl : '/recordAppViews/index.html',
        workAreaContentUrl : '/recordAppViews/doctor.html',
        controller : 'DoctorController',
        resolve : {
            doctors : ['PageDataService', '$route', function(PageDataService, $route) {
                return PageDataService.getDoctorsByIdSpecialization($route.current.params.idSpecialization);
            }],
       
            navigationData : ['NavigationService', function(NavigationService) {
                return NavigationService.getNavigationData();
            }]
        }
    });
    
    $routeProvider.when('/group/:idGroup/specialization/:idSpecialization/doctor/:idDoctor/schedule/:dayOffset/', {
        templateUrl : '/recordAppViews/index.html',
        workAreaContentUrl : '/recordAppViews/schedule.html',
        controller : 'ScheduleController',  
        resolve : {
            scheduleData : ['PageDataService', '$route', function(PageDataService, $route) {
                var idSpecialization = $route.current.params.idSpecialization;
                var idDoctor = $route.current.params.idDoctor;
                var dayOffset = $route.current.params.dayOffset;
                return PageDataService.getScheduleData(idSpecialization, idDoctor, dayOffset);
            }],
            
            navigationData : ['NavigationService', function(NavigationService) {
                return NavigationService.getNavigationData();
            }]
        }     
    });
    
    $routeProvider.when('/group/:idGroup/specialization/:idSpecialization/doctor/:idDoctor/date/:date/', {
        templateUrl : '/recordAppViews/index.html',
        workAreaContentUrl : '/recordAppViews/time.html',
        controller : 'TimeController',  
        resolve : {       
            dayData : ['PageDataService', '$route', function(PageDataService, $route) {
                return PageDataService.getDayDataByDate($route.current.params.date);
            }],
   
            navigationData : ['NavigationService', function(NavigationService) {
                return NavigationService.getNavigationData();
            }]
        }     
    });
    
    $routeProvider.when('/group/:idGroup/specialization/:idSpecialization/doctor/:idDoctor/date/:date/time/:time/', {
        templateUrl : '/recordAppViews/index.html',
        workAreaContentUrl : '/recordAppViews/order.html', 
        controller : 'OrderController',  
        resolve : {       
            navigationData : ['NavigationService', function(NavigationService) {
                return NavigationService.getNavigationData();
            }]
        }     
    });
    
    $routeProvider.when('/success', {
        templateUrl : '/recordAppViews/index.html',
        workAreaContentUrl : '/recordAppViews/success.html', 
        controller : 'SuccessController'    
    });
    
    $routeProvider.otherwise({
       redirectTo : '/' 
    });
}]);

app.constant('groupsUrl', recordAppUrls.groupsUrl);
app.constant('specializationsUrl', recordAppUrls.specializationsUrl);
app.constant('doctorsUrl', recordAppUrls.doctorsUrl);
app.constant('scheduleUrl', recordAppUrls.scheduleUrl);
app.constant('dayUrl', recordAppUrls.dayUrl);
app.constant('navigationDataUrl', recordAppUrls.navigationDataUrl);
app.constant('makeOrderUrl', recordAppUrls.makeOrderUrl);
app.constant('captchaActionConst', {
    'url' : recordAppUrls.captchaUrl,
    'refreshGetVarName' : recordAppConst.CAPTCHA_REFRESH_GET_VAR_NAME
});

app.config([
    'PageDataServiceProvider', 
    'groupsUrl', 
    'specializationsUrl',
    'doctorsUrl',
    'scheduleUrl',
    'dayUrl',
    function(
        PageDataServiceProvider, 
        groupsUrl,
        specializationsUrl,
        doctorsUrl,
        scheduleUrl,
        dayUrl
    ) 
    {
        PageDataServiceProvider.setGroupsUrl(groupsUrl);
        PageDataServiceProvider.setSpecializationsUrl(specializationsUrl);
        PageDataServiceProvider.setDoctorsUrl(doctorsUrl);
        PageDataServiceProvider.setScheduleUrl(scheduleUrl);
        PageDataServiceProvider.setDayUrl(dayUrl);
    }
]);

app.config(['OrderServiceProvider', 'makeOrderUrl', function(OrderServiceProvider, makeOrderUrl) {
    OrderServiceProvider.setMakeOrderUrl(makeOrderUrl);
}]);

app.config(['NavigationServiceProvider', 'navigationDataUrl', function(NavigationServiceProvider, navigationDataUrl) {
    NavigationServiceProvider.setNavigationDataUrl(navigationDataUrl);
}]);

app.run(['$rootScope', '$route', function($rootScope, $route) {
        // Используется в index.html
        $rootScope.$route = $route;
}]);

app.run(['$rootScope', function($rootScope) {
    // При смене адреса показываем, что идёт процесс загрузки.
    $rootScope.isNeedShowLoading = false;
    
    $rootScope.$on('$routeChangeStart', function(event, next, current) {
        $rootScope.isNeedShowLoading = true;
    });
    
    $rootScope.$on('$routeChangeSuccess', function(event, next, current) {
        $rootScope.isNeedShowLoading = false;
    });
    
    $rootScope.$on('$routeChangeError', function(event, next, current) {
        $rootScope.isNeedShowLoading = false;
    });
}]); 