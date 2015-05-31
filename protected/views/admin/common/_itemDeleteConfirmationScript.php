<?php

if (!isset($scriptName) ) {
    $scriptName = "itemDeleteConfirmation";
}

$this->renderPartial('//include/_jquery');
$this->renderPartial('//include/_Const');

$clientScript = Yii::app()->clientScript;

$clientScript->registerScript(
    $scriptName,
    "   
    $(document).ready(function() {
        $('.-jsItemDeleteConfirmation').live('click', function(e) {
            if (confirm(Const.CONFIRM_QUESTION) ) {
                return true;
            } else {
                return false;
            }
        });
    });
    ",
    CClientScript::POS_HEAD
);