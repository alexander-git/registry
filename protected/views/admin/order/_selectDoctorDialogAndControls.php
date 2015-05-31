<?php

if (
    !isset($idDoctorHiddenFieldId) ||
    !isset($doctorNameTextFieldId) ||
    !isset($selectDoctorDialogOpenButtonId) ||
    !isset($clearDoctorButtonId)
    )
{
    throw new LogicException();
}


$doctorSearchUrl = Yii::app()->createUrl('/admin/search/doctorSelect'); 
$selectDoctorDialogId = 'selectDoctorDialogId';
$JsEventListenerVarName = 'selectDoctorDialogListener'; 
$jsDialogVarName = 'selectDoctorDialog';

// Скрипт для кнопок открытия диалога и полей 
$this->renderPartial(
    '_selectWithDialogAndClearActionScript', 
    array(
        'scriptName' => 'selectClearDoctor',
        'dialogId' => $selectDoctorDialogId,
        'jsEventListenerVarName' => $JsEventListenerVarName,
        
        'valueContainerId' => $idDoctorHiddenFieldId,
        'textFieldId' => $doctorNameTextFieldId,
        'dialogOpenButtonId' => $selectDoctorDialogOpenButtonId,
        'clearButtonId' => $clearDoctorButtonId
    )
);

$this->renderPartial(
    '//admin/common/_searchDialogScript', 
    array(
        'scriptName' => 'selectDoctorDialog',
        'idDialog' => $selectDoctorDialogId,
        'searchUrl' =>  $doctorSearchUrl,
        'searchGetVarName' => 'search',
        'jsDialogVarName' => $jsDialogVarName,
        'jsEventListenersVarNames' => array($JsEventListenerVarName),
    )
);

?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'skin' => 'usingMainTheme',
    'id' => $selectDoctorDialogId,
    'options' => array(
        'title' => 'Выбрать врача',
        'autoOpen' => false,
        'modal' => true,
        'resizable'=> true,
        'width' => 490,
        'position' => 'center top+15%',
    ),
));
?>
    <?php  $this->renderPartial('//admin/common/_searchDialogContent', array('showAllButtonText' => 'Показать все') ); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); 