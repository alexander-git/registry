<?php
/* @var $this DoctorController */
/* @var $model Doctor */

$this->pageTitle = 'Редактировать врача';
$this->additionalLayout = 'adminDoctor';
require_once '_defineMainMenu.php';
require_once '_defineDoctorMenu.php';

$this->renderPartial('//include/_tableForm');

?>
<div class="mainBlockHeader -roundedCornersTop -pear">
    Редактировать врача
</div>
<div class= "mainBlock -roundedCornersBottom -blue">     
    <?php 
        $this->renderPartial(
            '_formCreateUpdate', 
            array(
                'model' => $model,
                'submitButtonText' => 'Обновить',
                'isNeedShowSpecializationsFromModel' => true
            ) 
        ); 
    ?>
</div>
