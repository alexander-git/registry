<?php
/* @var $this OrderController */
/* @var $model Order */

$this->pageTitle = 'Обновить заявку';
$this->additionalLayout = 'adminOrder';

require_once '_defineMainMenu.php';
require_once '_defineOrderMenu.php';

$this->renderPartial('//include/_tableForm');

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Обновить заявку
</div>
<div class= "mainBlock -roundedCornersBottom -blue">     
    <?php 
        $this->renderPartial(
            '_formCreateUpdate', 
            array(
                'model'=>$model,
                'submitButtonText' => 'Обновить'
            ) 
        ); 
    ?>
</div>