<?php
/* @var $this SpecializationController */
/* @var $model Specialization */
/* @var $form CActiveForm */

?>

<div class="tableForm tableForm--wideLeftColumnLayout tableForm--usingInputItems">
<?php 
    Yii::import('constant.view.SpecializationViewConst');

    $form = $this->beginWidget(
        'CActiveForm', 
        array(
            'skin' => 'tableFormUsingAjaxValidation',
            'id' => SpecializationController::CREATE_UPDATE_SPECIALIZATION_FORM_ID,
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
            <?php echo $form->error($model, 'additional'); ?>
            <?php 
                // Т.к. поля name и additional проверяются вместе на 
                // уникальность, но само правило валидации привязано к полю
                // additional, то в случае неуникальности этих полей 
                // под полем additional будет отображена ошибка. При этом
                // пользователь может либо исправить поле additional, чтобы 
                // добиться уникальности - в этом случае валидацию через ajax
                // пройдёт успешно и ошибка исчезнет. Либо изменить поле name
                // в этом случае сообщение об ошибка сразу не исчезнет, т.к 
                // правило валидации привязано к полю additional, хотя если 
                // отправить форму валидация пройдёт успешно. Всё это может 
                // запутать пользователя, поэтому можно использовать и
                // другой вариант - отключить валидацию поля additional через
                // ajax. Но здесь сбить с толку пользователя может 
                // другое - после отправки формы с неуникальными полями name и
                // additional отобразиться сообщение об ошибке. Оно не исчезнет
                // после исправления, пока пользователь не отправит форму 
                // заново, хотя другие поля будут валидироваться через ajax.
                
                //echo $form->error($model, 'additional', array(), false); 
            ?> 
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
                <?php echo $form->labelEx($model, 'needDoctor'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo $form->checkBox(
                        $model, 
                        'needDoctor',
                        array('class' => 'inputItem')
                    ); 
                ?>
             </div>
            <?php echo $form->error($model, 'needDoctor'); ?>  
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'recordOnTime'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo $form->checkBox(
                        $model, 
                        'recordOnTime',
                        array('class' => 'inputItem')
                    ); 
                ?>
            </div>
            <?php echo $form->error($model, 'recordOnTime'); ?>  
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    
     <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'provisionalRecord'); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <?php echo $form->checkBox(
                        $model, 
                        'provisionalRecord',
                        array('class' => 'inputItem')
                    ); 
                ?>
             </div>
            <?php echo $form->error($model, 'provisionalRecord'); ?>  
        </div>
        <div class="-stopFloat"></div>
    </div>
    
    
    <div class="tableForm__row">
        <div class="tableForm__leftColumn">
            <div class="tableForm__label">
                <?php echo $form->labelEx($model, 'idGroup', array('label' => 'Группа') ); ?>
            </div>
        </div>
        <div class="tableForm__rightColumn">
            <div class="tableForm__input">
                <span class="selectWrapper">
                    <?php require '_groupSelect.php'; ?>
                </span>
             </div>
            <?php echo $form->error($model, 'idGroup'); ?>  
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