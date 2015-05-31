<?php

require '_init.php';
require_once '_jquery.php';
require_once '_timeEditor.php';

$clientScript->registerCssFile($assetsUrl.'/css/items/timeEditorPreparation.css');

$clientScript->registerScriptFile($assetsUrl.'/script/items/timeEditorPreparation/TimeEditorPreparation.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/timeEditorPreparation/TimeEditorPreparationSelectors.js');

