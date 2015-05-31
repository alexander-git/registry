<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */

?>
<?php
    $specializationNameTextFieldId = 'specializationNameTextField';
    $idSpecializationHiddenFieldId = 'idSpecializationHiddenField';
    $selectSpecializationDialogOpenButtonId = 'selectSpecializationDialogOpenButton';
    $clearSpecializationButtonId = 'clearSpecializationButton';

    $doctorNameTextFieldId = 'doctorNameTextField';
    $idDoctorHiddenFieldId = 'idDoctorHiddenField';
    $selectDoctorDialogOpenButtonId = 'selectDoctorDialogOpenButton';
    $clearDoctorButtonId = 'clearDoctorButton';

    $this->renderPartial(
        '_selectSpecializationDialogAndControls',
        array(
            'idSpecializationHiddenFieldId' => $idSpecializationHiddenFieldId,
            'specializationNameTextFieldId' => $specializationNameTextFieldId,
            'selectSpecializationDialogOpenButtonId' => $selectSpecializationDialogOpenButtonId,
            'clearSpecializationButtonId' => $clearSpecializationButtonId
        )
    );

    $this->renderPartial(
        '_selectDoctorDialogAndControls',
        array(
            'idDoctorHiddenFieldId' => $idDoctorHiddenFieldId,
            'doctorNameTextFieldId' => $doctorNameTextFieldId,
            'selectDoctorDialogOpenButtonId' => $selectDoctorDialogOpenButtonId,
            'clearDoctorButtonId' => $clearDoctorButtonId
        )
    );
    
?>


<div class="tableForm tableForm--wideLeftColumnLayout tableForm--usingInputItems">

<?php 
    Yii::import('constant.view.OrderViewConst');
    Yii::import('constant.view.SpecializationViewConst');
    Yii::import('constant.view.DoctorViewConst'); 
    
    $form = $this->beginWidget(
        'CActiveForm', 
        array(
            'skin' => 'tableFormUsingAjaxValidation',
            'id' => OrderController::CREATE_UPDATE_ORDER_FORM_ID,
        )
    );
?>
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
                <?php echo $form->labelEx($model, 'phone'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo $form->textField(
                        $model, 
                        'phone', 
                        array('maxlength' => 255, 'class' => 'inputItem', 'autocomplete' => 'off')
                    );
                 ?>
            </div>
            <?php echo $form->error($model, 'phone'); ?>
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'idSpecialization'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php 
                    // Имя специализации не посылаем(и не валидируем) - посылаем только idSpecialization.
                    // Поэтому для вывода имени используется обычный CHtml::textField, а
                    // не метод CActiceForm
                ?>
                <?php  
                    // Этот же $idSpecializationHiddenFieldId нужно указать
                    // в качестве inputID при использовании метода 
                    // $form->error(). Иначе ошибки обнаруженные с помощью 
                    // валидации через ajax будет не будут отображаться.
                    echo $form->hiddenField(
                        $model, 
                        'idSpecialization',
                        array('id' => $idSpecializationHiddenFieldId)
                    ); 
                ?>
                <?php
                    $specializationName = '';
                    if ($model->specialization !== null) {   
                        $specializationName = SpecializationViewConst::getSpecializationTextView(
                            $model->specialization->name, 
                            $model->specialization->additional
                        ); 
                    }
                
                    echo CHtml::textField(
                        '', 
                        $specializationName, 
                        array(
                            'id' => $specializationNameTextFieldId,
                            'class' => 'inputItem', 
                            'readonly' => 'readonly',
                            'autocomplete' => 'off',
                            'size' => 255
                        ) 
                    );
                ?>
                <div class="-marginTop10">
                    <?php 
                        echo CHtml::button(
                            "Выбрать", 
                            array(
                                'id' => $selectSpecializationDialogOpenButtonId,
                                'class' => 'inputItem -darkAzure -darkAzure--action',
                                'style' => 'width : 100px;',
                            ) 
                        ); 
                    ?>
                    <span class="-marginLeft5">
                        <?php 
                            echo CHtml::button(
                                "Удалить", 
                                array(
                                    'id' => $clearSpecializationButtonId,
                                    'class' => 'inputItem -darkAzure -darkAzure--action',
                                    'style' => 'width : 100px;',
                                ) 
                            ); 
                        ?>
                    </span>
                </div>
            </div>
            <?php 
                echo $form->error(
                    $model, 
                    'idSpecialization', 
                    array('inputID' => $idSpecializationHiddenFieldId) 
                ); 
            ?>
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'idDoctor'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php 
                    // Имя врача не посылаем(и не валидируем) - посылаем только idDoctor.
                    // Поэтому для вывода имени используется обычный CHtml::textField, а
                    // не метод CActiceForm
                ?>
                <?php 
                    echo $form->hiddenField(
                        $model, 
                        'idDoctor',
                        array('id' => $idDoctorHiddenFieldId)
                    ); 
                ?>
                <?php
                    $doctorName = '';
                    if ($model->doctor !== null) {   
                        $doctorName = DoctorViewConst::getDoctorTextView(
                            $model->doctor->firstname, 
                            $model->doctor->surname, 
                            $model->doctor->patronymic,
                            $model->doctor->additional 
                        );
                    }
                    echo CHtml::textField(
                        '', 
                        $doctorName, 
                        array(
                            'id' => $doctorNameTextFieldId,
                            'class' => 'inputItem', 
                            'readonly' => 'readonly',
                            'autocomplete' => 'off',
                            'size' => 255
                        ) 
                    );
                ?>
                <div class="-marginTop10">
                    <?php 
                        echo CHtml::button(
                            "Выбрать", 
                            array(
                                'id' => $selectDoctorDialogOpenButtonId,
                                'class' => 'inputItem -darkAzure -darkAzure--action',
                                'style' => 'width : 100px;',
                            ) 
                        ); 
                    ?>
                    <span class="-marginLeft5">
                        <?php 
                            echo CHtml::button(
                                "Удалить", 
                                array(
                                    'id' => $clearDoctorButtonId,
                                    'class' => 'inputItem -darkAzure -darkAzure--action',
                                    'style' => 'width : 100px;',
                                ) 
                            ); 
                        ?>
                    </span>
                </div>
            </div>
            <?php echo $form->error($model, 'idDoctor'); ?>
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'date'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php 
                    $this->widget('CMaskedTextField', 
                        array(
                            'model' => $model, 
                            'attribute' => 'date',
                            'mask' => '99-99-9999',
                            'htmlOptions' => array(
                                'class' => 'inputItem inputItem--masked',
                                'autocomplete' => 'off',
                                'size' =>  '10',
                                
                                // Иначе модификатор tableForm--usingInputItems установливает 
                                // определённый размер поля, а нам нужно чтобы его длинна 
                                // определялась количеством введённых цыфр.
                                'style' => 'width : auto'  
                            ),                    
                        )
                    );
                ?>
            </div>
            <?php echo $form->error($model, 'date'); ?>
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'time'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php 
                    $this->widget('CMaskedTextField', 
                        array(
                            'model' => $model, 
                            'attribute' => 'time',
                            'mask' => '99:99',
                            'htmlOptions' => array(
                                'class' => 'inputItem inputItem--masked',
                                'autocomplete' => 'off',
                                'size' =>  '5',
                            ),                    
                        )
                    );
                ?>
            </div>
            <?php echo $form->error($model, 'time'); ?>
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'orderDateTime'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php 
                    $this->widget('CMaskedTextField', 
                        array(
                            'model' => $model, 
                            'attribute' => 'orderDateTime',
                            'mask' => '99-99-9999 99:99:99',
                            'htmlOptions' => array(
                                'class' => 'inputItem inputItem--masked',
                                'autocomplete' => 'off',
                                'size' =>  '19',
                            ),                    
                        )
                    );
                ?>
            </div>
            <?php echo $form->error($model, 'orderDateTime'); ?>
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'processed'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo $form->checkBox(
                        $model, 
                        'processed',
                        array('class' => 'inputItem')
                    ); 
                ?>
             </div>
            <?php echo $form->error($model, 'processed'); ?>  
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'state'); ?>
             </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <span class="selectWrapper">
                    <?php echo $form->dropDownList(
                            $model, 
                            'state', 
                            OrderViewConst::getStateArrayForSelectTag(),
                            array('class' => 'inputItem', 'autocomplete' => 'off')
                        ); 
                    ?>
                </span>
            </div>
            <?php echo $form->error($model,'state'); ?>
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
