<?php
    /* @var $this LoginController */

    $this->pageTitle = Yii::app()->name.' - Войти';
    
    $this->renderPartial('//include/_Render');

    // Опубликуем css и js файлы так, чтобы они находились в одной папке.
    $assetsDir = dirname(__FILE__).'/assets';
    $assetDirRealPath = Yii::app()->assetManager->publish($assetsDir, false, -1, false);
    Yii::app()->clientScript->registerCssFile($assetDirRealPath.'/login.css');
    Yii::app()->clientScript->registerScriptFile($assetDirRealPath.'/login.js');
?>

<div id="loginForm">
    <div class="loginHeader -azure -roundedCornersTop">
        Авторизация
        <br /><img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/key.png" style="width : 130px; margin-top : 8px;">
    </div>
    <div class="login -blue -blue--hrefDecoration -roundedCornersBottom">
        <div class="loginForm loginForm--usingInputItem">
            <?php echo CHtml::beginForm($this->createUrl('login/login') ); ?>

                <div class="loginForm__row">
                    <div class="loginForm__label">
                        <?php echo CHtml::activeLabel($model, 'name', array('label' => 'Имя') ); ?>
                    </div>
                    <?php echo CHtml::activeTextField($model, 'name', array('class'=>'inputItem', 'autocomplete' => 'off') ); ?>
                    <?php if ($model->hasErrors('name') ) : ?>
                        <div class="-errorMessage -marginTop10">
                            <?php echo Chtml::error($model, 'name') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="loginForm__row">
                    <div class="loginForm__label">
                        <?php echo CHtml::activeLabel($model, 'password', array('label' => 'Пароль') ); ?>
                    </div>
                    <?php echo CHtml::activePasswordField($model, 'password', array('class'=>'inputItem', 'autocomplete' => 'off') ); ?>
                    <?php if ($model->hasErrors('password') ) : ?>
                        <div class="-errorMessage -marginTop10">
                            <?php echo Chtml::error($model, 'password') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($isNeedShowCaptcha) : ?>
                    <div class="loginForm__row">
                        <div class="loginForm__label">
                            <?php echo CHtml::activeLabel($model, 'captchaCode', array('label' => 'Введите код с картинки') ); ?>
                        </div>
                        <?php echo CHtml::activeTextField($model, 'captchaCode', array('class'=>'inputItem', 'autocomplete' => 'off' ) ); ?>
                        <?php if ($model->hasErrors('captchaCode') ) : ?>
                            <div class="-errorMessage -marginTop10">
                                <?php echo Chtml::error($model, 'captchaCode') ?>
                            </div>
                        <?php endif; ?>

                        <div class="-marginTop15" style="">
                            <?php 
                                $this->widget(
                                    'CCaptcha', 
                                    array(
                                        'captchaAction' => 'captcha',
                                        'buttonLabel' => '<br />[другой код]',
                                        'imageOptions' => array(
                                            'class' => '-roundedCorners'
                                            
                                        ),
                                    )
                                ); 
                            ?>
                        </div> 
                    </div>
                <?php else : ?>
                    <br />
                <?php endif; ?>
                
                <div class="loginForm__row">
                    <?php echo CHtml::submitButton('Войти', array('class'=>'inputItem -darkAzure -darkAzure--action') ); ?>
                </div>    

            <?php echo CHtml::endForm(); ?>
        </div>
    </div>
</div>