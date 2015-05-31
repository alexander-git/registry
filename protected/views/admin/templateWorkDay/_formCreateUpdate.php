<?php 
    if (!isset($creatingInitialTimeItemsMethod) ) {
        throw new LogicException();
    }
    if (!in_array($creatingInitialTimeItemsMethod, array('none', 'arrays' , 'model') ) ) {
        throw new LogicException();
    }
?>

<div class="timeEditorPreparation -useTwoColumns -useTwoColumns--left100 -defaultInputItemsFont -padding10" id="<?php echo $timeEditorPreparationId; ?>">
    <div class="timeEditorPreparation__timeItemAsInputTemplate -notVisible">
        <input name="time[]" type="hidden" value="${time}">
        <input name="timeStates[]" type="hidden" value="${timeState}">
    </div>
    
    <?php 
        // Создание начальных элементов time, которыми будет инициализирован
        // timeEditor.
    ?>
    <?php if ($creatingInitialTimeItemsMethod === 'arrays') : ?>
        <div class="-notVisible">
            <?php if (isset($time) && isset($timeStates) ) : ?>
                <?php for ($i = 0; $i < count($time); $i++) :  ?> 
                    <div class="timeEditorPreparation__initialTimeItem">
                        <div class="timeEditorPreparation__initialTimeTextView"><?php echo $time[$i];?></div>
                        <div class="timeEditorPreparation__initialTimeState"><?php echo $timeStates[$i]; ?></div>
                    </div>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
    <?php elseif ($creatingInitialTimeItemsMethod === 'model') : ?>
        <div class="-notVisible">
            <?php foreach ($model->time as $t) :  ?> 
                <div class="timeEditorPreparation__initialTimeItem">
                    <div class="timeEditorPreparation__initialTimeTextView"><?php echo TimeFormatHelper::timeDBViewToTimeShortTextView($t->time); ?></div>
                    <div class="timeEditorPreparation__initialTimeState"><?php echo $t->state; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php 
    $form = $this->beginWidget(
        'CActiveForm', 
        array(
            'skin' => 'usingAjaxValidation',
            'id' => TemplateWorkDayController::CREATE_UPDATE_TEMPLATE_WORK_DAY_FORM_ID,
        )
    ); 
?>
    <div class="twoColumns__row">
        <div class="twoColumns__left">
             <?php echo $form->labelEx($model, 'name'); ?>
        </div>
        <div class="twoColumns__right">
            <?php echo $form->textField(
                    $model, 
                    'name', 
                    array('maxlength' => 255, 'class' => 'inputItem', 'autocomplete' => 'off', 'style' => 'width : 260px;')
                );
             ?>
            <div class="-marginTop10 -marginBottom10" style="font-size : 18px;">
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
    </div>
    <div class="timeEditorPreparation__timeItemsConvertedToInputs -notVisible"></div>
   
    <div class="-marginTop5">
        <?php $this->renderPartial('_timeEditor'); ?>
    </div>
    
    <div class="twoColumns__row -marginTop20">
        <div class="twoColumns__left">
            <div class="-hidden">hidden</div>
        </div>
        <div class="twoColumns__right">
             <?php echo CHtml::submitButton($submitButtonText, array('class' => 'timeEditorPreparation__performButton inputItem -darkAzure -darkAzure--action', 'style' => 'width : 200px;') ); ?>
        </div>
    </div>
   
<?php $this->endWidget(); ?>
    
</div>