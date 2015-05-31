(function() {
    
    var injectParams = ['$scope', '$routeParams', 'doctors', 'NavigationService'];
    
    var DoctorController = function($scope, $routeParams, doctors, NavigationService) {
        $scope.$routeParams = $routeParams;

        $scope.workAreaCaption = "Выберите врача";
        $scope.doctors = doctors;
        
        $scope.selectDoctor = function(doctor) {
            NavigationService.setDoctor(doctor);
        };
        
        $scope.workAreaContentUrl = '/recordAppViews/doctor.html';
    };
    
    DoctorController.$inject = injectParams;
    
    
    angular.module('simplePages').controller('DoctorController', DoctorController);
    
})(); 
 
