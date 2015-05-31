(function() {
                
    var injectParams = [];
      
    var OrderServiceProvider = function() {
        
        var _makeOrderUrl;
        
        this.setMakeOrderUrl = function (value) {
            _makeOrderUrl = value;
        };
        
        this.$get  = ['$http', function($http) {                      
            
            var service = {};
            
            service.makeOrder = function(orderModel, captchaCode) {   
                var requestData = {};
                requestData['Order'] = orderModel;
                requestData['captchaCode'] = captchaCode;
                
                return $http({
                    'method' : 'POST',
                    'url' : _makeOrderUrl,
                    'data' : requestData
                });
            };
            
            return service;
        }];       
        
    };
    
    OrderServiceProvider.$inject = injectParams;
    
    angular.module('order').provider('OrderService', OrderServiceProvider);
    
}()); 
 