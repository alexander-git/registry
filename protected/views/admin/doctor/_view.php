<?php
/* @var $this DoctorController */
/* @var $data Doctor */

Yii::import('constant.view.DoctorViewConst');
Yii::import('helpers.OutHelper');

?>

<div class="doctorList__listItem -cyan -cyan--linkDecoration -roundedCorners">
    <div class="doctorList__row">    
        <span class="doctorList__surnameFirstnamePatronimycAdditonal">
            <?php
             
                $surname = CHtml::encode($data->surname);
                $firstname = CHtml::encode($data->firstname);
                $patronymic = CHtml::encode($data->patronymic);
                $name =  OutHelper::insertSpacesBetweenValues($surname, $firstname, $patronymic);
            
                echo CHtml::link(
                    $name, 
                    array('admin/doctor/view', 
                          'id' => $data->id,
                    ),
                    array('class' => 'link')
                );
            ?>
             <?php if (!OutHelper::isEmpty($data->additional) ) : ?>
                <span class="doctorList__additional">
                    (<?php echo CHtml::encode($data->additional); ?>)
                </span>
            <?php endif; ?>
        </span>
    </div>
    
    <div class="doctorList__row">
        <?php if ($data->enabled) : ?>
            <span class="doctorList__doctorEnabled">
                <?php echo CHtml::encode(DoctorViewConst::ENABLED_TRUE_TEXT); ?>
            </span>
        <?php else : ?>
            <span class="doctorList__doctorDisabled">
                <?php echo CHtml::encode(DoctorViewConst::ENABLED_FALSE_TEXT); ?>
            </span>
        <?php endif; ?>     
    </div>
    
    <div class="doctorList__row">
        <span class="doctorList__speciality">
            <?php echo CHtml::encode($data->speciality); ?>
        </span>
    </div>

    <?php if ($this->isUserCanModifyDoctors) : ?>
        <br/>
        <?php 
            echo CHtml::link(
                'Изменить', 
                array('admin/doctor/update', 'id' =>$data->id),
                array('class' => 'linkButton linkButton--small -grayBlue -grayBlue--action ')
            );
       ?>
       <?php 
        echo CHtml::link(
                'Удалить', 
                array('admin/doctor/delete', 'id' =>$data->id),
                array('class' => 'linkButton linkButton--small -grayBlue -grayBlue--action -jsListItemAjaxDeleteLink')
            );
       ?>
    <?php endif; ?>
</div>