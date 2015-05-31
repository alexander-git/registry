<?php
/* @var $this GroupController */
/* @var $data Group */

Yii::import('application.constant.view.GroupViewConst');

?>

<div class="groupList__listItem -cyan -cyan--linkDecoration -roundedCorners">
    <div class="groupList__row">    
        <span class="groupList__name">
            <?php 
                echo CHtml::link(
                    CHtml::encode($data->name), 
                    array('admin/group/view', 
                          'id' =>$data->id,
                    ),
                    array('class' => 'link')
                );
            ?>
        </span>
    </div>
    
    <div class="groupList__row">
        <?php if ($data->enabled) : ?>
            <span class="groupList__groupEnabled">
                <?php echo CHtml::Encode(GroupViewConst::ENABLED_TRUE_TEXT); ?>
            </span>
        <?php else : ?>
            <span class="groupList__userDisabled">
                <?php echo CHtml::Encode(GroupViewConst::ENABLED_FALSE_TEXT); ?>
            </span>
        <?php endif; ?>     
    </div>

    
    <?php if ($this->isUserCanModifyGroups) : ?>
        <div class="-marginTop15">
            <?php echo CHtml::link(
                           'Изменить', 
                           array('admin/group/update', 
                                 'id' =>$data->id,
                           ),
                           array('class' => 'linkButton linkButton--small -grayBlue -grayBlue--action ')
                   );
           ?>
           <?php echo CHtml::link(
                           'Удалить', 
                           array('admin/group/delete', 
                                 'id' =>$data->id,
                           ),
                           array('class' => 'linkButton linkButton--small -grayBlue -grayBlue--action -jsListItemAjaxDeleteLink')
                   );
           ?>
        </div>
    <?php endif; ?>
      
</div>