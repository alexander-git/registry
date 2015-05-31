<?php

require '_init.php';
require_once '_jquery.php';
require_once '_jquery-tmpl.php';
require_once '_time.php';

$clientScript->registerCssFile($assetsUrl.'/css/items/timeEditor.css');

$clientScript->registerScriptFile($assetsUrl.'/script/items/timeEditor/TimeEditor.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/timeEditor/TimeEditorConst.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/timeEditor/TimeEditorSelectors.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/timeEditor/ModifyTimeFunctions.js');



