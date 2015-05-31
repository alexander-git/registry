<?php
/* @var $this UserController */
/* @var $data User */

  Yii::import('constant.view.UserViewConst');
  Yii::import('helpers.OutHelper');

?>

<div class="userList__listItem -cyan -cyan--linkDecoration -roundedCorners">
    <div class="userList__row">    
        <span class="userList__login">
            <?php 
                echo CHtml::link(
                    CHtml::encode($data->name), 
                    array('admin/user/view', 
                          'id' =>$data->id,
                    ),
                    array('class' => 'link')
                );
            ?>
        </span>
        <?php if (!OutHelper::isEmpty($data->firstname) ) : ?>
            <span class="userList__surnameFirstnamePatronymic">
                <?php 
                    $fullname = UserViewConst::getFullName($data->firstname, $data->surname, $data->patronymic);
                    $fullnameView = OutHelper::surroundWithBrackets($fullname);
                    echo CHtml::encode($fullnameView);
                ?>
            </span>
        <?php endif; ?>
    </div>
    
    <div class="userList__row">  
        <span class="userList__role">
            <?php echo CHtml::Encode(UserViewConst::getRoleTextView($data->role) ); ?>
        </span>
    </div>
    
    <div class="userList__row">
        <?php if ($data->enabled) : ?>
            <span class="userList__userEnabled">
                <?php echo CHtml::Encode(UserViewConst::ENABLED_TRUE_TEXT); ?>
            </span>
        <?php else : ?>
            <span class="userList__userDisabled">
                <?php echo CHtml::Encode(UserViewConst::ENABLED_FALSE_TEXT); ?>
            </span>
        <?php endif; ?>     
    </div>

    <div class="-marginTop15">
        <?php echo CHtml::link(
                       'Изменить', 
                       array('admin/user/update', 
                             'id' =>$data->id,
                       ),
                       array('class' => 'linkButton linkButton--small -grayBlue -grayBlue--action ')
               );
       ?>
       <?php echo CHtml::link(
                       'Удалить', 
                       array('admin/user/delete', 
                             'id' =>$data->id,
                       ),
                       array('class' => 'linkButton linkButton--small -grayBlue -grayBlue--action -jsListItemAjaxDeleteLink')
               );
       ?>
    </div>
</div>