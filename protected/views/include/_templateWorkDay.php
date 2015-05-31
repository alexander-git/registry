<?php

require '_init.php';
require_once '_jquery.php';
require_once '_event.php';
require_once '_timeEditor.php';

$clientScript->registerCssFile($assetsUrl.'/css/items/templateWorkDay.css');

$clientScript->registerScriptFile($assetsUrl.'/script/items/templateWorkDay/TemplateWorkDay.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/templateWorkDay/TemplateWorkDayModel.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/templateWorkDay/TemplateWorkDaySelectors.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/templateWorkDay/TemplateWorkDayViewMode.js');