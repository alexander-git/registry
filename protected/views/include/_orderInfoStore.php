<?php

require '_init.php';
require_once '_jquery.php';

$clientScript->registerCssFile($assetsUrl.'/css/items/orderInfoStore.css');

$clientScript->registerScriptFile($assetsUrl.'/script/items/orderInfoStore/OrderInfoStore.js');
$clientScript->registerScriptFile($assetsUrl.'/script/items/orderInfoStore/OrderInfoStoreSelectors.js');
