<?php
require '_init.php';
require_once '_jquery.php';
require_once '_event.php';
require_once '_timeEditor.php';

$clientScript->registerCssFile($assetsUrl.'/css/items/workDayItems/safeWorkDay.css');

$clientScript->registerScriptFile($assetsUrl.'/script/items/workDayItems/common/WorkDayModel.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/workDayItems/common/WorkDayEvents.js');

$clientScript->registerScriptFile($assetsUrl.'/script/items/workDayItems/safeWorkDay/SafeWorkDay.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/workDayItems/safeWorkDay/SafeWorkDaySelectors.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/workDayItems/safeWorkDay/SafeWorkDayViewMode.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/workDayItems/safeWorkDay/SafeWorkDayConst.js');

