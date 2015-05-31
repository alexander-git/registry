<?php
/* @var $this TemplateWorkDayController */
/* @var $model TemplateWorkDay */

$this->pageTitle = 'Информация о шаблоне';
$this->additionalLayout = 'adminTemplateWorkDay';

Yii::import('application.helpers.TimeFormatHelper');

require_once '_defineMainMenu.php';
require_once '_defineTemplateWorkDayMenu.php';


$this->renderPartial('//include/_tableView');
$this->renderPartial('//include/_timeEditorPreparation');

if ($this->isUserCanModifyTemplateWorkDays) {
    $this->renderPartial('//admin/common/_itemDeleteConfirmationScript');
}

$timeEditorPreparationId = 'timeEditorPreparation';

Yii::app()->clientScript->registerScript(
   'viewTemplateWorkDay',
    "
    $(document).ready(function() {        
        var timeEditorPreparation = new TimeEditorPreparation('$timeEditorPreparationId');
    });
    ",
   CClientScript::POS_HEAD
); 



?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Информация о шаблоне
</div>
<div class= "mainBlock -roundedCornersBottom -blue">
    <?php $this->renderPartial('//admin/common/_successFlashMessage'); ?>
    <?php $this->renderPartial('//admin/common/_errorFlashMessage'); ?>
    <div class="-roundedCorners -cyan -margin10 ">
        <?php $this->widget('NullFormatDetailView', 
            array(
                'skin' => 'usingTableView',
                'data' => $model,
                'attributes'=>array(
                    'name',
                ),
            )
        );
        ?>  
        
        <div class="timeEditorPreparation -padding10" id="<?php echo $timeEditorPreparationId; ?>">    
            <div class="-notVisible">
                <?php foreach ($model->time as $t) :  ?> 
                    <div class="timeEditorPreparation__initialTimeItem">
                        <div class="timeEditorPreparation__initialTimeTextView"><?php echo TimeFormatHelper::timeDBViewToTimeShortTextView($t->time); ?></div>
                        <div class="timeEditorPreparation__initialTimeState"><?php echo $t->state; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
           
            <div class="-marginTop5">
                <?php $this->renderPartial('_timeView'); ?>
            </div>
        </div>
        <?php if (count($model->time) > 0 ) : ?>
            <div class="-line3 -blue"></div>  
        <?php endif; ?>
        
        <div class="-hidden -tableView--cellParameters">
            hidden
        </div>
        <?php if ($this->isUserCanModifyTemplateWorkDays) : ?>
            <div class="-padding10 -marginTop20">
                <div class="buttonsRow buttonsRow--usingLinkButtons">
                    <?php 
                        echo CHtml::link(
                            'Изменить', 
                            array(
                                'admin/templateWorkDay/update', 
                                 'id' => $model->id,
                            ),
                            array('class' => 'linkButton linkButton--default -azure -azure--action')
                        );
                    ?>
                    
                    <?php 
                        echo CHtml::link(
                            'Удалить', 
                            array(
                                'admin/templateWorkDay/delete', 
                                 'id' => $model->id,
                            ),
                            array('class' => 'linkButton linkButton--default -azure -azure--action -jsItemDeleteConfirmation')
                        );
                    ?>
                </div>
            </div>  
        <?php endif; ?>
            
    </div>
</div>