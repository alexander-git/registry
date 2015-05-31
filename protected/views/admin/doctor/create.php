<?php
/* @var $this DoctorController */
/* @var $model Doctor */


$this->pageTitle = 'Создать врача';
$this->additionalLayout = 'adminDoctor';

require_once '_defineMainMenu.php';
require_once '_defineDoctorMenu.php';
$this->makeMenuItemActiveOnUrl($this->doctorMenu, 'create'); 

$this->renderPartial('//include/_tableForm');

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Создать врача
</div>
<div class= "mainBlock -roundedCornersBottom -blue">
    <?php 
        $this->renderPartial(
            '_formCreateUpdate', 
            array(
                'model' => $model,
                'submitButtonText' => 'Создать',
                'isNeedShowSpecializationsFromModel' => false
            ) 
        ); 
    ?>
</div>
