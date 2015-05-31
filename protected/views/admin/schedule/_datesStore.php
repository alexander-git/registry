<?php Yii::import('helpers.DateFormatHelper'); ?>
<div class="scheduleDatesStore -notVisible">
    <?php for($i = 0; $i < count($dates); ++$i) : ?>
        <?php $class = "scheduleDatesStore__date_$i"; ?>
        <span class= "scheduleDatesStore__item">
            <span class="scheduleDatesStore__dateNumber"><?php echo $i; ?></span>
            <span class="<?php echo $class; ?>"><?php echo DateFormatHelper::getDateCommonTextView($dates[$i]); ?></span>
        </span>
    <?php endfor; ?>
</div>