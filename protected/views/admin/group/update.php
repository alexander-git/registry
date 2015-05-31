<?php
/* @var $this GroupController */
/* @var $model Group */

$this->pageTitle = 'Редактировать группу';
$this->additionalLayout = 'adminGroup';
require_once '_defineMainMenu.php';
require_once '_defineGroupMenu.php';

$this->renderPartial('//include/_tableForm');

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Редактировать группу
</div>
<div class= "mainBlock -roundedCornersBottom -blue">     
    <?php 
        $this->renderPartial(
            '_formCreateUpdate', 
            array(
                'model' => $model,
                'submitButtonText' => 'Обновить'
            ) 
        ); 
    ?>
</div>
