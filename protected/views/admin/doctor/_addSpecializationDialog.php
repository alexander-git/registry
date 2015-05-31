<?php
$specializationSearchUrl = Yii::app()->createUrl('/admin/search/specializationSelect'); 
$addSpecializationDialogId = 'addSpecializationDialog'; 
$JsEventListenerVarName = 'addSpecializationDialogListener'; 
$jsDialogVarName = 'addSpecializationDialog';

$this->renderPartial(
    '_addSpecializationScript', 
    array(
        'scriptName' => 'addSpecialization',
        'jsEventListenerVarName' => $JsEventListenerVarName,
    )
);

$this->renderPartial(
    '//admin/common/_searchDialogScript', 
    array(
        'scriptName' => 'addSpecializationDialog',
        'idDialog' => $addSpecializationDialogId,
        'searchUrl' =>  $specializationSearchUrl,
        'searchGetVarName' => 'search',
        'jsDialogVarName' => $jsDialogVarName,
        'jsEventListenersVarNames' => array($JsEventListenerVarName),
    )
);

?>

<?php $this->renderPartial('_doctorSpecializationTemplate', array('generateJsTemplate' => true) ); ?>
<?php 
// Диалог выбора специализации.
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'skin' => 'usingMainTheme',
    'id' => $addSpecializationDialogId,
    'options' => array(
        'title' => 'Добавить специализацию',
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