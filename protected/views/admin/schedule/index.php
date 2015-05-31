<?php

require_once '_defineMainMenu.php';
require_once '_defineScheduleMenu.php';
$this->makeMenuItemActiveOnUrl($this->scheduleMenu, 'index');

$this->additionalLayout = 'adminSchedule';

$this->pageTitle = 'Выбрать расписание';

$this->renderPartial('//include/_search');


$searchGroupId = 'searchGroup';
$searchSpecializationId = 'searchSpecialization';
$searchDoctorId = 'searchDoctor';

$searchGroupUrl = $this->createUrl('/admin/search/groupSchedules'); 
$searchSpecializationUrl = $this->createUrl('/admin/search/specializationSchedules');
$searchDoctorUrl = $this->createUrl('/admin/search/doctorSchedules');
        
Yii::app()->clientScript->registerScript(
   'indexSchedule',
    "
    $(document).ready(function() {        
        var searchGroup = new Search('$searchGroupId', '$searchGroupUrl', 'search', SearchViewMode.NORMAL);
        var searchSpecialization = new Search('$searchSpecializationId', '$searchSpecializationUrl', 'search', SearchViewMode.NORMAL);
        var searchDoctor = new Search('$searchDoctorId', '$searchDoctorUrl', 'search', SearchViewMode.NORMAL);
    });
    ",
   CClientScript::POS_HEAD
); 

?>

<div class="mainBlockHeader -roundedCornersTop -pear">
   Выбрать расписание
</div>
<div class= "mainBlock -roundedCornersBottom -blue -blue--hrefDecoration">
    <div class="managePanel -roundedCorners -padding15">
        <h3><?php echo CHtml::link('Общее расписание', array('admin/schedule/common') ); ?></h3>
        
        <div class="-marginTop50"><h3>Расписание для группы</h3></div>
        <div class="-marginTop20" id="<?php echo $searchGroupId; ?>">
            <?php $this->renderPartial('_searchContent', array('showAllButtonText' => 'Показать все') ); ?>
        </div>
        
        <div class="-marginTop50"><h3>Расписание для специализации</h3></div>
        <div class="-marginTop20" id="<?php echo $searchSpecializationId ?>">
            <?php $this->renderPartial('_searchContent', array('showAllButtonText' => 'Показать все') ); ?>
        </div>
        
        <div class="-marginTop50"><h3>Расписание для врача</h3></div>
        <div class="-marginTop20" id="<?php echo $searchDoctorId ?>">
            <?php $this->renderPartial('_searchContent', array('showAllButtonText' => 'Показать все') ); ?>
        </div>
        
    </div>
</div>