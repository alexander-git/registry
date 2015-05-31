<?php

$this->renderPartial('//include/_search');

$registerListenersScriptStr = "";
if (isset($jsEventListenersVarNames) ) {
    foreach ($jsEventListenersVarNames as $el) {
        $registerListenersScriptStr .= "$jsDialogVarName.addEventListener($el);\n";
    }
}   
 
Yii::app()->clientScript->registerScript(
   $scriptName,
    "
    $(document).ready(function() {
        var $jsDialogVarName = new Search('$idDialog', '$searchUrl', '$searchGetVarName', SearchViewMode.DIALOG);
        $registerListenersScriptStr
     });  
    ",
   CClientScript::POS_HEAD
);  