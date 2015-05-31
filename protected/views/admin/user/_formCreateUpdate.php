<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="tableForm tableForm--defaultLayout tableForm--usingInputItems">

<?php 
    Yii::import('application.constant.view.UserViewConst');

    $form = $this->beginWidget(
        'CActiveForm', 
        array(
            'id' => UserController::CREATE_UPDATE_USER_FORM_ID,
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'errorMessageCssClass' => 'tableForm__error -errorMessage',
        )
    ); 
?>
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'name'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo $form->textField(
                        $model, 
                        'name', 
                        array('maxlength' => 100, 'class' => 'inputItem', 'autocomplete' => 'off')
                    );
                 ?>
            </div>
            <?php echo $form->error($model, 'name'); ?>
        </div>
        <div class="-stopFloat"></div>
    </div>
  
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'password'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">    
                <?php
                    if ($showPasswordAsText) {
                        echo $form->textField(
                            $model, 
                            'password', 
                            array('maxlength' => 100, 'class' => 'inputItem', 'autocomplete' => 'off')
                        ); 
                    } else {
                        echo $form->passwordField(
                            $model, 
                            'password', 
                            array('maxlength' => 100, 'class' => 'inputItem', 'autocomplete' => 'off')
                        );
                    }
                ?>
            </div>
            <?php echo $form->error($model, 'password'); ?>
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    <div class="tableForm__row">
       <div class="tableForm__leftColumn">
           <div class="tableForm__label">
               <?php echo $form->labelEx($model, 'surname'); ?>
            </div>
       </div>
       <div class="tableForm__rightColumn">
           <div class="tableForm__input">
               <?php echo $form->textField(
                       $model,
                       'surname',
                       array('maxlength' => 100, 'class' => 'inputItem', 'autocomplete' => 'off')
                   ); 
               ?>
           </div>
           <?php echo $form->error($model, 'surname'); ?>
       </div>
       <div class="-stopFloat"></div>
    </div>

    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'firstname'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo $form->textField(
                        $model, 
                        'firstname',
                        array('maxlength' => 100, 'class' => 'inputItem', 'autocomplete' => 'off')
                    ); 
                ?>
            </div>
            <?php echo $form->error($model, 'firstname'); ?>
        </div>
        <div class="-stopFloat"></div>
    </div>

    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'patronymic'); ?>
             </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo $form->textField(
                        $model,
                        'patronymic',
                        array('maxlength' => 100, 'class' => 'inputItem', 'autocomplete' => 'off')
                    );
                ?>
            </div>
            <?php echo $form->error($model, 'patronymic'); ?>
        </div>
        <div class="-stopFloat"></div>
    </div>

    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'role'); ?>
             </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <span class="selectWrapper">
                    <?php echo $form->dropDownList(
                            $model, 
                            'role', 
                            UserViewConst::getRoleSelectListArray(),
                            array('class' => 'inputItem', 'autocomplete' => 'off')
                        ); 
                    ?>
                </span>
            </div>
            <?php echo $form->error($model,'role'); ?>
        </div>
        <div class="-stopFloat"></div>
    </div>

    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'enabled'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo $form->checkBox(
                        $model, 
                        'enabled',
                        array('class' => 'inputItem')
                    ); 
                ?>
             </div>
            <?php echo $form->error($model, 'enabled'); ?>  
        </div>
        <div class="-stopFloat"></div>
    </div>

    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="-hidden">hidden</div> 
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo CHtml::submitButton($submitButtonText, array('class' => 'inputItem -darkAzure -darkAzure--action') ); ?>
            </div>
        </div>
        <div class="-stopFloat"></div>
    </div>

<?php $this->endWidget(); ?>
    
</div>