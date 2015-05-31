<?php

require '_init.php';
require_once '_jquery.php';
require_once '_event.php';
require_once '_timeEditor.php';

$clientScript->registerCssFile($assetsUrl.'/css/items/workDayItems/workDay.css');

$clientScript->registerScriptFile($assetsUrl.'/script/items/workDayItems/common/WorkDayModel.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/workDayItems/common/WorkDayEvents.js');

$clientScript->registerScriptFile($assetsUrl.'/script/items/workDayItems/workDay/WorkDay.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/workDayItems/workDay/WorkDaySelectors.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/workDayItems/workDay/WorkDayViewMode.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/workDayItems/workDay/WorkDayUseMode.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/workDayItems/workDay/WorkDayConst.js');;