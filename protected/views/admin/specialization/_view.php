<?php
/* @var $this SpecializationController */
/* @var $data Specialization */

Yii::import('constant.view.SpecializationViewConst');

?>

<div class="specializationList__listItem -cyan -cyan--linkDecoration -roundedCorners">
    <div class="specializationList__row">    
        <span class="specializationList__name">
            <?php 
                echo CHtml::link(
                    CHtml::encode($data->name), 
                    array('admin/specialization/view', 
                          'id' =>$data->id,
                    ),
                    array('class' => 'link')
                );
            ?>
        </span>
        <?php if ( ($data->additional != null) && (trim($data->additional) !== '') ) : ?>
            <span class="specializationList__additional">
                (<?php echo CHtml::encode($data->additional); ?>)
            </span>
        <?php endif; ?>
    </div>
    
    <div class="specializationList__row">
        <?php $enabledText =  CHtml::encode(SpecializationViewConst::getEnabledTextView($data->enabled) ); ?>
        <?php if ($data->enabled) : ?>
            <span class="specializationList__specializationEnabled">
                <?php $enabledText; ?>
            </span>
        <?php else : ?>
            <span class="specializationList__specializationDisabled">
                <?php $enabledText; ?>
            </span>
        <?php endif; ?>     
    </div>
    
    <div class="specializationList__row">
        <span class="specializationList__needDoctor">
            <?php echo CHtml::encode(SpecializationViewConst::getNeedDoctorTextView($data->needDoctor) ); ?>
        </span>
    </div>
    
    <div class="specializationList__row">
        <span class="specializationList__recordOnTime">
            <?php echo CHtml::encode(SpecializationViewConst::getRecordOnTimeTextView($data->recordOnTime) ); ?>
        </span>
    </div>
    
    <div class="specializationList__row">
        <span class="specializationList__provisionalRecord">
            <?php echo CHtml::encode(SpecializationViewConst::getProvisionalRecordTextView($data->provisionalRecord) ); ?>
        </span>
    </div>
    
    <?php if ($data->group !== null) : ?>
        <div class="specializationList__row">
            <span class="specializationList__group">
                Группа :
                <?php 
                    echo CHtml::link(
                        CHtml::encode($data->group->name), 
                        array('admin/group/view', 
                              'id' =>$data->idGroup,
                        ),
                        array('class' => 'link')
                    );
                ?>
            </span>
        </div>
    <?php endif; ?>

    <?php if ($this->isUserCanModifySpecializations) : ?>
        <br/>
        <?php 
            echo CHtml::link(
                'Изменить', 
                array('admin/specialization/update', 
                      'id' =>$data->id,
                ),
                array('class' => 'linkButton linkButton--small -grayBlue -grayBlue--action ')
            );
       ?>
       <?php 
            echo CHtml::link(
                'Удалить', 
                array('admin/specialization/delete', 
                      'id' =>$data->id,
                ),
                array('class' => 'linkButton linkButton--small -grayBlue -grayBlue--action -jsListItemAjaxDeleteLink')
            );
       ?>
    <?php endif; ?>
</div>