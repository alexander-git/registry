<?php
/* @var $this SpecializationController */
/* @var $model Specialization */

$this->pageTitle = 'Редактировать специализацию';
$this->additionalLayout = 'adminSpecialization';
require_once '_defineMainMenu.php';
require_once '_defineSpecializationMenu.php';

$this->renderPartial('//include/_tableForm');

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Редактировать специализацию
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
