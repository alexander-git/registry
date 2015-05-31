<?php

if (
    !isset($idSpecializationHiddenFieldId) ||
    !isset($specializationNameTextFieldId) ||
    !isset($selectSpecializationDialogOpenButtonId) ||
    !isset($clearSpecializationButtonId)
    )
{
    throw new LogicException();
}


$specializationSearchUrl = Yii::app()->createUrl('/admin/search/specializationSelect'); 
$selectSpecializationDialogId = 'selectSpecializationDialogId';
$JsEventListenerVarName = 'selectSpecializationDialogListener'; 
$jsDialogVarName = 'selectSpecializationDialog';

// Скрипт для кнопок открытия диалога и полей 
$this->renderPartial(
    '_selectWithDialogAndClearActionScript', 
    array(
        'scriptName' => 'selectClearSpecialization',
        'dialogId' => $selectSpecializationDialogId,
        'jsEventListenerVarName' => $JsEventListenerVarName,
        
        'valueContainerId' => $idSpecializationHiddenFieldId,
        'textFieldId' => $specializationNameTextFieldId,
        'dialogOpenButtonId' => $selectSpecializationDialogOpenButtonId,
        'clearButtonId' => $clearSpecializationButtonId
    )
);

$this->renderPartial(
    '//admin/common/_searchDialogScript', 
    array(
        'scriptName' => 'selectSpecializationDialog',
        'idDialog' => $selectSpecializationDialogId,
        'searchUrl' =>  $specializationSearchUrl,
        'searchGetVarName' => 'search',
        'jsDialogVarName' => $jsDialogVarName,
        'jsEventListenersVarNames' => array($JsEventListenerVarName),
    )
);

?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'skin' => 'usingMainTheme',
    'id' => $selectSpecializationDialogId,
    'options' => array(
        'title' => 'Выбрать специализацию',
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