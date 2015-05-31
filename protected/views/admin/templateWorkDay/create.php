<?php
/* @var $this TemplateWorkDayController */
/* @var $model TemplateWorkDay */

require_once '_defineMainMenu.php';
require_once '_defineTemplateWorkDayMenu.php';
$this->makeMenuItemActiveOnUrl($this->templateWorkDayMenu, 'create');

$this->pageTitle = 'Создать шаблон';
$this->additionalLayout = 'adminTemplateWorkDay';

$this->renderPartial('//include/_timeEditorPreparation');

$timeEditorPreparationId = 'timeEditorPreparation';

Yii::app()->clientScript->registerScript(
   'createTemplateWorkDay',
    "
    $(document).ready(function() {        
        var timeEditorPreparation = new TimeEditorPreparation('$timeEditorPreparationId');
    });
    ",
   CClientScript::POS_HEAD
); 
?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Создать шаблон
</div>
<div class= "mainBlock -roundedCornersBottom -blue">     
    <?php 
        $partialViewData = array(
                'model' => $model,
                'submitButtonText' => 'Создать',
                'timeEditorPreparationId' => $timeEditorPreparationId,
        );
        
        if (isset($time) && isset($timeStates) ) {
            $partialViewData['creatingInitialTimeItemsMethod'] = 'arrays';
            $partialViewData['time'] = $time;
            $partialViewData['timeStates'] = $timeStates;
        } else {
            $partialViewData['creatingInitialTimeItemsMethod'] = 'none';
        }
        
        $this->renderPartial(
            '_formCreateUpdate', 
            $partialViewData
        ); 
    ?>
</div>
