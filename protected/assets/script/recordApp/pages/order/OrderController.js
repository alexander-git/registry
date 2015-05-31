(function() {
    
    var injectParams = ['$scope', '$routeParams', 'navigationData'];
    
    
    var OrderController = function($scope, $routeParams, navigationData) {
        $scope.$routeParams = $routeParams;
        var workAreaCaption = "Укажите ваши персональные данные";
        
        var workTime = navigationData.workTime;
        
        var isNeedShowOrderForm;
        if (workTime.state === 'free') {
           isNeedShowOrderForm = true;
        } else {
           isNeedShowOrderForm= false;
        }   
        
        // Изменим заголовок если это необходимо
        if (!isNeedShowOrderForm) {
            workAreaCaption = 'Запись невозоможна';
        }
                
        $scope.isNeedShowOrderForm = isNeedShowOrderForm;
        $scope.workTime = workTime;
        $scope.workAreaCaption = workAreaCaption;
        
        $scope.workAreaContentUrl = '/recordAppViews/order.html';
    };
    
    OrderController.$inject = injectParams;
    
    angular.module('order').controller('OrderController', OrderController);
    
})(); 
 
