<div class="tableForm tableForm--wideLeftColumnLayout tableForm--usingInputItems">
<?php 
    $form = $this->beginWidget(
        'CActiveForm', 
        array(
            'skin' => 'tableFormUsingAjaxValidation',
            'id' => ManageController::UPDATE_APPLICATION_CONFIG_FORM_ID,
        )
    ); 
?>
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'timeZone'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo $form->textField(
                        $model, 
                        'timeZone', 
                        array('maxlength' => 255, 'class' => 'inputItem', 'autocomplete' => 'off')
                    );
                 ?>
            </div>
            <?php echo $form->error($model, 'timeZone'); ?>
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'startingOffsetInDaysOfScheduleForVisitors'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo $form->textField(
                        $model, 
                        'startingOffsetInDaysOfScheduleForVisitors', 
                        array('maxlength' => 255, 'class' => 'inputItem', 'autocomplete' => 'off')
                    );
                 ?>
            </div>
            <?php echo $form->error($model, 'startingOffsetInDaysOfScheduleForVisitors'); ?>
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'phonePattern'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo $form->textField(
                        $model, 
                        'phonePattern', 
                        array('maxlength' => 255, 'class' => 'inputItem', 'autocomplete' => 'off')
                    );
                 ?>
             </div>
            <?php echo $form->error($model, 'phonePattern'); ?>  
        </div>
        <div class="-stopFloat"></div>
    </div>
  
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'makeTimeBusyOnOrder'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo $form->checkBox(
                        $model, 
                        'makeTimeBusyOnOrder',
                        array('class' => 'inputItem')
                    ); 
                ?>
             </div>
            <?php echo $form->error($model, 'makeTimeBusyOnOrder'); ?>  
        </div>
        <div class="-stopFloat"></div>
    </div>
    
  
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="-hidden">hidden</div> 
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo CHtml::submitButton('Изменить', array('class' => 'inputItem -darkAzure -darkAzure--action') ); ?>
            </div>
        </div>
        <div class="-stopFloat"></div>
    </div>

<?php $this->endWidget(); ?>
    
</div>