<?php
/* @var $this SpecializationController */
/* @var $model Specialization */

$this->pageTitle = 'Создать специализациию';
$this->additionalLayout = 'adminSpecialization';

require_once '_defineMainMenu.php';
require_once '_defineSpecializationMenu.php';
$this->makeMenuItemActiveOnUrl($this->specializationMenu, 'create'); 

$this->renderPartial('//include/_tableForm');

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Создать специализациию
</div>
<div class= "mainBlock -roundedCornersBottom -blue">     
    <?php 
        $this->renderPartial(
            '_formCreateUpdate', 
            array(
                'model' => $model,
                'submitButtonText' => 'Создать'
            ) 
        ); 
    ?>
</div>
