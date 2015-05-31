(function() {
    
    var DEFAULT_ERROR_MESSAGE_TEXT = 'Произошла ошибка.';
    
    var injectParams = [
        '$scope', 
        '$http', 
        '$sce', 
        '$location', 
        'captchaActionConst', 
        'NavigationService', 
        'UrlService',
        'OrderService'
    ];
     
    var OrderFormController = function(
        $scope, 
        $http, 
        $sce, 
        $location, 
        captchaActionConst, 
        NavigationService, 
        UrlService,
        OrderService
    ) 
    {
        $scope.phonePattern = /^[0-9]*$/;
        $scope.namePartMaxLength = 100;
        $scope.phoneMaxLength = 100;
        // Так как, к сожалению, при валидации с использованим ng-pattern
        // отбрасываются пробелы вначале и в конце, т.е. для введенной строки сначала 
        // выполняется trim, а только потом идёт сравенеие по регулярному выражению, то 
        // запретим хотя бы вввод цифр и некоторых других символов 
        // в начале и в конце имени, фамилии и отчества.
        var fs = "\\d-_%&,!'`=#@$;~\"\\|\\:\\.\\?\\+\\*\\(\\)\\[\\]\\^\\/\\\\"; // Запрещённые символы.
        $scope.namePartPattern = new RegExp("^(?:[^"+fs+"].*[^"+fs+"]|[^"+fs+"]+)$"); 
        
        $scope.captchaCode = '';
        
        // Используется в виде когда выполняется ajax-запрос.
        $scope.isNeedShowProcess = false;
        
        $scope.isNeedShowError = false;
        $scope.errorMessage = '';
        
        // Загрузим капчу.
        refreshCaptcha();

        $scope.refreshCaptcha = function() {
            refreshCaptcha();
        };
             
        $scope.showError = function(ngModelController, error) {
            if (!ngModelController.$dirty) {
                return false;
            }
            return ngModelController.$error[error];
        };
        
        $scope.isCanSubmitForm = function() {
            return $scope.orderForm.$dirty && $scope.orderForm.$valid;
        };
        
        $scope.hideErrorMessage = function() {
            $scope.isNeedShowError = false;
        };
        
        $scope.submitForm = function() {
            // Получаем данные для формирования заявки  на основе выбора 
            // пользователя на предыдущих страницах.
            var navigationData = NavigationService.getNavigationDataObject();
            var specialization = navigationData.specialization;
            var doctor = navigationData.doctor;
            var workDay = navigationData.workDay;
            var workTime = navigationData.workTime;
            
            // Формируем заявку.
            var order = new OrderModel();
            order.idSpecialization = specialization.id;
            if (!specialization.needDoctor) {
                order.idDoctor = null;
            } else {
                order.idDoctor = doctor.id;
            }
            order.date = workDay.date;
            order.time = workTime.timeTextView;
            
            // Берём данные для заявки из формы.
            order.firstname = $scope.firstname; 
            order.surname = $scope.surname;
            order.patronymic = $scope.patronymic;
            order.phone = $scope.phone;
            
            var captchaCode = $scope.captchaCode;
            
            beforeAjaxRequest();
            var orderResult = OrderService.makeOrder(order, captchaCode);
            
            orderResult.success(function(data, status, headers, config) {
                makeOrderSuccess(data);
            }).error(function(data, status, headers, config) {
                makeOrderError();
            });
        };
        
        
        function refreshCaptcha() {
            $scope.isCaptchaRefreshErrorOccurred = false;
            var params = {};
            params[captchaActionConst.refreshGetVarName] = true;
            $http({
                'method' : 'GET',
                'url' : captchaActionConst.url,
                'params' : params
            }).success(function(data, status, headers, config) {
                $scope.captchaUrl = data.url;
            }).error(function(data, status, headers, config) {
                $scope.isCaptchaRefreshErrorOccurred = true;
            });
        }

        function beforeAjaxRequest() {
            $scope.isNeedShowProcess = true;
            $scope.isNeedShowError = false;
        }

        function afterAjaxRequest() {
            $scope.isNeedShowProcess = false;
        }

        function showErrorMessage(errors) {
            var html = '';
            var brTag = '<br />';
            // Если установлена общая ошибка, то покажем только её.
            if (errors.common !== undefined) {
                html = errors.common;
                $scope.errorMessage = $sce.trustAsHtml(html);
                $scope.isNeedShowError = true;
                return;
            }
            
            // Если состояние времени изменилось пока пользователь 
            // оформлял заявку, то покажем ему только это. 
            if (errors.time !== undefined) {
                html = errors.time;
                $scope.errorMessage = $sce.trustAsHtml(html);
                $scope.isNeedShowError = true;
                return;
            }

            if (errors.firstname !== undefined) {
                html += errors.firstname + brTag;
            }
            if (errors.surname !== undefined) {
                html += errors.surname + brTag;
            }
            if (errors.patronymic !== undefined) {
                html += errors.patronymic + brTag;
            }
            if (errors.phone !== undefined) {
                html += errors.phone + brTag;
            }
        
            if (errors.captchaCode !== undefined) {
                html += errors.captchaCode + brTag;
            }

            $scope.errorMessage = $sce.trustAsHtml(html);
            $scope.isNeedShowError = true;
        }
        
        function showDefaultErrorMessage() {
            var html = DEFAULT_ERROR_MESSAGE_TEXT;
            $scope.errorMessage = $sce.trustAsHtml(html);
            $scope.isNeedShowError = true;
        }
        
        // Вызывается при нормальном ответе сервера, 
        // но это не обязательно означает, что заявка была успешно оформлена.
        // Т.к. может быть прислано детальное сообщение об ошибках.
        function makeOrderSuccess(data) {
            afterAjaxRequest();
            refreshCaptcha();
            if (data.errors !== undefined) {
                var errors =  data.errors;
                showErrorMessage(errors);
            } else if (data.success !== undefined) {
                $location.url(UrlService.createSuccessUrlForLocation() );
            } else {
                showDefaultErrorMessage();
            }
        }
        
        // Вызывается при ошибке связанной с запросом на сервер.
        // Например при превышении времени ожидания ответа.
        function makeOrderError() {
            afterAjaxRequest();
            showDefaultErrorMessage();
            refreshCaptcha();
        }
                
    };
    
    OrderFormController.$inject = injectParams;
    
    
    angular.module('order').controller('OrderFormController', OrderFormController);
    
})(); 
 