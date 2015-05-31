<?php

require '_init.php';
require_once '_jquery.php';
require_once '_angular.php';


$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/common/common.js');
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/common/filters.js');

$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/pages/simplePages/simplePages.js');
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/pages/simplePages/GroupController.js');
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/pages/simplePages/SpecializationController.js');
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/pages/simplePages/DoctorController.js');
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/pages/simplePages/ScheduleController.js');
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/pages/simplePages/TimeController.js');
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/pages/simplePages/SuccessController.js');

$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/pages/order/order.js');
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/pages/order/OrderController.js');
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/pages/order/OrderFormController.js');
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/pages/order/OrderModel.js');
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/pages/order/OrderService.js');

$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/pageData/pageData.js');
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/pageData/PageDataService.js');

$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/navigation/navigation.js');
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/navigation/NavigationController.js');
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/navigation/NavigationService.js');

$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/url/url.js');
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/url/UrlService.js');
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/url/filters.js');

// Файл app.js располагается внизу страницы т.к. в нем используется 
// глобальная переменная из тега <script> генерируемого функцией 
// Yii::app()->clientScript->registerScript(она находится в другом файле). 
// А она(функция) записивает тег и его содержимое ниже всех script-файлов. 
// Если бы использовалось значение CClientScript::POS_HEAD(а оно используется по умолчанию) 
// файл app.js был бы  выше тега <script> и не видел бы его(тега) содержимго 
// с необходимой глобальной переменной.
$clientScript->registerScriptFile($assetsUrl.'/script/recordApp/app.js', CClientScript::POS_END);
