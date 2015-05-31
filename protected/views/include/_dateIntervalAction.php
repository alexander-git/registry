<?php

require '_init.php';
require_once '_jquery.php';

$clientScript->registerCssFile($assetsUrl.'/css/admin/dateIntervalAction.css');

$clientScript->registerScriptFile($assetsUrl.'/script/items/dateIntervalAction/DateIntervalAction.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/dateIntervalAction/DateIntervalActionSelectors.js');