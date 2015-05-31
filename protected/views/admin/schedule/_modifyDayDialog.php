<?php 
$modifyDayDialogId = 'modifyDayDialog';

$this->beginWidget('zii.widgets.jui.CJuiDialog', 
    array(
        'skin' => 'usingMainTheme',
        'id' => $modifyDayDialogId ,
        'options' => array(
            'title' => 'Задать расписание на день',
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
    <?php  $this->renderPartial('_modifyDayDialogContent', array() ); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); 
