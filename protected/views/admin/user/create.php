<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle = 'Создать пользователя';
$this->additionalLayout = 'adminUser';

require_once '_defineMainMenu.php';
require_once '_defineUserMenu.php';
$this->makeMenuItemActiveOnUrl($this->userMenu, 'create'); 

$this->renderPartial('//include/_tableForm');

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Создать пользователя
</div>
<div class= "mainBlock -roundedCornersBottom -blue">     
    <?php 
        $this->renderPartial(
            '_formCreateUpdate', 
            array(
                'model' => $model,
                'submitButtonText' => 'Создать',
                'showPasswordAsText' => false,
            ) 
        ); 
    ?>
</div>
