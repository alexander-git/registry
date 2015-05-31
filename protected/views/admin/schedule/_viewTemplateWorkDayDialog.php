<?php 
$viewTemplateWorkDayDialogId = 'viewTemplateWorkDayDialog';

$this->beginWidget('zii.widgets.jui.CJuiDialog', 
    array(
        'skin' => 'usingMainTheme',
        'id' => $viewTemplateWorkDayDialogId,
        'options' => array(
            'title' => 'Шаблон',
            'autoOpen' => false,
            'modal' => true,
            'resizable'=> true,
            'width' => 780,
            'height' => 'auto',
            'position' => 'center top+5%',      
        ),
    )
);
?>
    <?php  $this->renderPartial('_viewTemplateWorkDayDialogContent', array() ); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); 
