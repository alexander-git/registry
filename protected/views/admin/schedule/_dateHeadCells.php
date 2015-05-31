<?php
Yii::import('application.helpers.DateFormatHelper');
?>
<?php for ($i = 0; $i < count($dates); $i++) : ?>
    <th class="scheduleTable__dateHead <?php echo 'scheduleTable__dateHeadCell_'.$i;?>">
        <?php echo DateFormatHelper::getDateScheduleHeadCellTextView($dates[$i]); ?>
    </th>
<?php endfor; 
