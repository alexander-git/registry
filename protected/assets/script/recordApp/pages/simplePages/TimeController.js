(function() {
    
    var injectParams = ['$scope', '$routeParams', 'dayData', 'navigationData', 'NavigationService'];
    
    var TimeController = function($scope, $routeParams, dayData, navigationData, NavigationService) {
        $scope.$routeParams = $routeParams;

        $scope.workAreaCaption = "Выберите время";
        
        var workDay = navigationData.workDay;
        if (workDay === null) {
            $scope.time = null;
        } else {
            $scope.time = navigationData.workDay.time;
        }
                
        $scope.dateTextView = dayData.dateTextView;
        $scope.nextDate = dayData.nextDate;
        $scope.previousDate = dayData.previousDate;
        
        $scope.workAreaContentUrl = '/recordAppViews/time.html';
    };
    
    TimeController.$inject = injectParams;
    
    
    angular.module('simplePages').controller('TimeController', TimeController);
    
})(); 
 
