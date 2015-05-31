(function() {
    
    var injectParams = ['$scope', '$routeParams', 'specializations', 'NavigationService',];
    
    var SpecializationController = function($scope, $routeParams, specializations, NavigationService) {
        $scope.$routeParams = $routeParams;
        
        var provisionalRecordCount = 0;
        var recordOnTimeCount = 0;
        for (var i in specializations) {
            if (specializations) {
                if (specializations[i].provisionalRecord) {
                    ++provisionalRecordCount;
                }
                if (specializations[i].recordOnTime) {
                    ++recordOnTimeCount;
                }
            }
        }
        
        $scope.workAreaCaption = "Выберите специализацию";
        $scope.specializations = specializations;
        $scope.provisionalRecordCount = provisionalRecordCount;
        $scope.recordOnTimeCount = recordOnTimeCount;
        
        $scope.selectSpecialization = function(specialization) {
            NavigationService.setSpecialization(specialization);
        };
        
        $scope.workAreaContentUrl = '/recordAppViews/specialization.html';
    };
    
    SpecializationController.$inject = injectParams;
    
    
    angular.module('simplePages').controller('SpecializationController', SpecializationController);
    
}()); 
 
