<?php
/* @var $this OrderController */
/* @var $model Order */

$this->pageTitle = 'Создать заявку';
$this->additionalLayout = 'adminOrder';

require_once '_defineMainMenu.php';
require_once '_defineOrderMenu.php';
$this->makeMenuItemActiveOnUrl($this->orderMenu, 'create'); 

$this->renderPartial('//include/_tableForm');

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Создать заявку
</div>
<div class= "mainBlock -roundedCornersBottom -blue">     
    <?php 
        $this->renderPartial(
            '_formCreateUpdate', 
            array(
                'model'=>$model,
                'submitButtonText' => 'Создать'
            ) 
        ); 
    ?>
</div>
