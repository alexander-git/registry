<?php
/* @var $this GroupController */
/* @var $model Group */
/* @var $form CActiveForm */
?>

<div class="tableForm tableForm--defaultLayout tableForm--usingInputItems">

<?php 
    Yii::import('constant.view.GroupViewConst');

    $form = $this->beginWidget(
        'CActiveForm', 
        array(
            'skin' => 'tableFormUsingAjaxValidation',
            'id' => GroupController::CREATE_UPDATE_GROUP_FORM_ID,
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
                        array('maxlength' => 255, 'class' => 'inputItem', 'autocomplete' => 'off')
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