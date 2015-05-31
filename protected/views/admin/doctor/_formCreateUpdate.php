<?php
/* @var $this DoctorController */
/* @var $model Doctor */
/* @var $form CActiveForm */

Yii::import('application.constant.view.SpecializationViewConst');

require_once '_addSpecializationDialog.php';

?>
<div class="tableForm tableForm--wideLeftColumnLayout tableForm--usingInputItems">
<?php 
    $form = $this->beginWidget(
        'CActiveForm', 
        array(
            'skin' => 'tableFormUsingAjaxValidation',
            'id' => DoctorController::CREATE_UPDATE_DOCTOR_FORM_ID,
        )
    ); 
?>
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                  <?php  echo $form->labelEx($model, 'surname'); ?> 
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo $form->textField(
                        $model, 
                        'surname', 
                        array('maxlength' => 255, 'class' => 'inputItem', 'autocomplete' => 'off')
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
                        array('maxlength' => 255, 'class' => 'inputItem', 'autocomplete' => 'off')
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
                        array('maxlength' => 255, 'class' => 'inputItem', 'autocomplete' => 'off')
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
                <?php echo $form->labelEx($model, 'additional'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo $form->textField(
                        $model, 
                        'additional', 
                        array('maxlength' => 255, 'class' => 'inputItem', 'autocomplete' => 'off')
                    );
                 ?>
             </div>
            <?php echo $form->error($model, 'additional', array(), false); ?>  
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'speciality'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo $form->textField(
                        $model, 
                        'speciality', 
                        array('maxlength' => 255, 'class' => 'inputItem', 'autocomplete' => 'off')
                    );
                 ?>
             </div>
            <?php echo $form->error($model, 'speciality'); ?>  
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
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'info', array('label' => 'Доп. информация') ); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php 
                    echo $form->textArea($model, 'info', array('class' => 'inputItem', 'rows' => '6', 'autocomplete' => 'off') )
                ?>
             </div>
            <?php echo $form->error($model, 'info'); ?>  
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="-hidden">hidden</div> 
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
               <?php 
                    echo CHtml::button(
                        "Добавить \n специализацию", 
                        array(
                            'class' => 'inputItem -darkAzure -darkAzure--action',
                            'id' => 'addSpecializationButton',
                            'onclick' => "$('#$addSpecializationDialogId').dialog('open'); return false;"
                        ) 
                    ); 
                ?>
            </div>
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="-hidden">hidden</div> 
        </div>
        <div class="tableForm__rightColumn">
            <div class="doctorSpecializations">
                <?php 
                    if ($isNeedShowSpecializationsFromModel) { 
                        foreach($model->specializations as $s) {
                            $text = SpecializationViewConst::getSpecializationTextView($s->name, $s->additional);
                            $this->renderPartial(
                                '_doctorSpecializationTemplate', 
                                array(
                                    'generateJsTemplate' => false,
                                    'text' => $text,
                                    'id' => $s->id,
                                )
                            );
                        }
                    }
                ?>
            </div>
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
