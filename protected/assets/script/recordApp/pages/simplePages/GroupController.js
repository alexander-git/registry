(function() {
    
    var injectParams = ['$scope', '$routeParams', 'groups', 'NavigationService'];
    
    var GroupController = function($scope, $routeParams, groups, NavigationService) {
        $scope.$routeParams = $routeParams;

        $scope.workAreaCaption = "Выберите категорию";
        $scope.groups = groups;
        
        $scope.selectGroup = function(group) {
            NavigationService.setGroup(group);
        };
        
        $scope.workAreaContentUrl = '/recordAppViews/group.html';
    };
    
    GroupController.$inject = injectParams;
    
    angular.module('simplePages').controller('GroupController', GroupController);
    
})(); 
 
