(function() {
    
    var NavigationItem = function(href, text) {
        this.href = href;
        this.text = text;
    };
    
    function prepareNavigationItems($routeParams, $filter, NavigationService, UrlService) {
        var  data = NavigationService.getNavigationDataObject();
        var navigationItems = [];
        
        if ($routeParams.idGroup !== undefined) {
            var href = UrlService.createGroupUrlOnDataObject(data);
            var text = data.group.name;
            navigationItems.push(new NavigationItem(href, text) );
        }
        
        if ($routeParams.idSpecialization !== undefined) {
            var href = UrlService.createSpecializationUrlOnDataObject(data);
            var text = data.specialization.name;
            navigationItems.push(new NavigationItem(href, text) );
        }
        
        if (
                ($routeParams.idDoctor !== undefined) && 
                ($routeParams.idDoctor !== UrlService.ID_DOCTOR_WHEN_SPECIALIZATION_NOT_NEED_DOCTOR_ROUTE_PARAM_VALUE) 
        ) {
            var href = UrlService.createDoctorUrlOnDataObject(data);
            var shortDoctorNameFilter = $filter('shortDoctorName');
            var text = shortDoctorNameFilter(data.doctor);
            navigationItems.push(new NavigationItem(href, text) );
        }
        
        if ($routeParams.date !== undefined) {
            // Так как workDay может быть пустым, то для формирования элемента
            // используем только адресную строку.
            var href = UrlService.createDateUrl($routeParams.date);
            var dateSeparatedByDotsFilter = $filter('dateSeparatedByDots');
            var text = dateSeparatedByDotsFilter($routeParams.date);
            navigationItems.push(new NavigationItem(href, text) );
        }
                
        if ($routeParams.time !== undefined) {
            // Здесь уже рабочий день обязательно должен существовать и workTime тоже должен быть.
            var href = UrlService.createTimeUrlOnDataObject(data);
            var text = data.workTime.timeTextView;
            navigationItems.push(new NavigationItem(href, text) );
        }
                   
        return navigationItems;
    }
    
    var injectParams = ['$scope', '$routeParams', '$location', '$filter', 'NavigationService', 'UrlService'];
          
    var NavigationController = function($scope, $routeParams, $location, $filter, NavigationService, UrlService) {
        
        var navigationItems = prepareNavigationItems($routeParams, $filter, NavigationService, UrlService);
        
        function goToBeginning() {
            $location.url('/');
        }
        
        function stepBack() {  
            if (navigationItems.length >= 2) {
                var href = navigationItems[navigationItems.length - 2].href;
                // Обрежем из начала ссылки символ #, т.к. для метода $location.url() он не нужен
                var url = href.substring(1); 
                $location.url(url);
            } else if (navigationItems.length === 1) {
                goToBeginning();  
            }
        }
        
        
        $scope.navigationItems = navigationItems;
        $scope.stepBack = stepBack;
        $scope.goToBeginning = goToBeginning;
    };
       
    NavigationController.$inject = injectParams;
    
    angular.module('navigation').controller('NavigationController', NavigationController);
    
})();