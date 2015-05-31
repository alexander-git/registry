<?php
/* @var $this SpecializationController */
/* @var $data Specialization */
?>
<div class="templateWorkDayList__listItem -cyan -cyan--linkDecoration -roundedCorners">
    <div class="templateWorkDayList__listItem__row">    
        <span class="templateWorkDayList__listItem__name">
            <?php 
                echo CHtml::link(
                    CHtml::encode($data->name), 
                    array('admin/templateWorkDay/view', 
                          'id' =>$data->id,
                    ),
                    array('class' => 'link')
                );
            ?>
        </span>
    </div>
    
    <?php if ($this->isUserCanModifyTemplateWorkDays) : ?>
        <br/>
        <?php echo CHtml::link(
                       'Изменить', 
                       array('admin/templateWorkDay/update', 
                             'id' =>$data->id,
                       ),
                       array('class' => 'linkButton linkButton--small -grayBlue -grayBlue--action ')
               );
       ?>
       <?php echo CHtml::link(
                       'Удалить', 
                       array('admin/templateWorkDay/delete', 
                             'id' =>$data->id,
                       ),
                       array('class' => 'linkButton linkButton--small -grayBlue -grayBlue--action -jsListItemAjaxDeleteLink')
               );
       ?>
    <?php endif; ?>
</div>