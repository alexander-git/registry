<?php

require '_init.php';
require_once '_jquery.php';
require_once '_workDay.php';
require_once '_safeWorkDay.php';
require_once '_templateWorkDay.php';
require_once '_search.php';
require_once '_Const.php';

$clientScript->registerCssFile($assetsUrl.'/css/items/schedule.css');

$clientScript->registerScriptFile($assetsUrl.'/script/items/schedule/Schedule.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/schedule/ScheduleSelectors.js');


