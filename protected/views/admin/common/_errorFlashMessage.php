<?php Yii::import('helpers.FlashMessageHelper'); ?> 
<?php if (FlashMessageHelper::hasErrorMessage() ) : ?>
    <div class="errorFlashMessage -errorMessage -centerTextH -marginLeft10 -marginRight10 -marginBottom15">
        <?php echo FlashMessageHelper::getErrorMessage(); ?>
    </div>
<?php endif; 