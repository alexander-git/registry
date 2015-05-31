<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle = 'Редактировать пользователя';
$this->additionalLayout = 'adminUser';

require_once '_defineMainMenu.php';
require_once '_defineUserMenu.php';

$this->renderPartial('//include/_tableForm');

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Редактировать пользователя
</div>
<div class= "mainBlock -roundedCornersBottom -blue">     
    <?php 
        $this->renderPartial(
            '_formCreateUpdate', 
            array(
                'model' => $model,
                'submitButtonText' => 'Обновить',
                'showPasswordAsText' => true
            ) 
        ); 
    ?>
</div>
