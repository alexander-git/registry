<?php Yii::import('helpers.FlashMessageHelper'); ?> 
<?php if (FlashMessageHelper::hasSuccessMessage() ) : ?>
    <div class="successFlashMessage -centerTextH -marginLeft10 -marginRight10 -marginBottom15">
        <?php echo FlashMessageHelper::getSuccessMessage(); ?>
    </div>
<?php endif; 