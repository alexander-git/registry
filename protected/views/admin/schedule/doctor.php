<?php

require_once '_defineMainMenu.php';
$this->additionalLayout = 'adminOneColumn';

$this->pageTitle = 'Расписание врача';

$this->renderPartial('//include/_schedule');

$getScheduleUrl = $this->createUrl(
        'admin/schedule/getDoctor', 
        array('idDoctor' => $idDoctor)
);
$this->renderPartial('_baseRegisterJs', array('getScheduleUrl' => $getScheduleUrl) );  

?>   
<div class="mainBlockHeader -roundedCornersTop -pear">
   Расписание врача
</div>
<?php
    $this->renderPartial('_base', array('dates' => $dates, 'model' => $model, 'workDays' => $workDays) ); 