<div class="dateIntervalAction -marginTop20">
    <div class="-floatLeft">
        <div class="inputItemsRow inputItemsRow--defaultLayout -defaultInputItemsFont">
       
            <span style="margin-right : 5px;">
                Дата с
            </span>
            <?php 
                $this->widget('CMaskedTextField', 
                    array(
                        'name' => "dateBegin$dateInputNameSuffix", // $dateInputNameSuffix нужен только для того чтобы поле правильно отображалось.
                        'mask' => '99-99-9999',
                        'htmlOptions' => array(
                            'class' => 'dateIntervalAction__dateBegin inputItem',
                            'autocomplete' => 'off',
                            'size' =>  '10',
                        ),                    
                    )
                );
            ?>
            <span style="margin-right : 5px;">
                по
            </span>
            <?php 
                $this->widget('CMaskedTextField', 
                    array(
                        'name' => "dateEnd$dateInputNameSuffix",
                        'mask' => '99-99-9999',
                        'htmlOptions' => array(
                            'class' => 'dateIntervalAction__dateEnd inputItem',
                            'autocomplete' => 'off',
                            'size' =>  '10',
                        ),                    
                    )
                );
            ?>

            <?php 
                 echo CHtml::button(
                     'Удалить', 
                     array(
                         'class' => 'dateIntervalAction__performButton inputItem -darkAzure -darkAzure--action', 
                     ) 
                 ); 
             ?>
        </div>
        <div class="dateIntervalAction__process -centerTextH -marginTop10 -notVisible">
            <!--TODO# вынести в общее -->
            <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/loadingLine.gif"/>
        </div>
        <div class="dateIntervalAction__errorMessage -errorMessage -centerTextH -marginTop10 -notVisible">
            Произошла ошибка
        </div>
        <div class="dateIntervalAction__successMessage -centerTextH -marginTop10 -notVisible">
            Удаление успешно
        </div>
    </div>
    <div class="-stopFloat"></div>
    <div class="dateIntervalAction__inputError -errorMessage  -marginTop10 -notVisible" style="width : 470px;">
    </div>
</div>
