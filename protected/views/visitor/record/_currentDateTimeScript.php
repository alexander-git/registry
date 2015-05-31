<?php

$this->renderPartial('//include/_jquery');
$this->renderPartial('//include/_Clock');

Yii::import('helpers.DateTimeFormatHelper');
$currentDateTimeJs = DateTimeFormatHelper::getDateTimeJSView($currentDateTime);
$currentDateTimeContainerSelector = '#'.$currentDateTimeContainerId;

Yii::app()->clientScript->registerScript(
   'currentDateTime',
    "
    $(document).ready(function() {        
        
       var initialDate = new Date();
       initialDate.setTime(Date.parse('$currentDateTimeJs') );
        
       var clock = new Clock(initialDate, '$currentDateTimeContainerSelector');
    });
    ",
   CClientScript::POS_HEAD
); 
