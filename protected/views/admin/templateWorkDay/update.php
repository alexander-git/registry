<?php
/* @var $this TemplateWorkDayController */
/* @var $model TemplateWorkDay */

require_once '_defineMainMenu.php';
require_once '_defineTemplateWorkDayMenu.php';

$this->pageTitle = 'Обновить шаблон';
$this->additionalLayout = 'adminTemplateWorkDay';

$this->renderPartial('//include/_timeEditorPreparation');

$timeEditorPreparationId = 'timeEditorPreparation';

Yii::app()->clientScript->registerScript(
   'updateTemplateWorkDay',
    "
    $(document).ready(function() {        
        var timeEditorPreparation = new TimeEditorPreparation('$timeEditorPreparationId');
    });
    ",
   CClientScript::POS_HEAD
); 
?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Обновить шаблон
</div>
<div class= "mainBlock -roundedCornersBottom -blue">     
    <?php 
        $this->renderPartial(
            '_formCreateUpdate', 
            array(
                'model' => $model,
                'submitButtonText' => 'Обновить',
                'timeEditorPreparationId' => $timeEditorPreparationId,
                'creatingInitialTimeItemsMethod' => 'model'
            ) 
        ); 
    ?>
</div>
