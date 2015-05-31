<?php

require_once '_defineMainMenu.php';
require_once '_defineScheduleMenu.php';
$this->makeMenuItemActiveOnUrl($this->scheduleMenu, 'manage');

$this->additionalLayout = 'adminSchedule';

$this->pageTitle = 'Управление рассписание';


$this->renderPartial('//include/_search');
$this->renderPartial('//include/_dateIntervalAction');


$searchGroupId = 'searchGroup';
$searchSpecializationId = 'searchSpecialization';
$searchDoctorId = 'searchDoctor';

$searchGroupUrl = $this->createUrl('/admin/search/groupSelect'); 
$searchSpecializationUrl = $this->createUrl('/admin/search/specializationSelect');
$searchDoctorUrl = $this->createUrl('/admin/search/doctorSelect');

$deleteCommonScheduleId = 'deleteCommonSchedule';
$deleteGroupScheduleId = 'deleteGroupSchedule';
$deleteSpecializationScheduleId = 'deleteSpecializationSchedule';
$deletDoctorScheduleId = 'deleteDoctorSchedule';

$deleteScheduleCommonUrl = $this->createUrl('/admin/schedule/deleteForCommon');
$deleteScheduleGroupUrl = $this->createUrl('/admin/schedule/deleteForGroup');
$deleteScheduleSpecializationUrl = $this->createUrl('/admin/schedule/deleteForSpecializaton');
$deleteScheduleDoctorUrl = $this->createUrl('/admin/schedule/deleteForDoctor');

Yii::app()->clientScript->registerScript(
   'manageSchedule',
    "
    $(document).ready(function() {    
        var searchGroup = new Search('$searchGroupId', '$searchGroupUrl', 'search', SearchViewMode.NORMAL);
        var searchSpecialization = new Search('$searchSpecializationId', '$searchSpecializationUrl', 'search', SearchViewMode.NORMAL);
        var searchDoctor = new Search('$searchDoctorId', '$searchDoctorUrl', 'search', SearchViewMode.NORMAL);

        var deleteScheduleCommonAction = new DateIntervalAction('$deleteCommonScheduleId', '$deleteScheduleCommonUrl');    
        
        var deleteScheduleGroupAction = new DateIntervalAction('$deleteGroupScheduleId', '$deleteScheduleGroupUrl');
        deleteScheduleGroupAction.setPrepareAdditionalDataBeforeRequestFunction(function() {
            var additionalData = null;
            var idGroup = searchGroup.getSelectedValue();
            if (idGroup !== null) {
                additionalData = {};
                additionalData['idGroup'] = idGroup;
            }
            return additionalData;
        });
        deleteScheduleGroupAction.setIsRequiredAdditionalDataBeforeRequest(true);

        var deleteScheduleSpecializationAction = new DateIntervalAction('$deleteSpecializationScheduleId', '$deleteScheduleSpecializationUrl');
        deleteScheduleSpecializationAction.setPrepareAdditionalDataBeforeRequestFunction(function() {
            var additionalData = null;
            var idSpecialization = searchSpecialization.getSelectedValue();
            if (idSpecialization !== null) {
                additionalData = {};
                additionalData['idSpecialization'] = idSpecialization;
            }
            return additionalData;
        });
        deleteScheduleSpecializationAction.setIsRequiredAdditionalDataBeforeRequest(true);
        

        var deleteScheduleDoctorAction = new DateIntervalAction('$deletDoctorScheduleId', '$deleteScheduleDoctorUrl');
        deleteScheduleDoctorAction.setPrepareAdditionalDataBeforeRequestFunction(function() {
            var additionalData = null;
            var idDoctor = searchDoctor.getSelectedValue();
            if (idDoctor  !== null) {
                additionalData = {};
                additionalData['idDoctor'] = idDoctor;
            }
            return additionalData;
        });
        deleteScheduleDoctorAction.setIsRequiredAdditionalDataBeforeRequest(true);
    });
    ",
   CClientScript::POS_HEAD
); 

?>

<div class="mainBlockHeader -roundedCornersTop -pear">
   Управление расписанием
</div>
<div class= "mainBlock -roundedCornersBottom -blue -blue--hrefDecoration">
    <div class="managePanel -roundedCorners -padding15">
        <h3>Удалить из всего расписания</h3>
        <div id="<?php echo $deleteCommonScheduleId; ?>">
           <?php $this->renderPartial('_deleteScheduleItems',  array('dateInputNameSuffix' => 'common')); ?> 
        </div>
        
        <div class="-marginTop70"><h3>Удалить расписание для группы</h3></div>
        <div class="-marginTop20" id="<?php echo $searchGroupId; ?>">
            <?php $this->renderPartial('_searchContentWithSelectResult', array('showAllButtonText' => 'Показать все') ); ?>
        </div>
        <div id="<?php echo $deleteGroupScheduleId; ?>">
            <?php $this->renderPartial('_deleteScheduleItems', array('dateInputNameSuffix' =>'group') ); ?>
        </div>
        
        <div class="-marginTop70"><h3>Удалить расписание для специализации</h3></div>
        <div class="-marginTop20" id="<?php echo $searchSpecializationId ?>">
            <?php $this->renderPartial('_searchContentWithSelectResult', array('showAllButtonText' => 'Показать все') ); ?>
        </div>
        <div id="<?php echo $deleteSpecializationScheduleId; ?>">
            <?php $this->renderPartial('_deleteScheduleItems', array('dateInputNameSuffix' => 'specialization') );?>
        </div>
        
        
        <div class="-marginTop70"><h3>Удалить расписание для врача</h3></div>
        <div class="-marginTop20" id="<?php echo $searchDoctorId ?>">
            <?php $this->renderPartial('_searchContentWithSelectResult', array('showAllButtonText' => 'Показать всех') ); ?>
        </div>
        <div id="<?php echo $deletDoctorScheduleId ?>">
            <?php $this->renderPartial('_deleteScheduleItems',  array('dateInputNameSuffix' => 'doctor') ); ?>
        </div>
        
    </div>
</div>