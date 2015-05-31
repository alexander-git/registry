(function() {
    
    var injectParams = ['$scope'];
    
    
    var SuccessController = function($scope) {
        $scope.workAreaCaption = "Запись успешна.";
        
        $scope.workAreaContentUrl = '/recordAppViews/success.html';
    };
    
    SuccessController.$inject = injectParams;
    
    angular.module('simplePages').controller('SuccessController', SuccessController);
    
})(); 
 
