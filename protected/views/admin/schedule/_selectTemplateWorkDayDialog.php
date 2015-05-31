<?php

$selectTemplateWorkDayDialogId = 'selectTemplateWorkDayDialog'; 

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => $selectTemplateWorkDayDialogId ,
    'options' => array(
        'title' => 'Найти шаблон',
        'autoOpen' => false,
        'modal' => true,
        'resizable'=> true,
        'width' => 490,
        'height' => 'auto',
        'position' => 'center top+15%',
    ),
    'themeUrl' => '/css/jqueryUiThemes/',
    'theme' => 'main'
));
?>
    <?php  $this->renderPartial('//admin/common/_searchDialogContent', array('showAllButtonText' => 'Показать все') ); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); 