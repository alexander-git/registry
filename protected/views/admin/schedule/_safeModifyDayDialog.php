<?php 
$safeModifyDayDialogId = 'safeModifyDayDialog';

$this->beginWidget('zii.widgets.jui.CJuiDialog', 
    array(
        'skin' => 'usingMainTheme',
        'id' => $safeModifyDayDialogId,
        'options' => array(
            'title' => 'Изменение расписания',
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
    <?php  $this->renderPartial('_safeModifyDayDialogContent', array() ); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); 
