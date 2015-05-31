<?php

require '_init.php';
require_once '_jquery.php';
require_once '_event.php';

$clientScript->registerCssFile($assetsUrl.'/css/items/search.css');

$clientScript->registerScriptFile($assetsUrl.'/script/items/search/Search.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/search/SearchSelectors.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/search/SearchEvents.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/search/SearchViewMode.js');
