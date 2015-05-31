<?php

require '_init.php';
require_once '_jquery.php';

$clientScript->registerCssFile($assetsUrl.'/css/admin/filterOrderItems.css');

$clientScript->registerScriptFile($assetsUrl.'/script/items/filterOrderItems/FilterOrderItems.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/filterOrderItems/FilterOrderItemsSelectors.js');