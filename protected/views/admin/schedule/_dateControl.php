<?php
    Yii::import('helpers.DateFormatHelper');
?>
<div class="-table" style="width : 100%;">
    <div class="-tableRow">
        <div class="scheduleControlPanel__dateJump -centerTableCellV"> 
            <span>Перейти к : </span>
            <?php 
                $this->widget('CMaskedTextField', 
                    array(
                        'name' => 'date',
                        'mask' => '99-99-9999',
                        'value' => DateFormatHelper::getDateCommonTextView($dates[0]),
                        'htmlOptions' => array(
                            'class' => 'scheduleControlPanel__jumpDateInputField inputItem',
                            'style' => 'margin-right : 5px;',
                            'autocomplete' => 'off',
                            'size' =>  '10',
                        ),                    
                    )
                );
            ?>
            <?php
                echo CHtml::button(
                    'Ok', 
                    array('class' => 'scheduleControlPanel__jumpDateButton inputItem -grayBlue -grayBlue--action')
                );
            ?>
        </div>
        <div class="scheduleControlPanel__dateChanger -centerTableCellV"> 
            <?php 
                echo CHtml::button(
                    'Предыдущие', 
                    array('class' => 'scheduleControlPanel__prevDateButton inputItem -grayBlue -grayBlue--action -centerTableCellV"')
                );
            ?>
            <?php 
                $beginDate = $dates[0];
                $endDate = $dates[count($dates)-1];
                $dateIntervalText = DateFormatHelper::getIntervalOfDatesTextView($beginDate, $endDate);
            ?>
            <span class="scheduleControlPanel__dateInterval -centerTableCellV -centerTextH">
                <?php echo $dateIntervalText; ?>
            </span>
            <?php
             echo CHtml::button(
                    'Следующие', 
                    array('class' => 'scheduleControlPanel__nextDateButton inputItem -grayBlue -grayBlue--action -centerTableCellV"')
                );
            ?>
        </div>
    </div>
</div>
