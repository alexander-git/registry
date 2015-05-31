<?php
/* @var $this RecordController */

$this->pageTitle=Yii::app()->name;

$currentDateTimeContainerId = 'currentDateTimeContainer';

$this->renderPartial('_recordAppJsVars');

$this->renderPartial('//include/_recordApp');
$this->renderPartial(
    '_currentDateTimeScript', 
    array(
        'currentDateTime' => $currentDateTime,
        'currentDateTimeContainerId' =>  $currentDateTimeContainerId
    ) 
);

?>
<?php ?>
<?php if (!Yii::app()->user->isGuest ) : ?>
    <div class="userPanel -azure -marginTop10 -roundedCorners">
        <div class="userPanel__logout">
            <?php echo CHtml::link('Выйти('.Yii::app()->user->name.')', array('/login/logout') ); ?>
        </div>
        <div class="userPanel__admin">
            <?php echo CHtml::link('Управление' , array('admin/general/main') ); ?>
        </div>
        <div class="-stopFloat"></div>
    </div>
    <div class="-stopFloat"></div>
<?php endif; ?>        
<div class="header -azure -marginTop20 -roundedCorners">
    <div class="header__caption">
        <?php echo CHtml::link('Электронная регистратура' , array('visitor/record/index') ); ?>
    </div>
    <div class="header__currentDateTime" id="<?php echo $currentDateTimeContainerId; ?>"></div>
    <div class="-stopFloat"></div>
</div>
 <?php
    // При щелчке на ссылке в пределах angular-приложения 
    // вызываются события $routeChangeStart и $routeChangeSuccess, а также 
    // срабатывают правила для маршрутов определённых при настройке
    // $routeProvider. Нам не нужно, чтобы angular что-либо делал при щелчке 
    // по ссылкам созданым с помощью php выше. Даже если ссылка указывают на 
    // начальную страницу angular-приложения и при щелчке по ней переход 
    // осущетвляется как-будто бы внутри angular-приложения, потому  что на 
    // самом деле это не так. Чтобы angular никак не реагировал на щелчки по 
    // ссылкам выше(не генерировались бы события и не срабатывало бы правило
    // otherwise определённое при настройке $routeProvider) разместим 
    // дерективу ng-app здесь, а не в тэгах body или html.
 ?>
<div ng-app="recordApp">
    <div ng-view></div>
</div>
