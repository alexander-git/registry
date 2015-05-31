<?php

require_once '_defineMainMenu.php';
$this->additionalLayout = 'adminOneColumn';

$this->pageTitle = 'Расписание специализации';

$this->renderPartial('//include/_schedule');

$getScheduleUrl = $this->createUrl(
        'admin/schedule/getSpecialization', 
        array('idSpecialization' => $idSpecialization)
);
$this->renderPartial('_baseRegisterJs', array('getScheduleUrl' => $getScheduleUrl) );  

?>   
<div class="mainBlockHeader -roundedCornersTop -pear">
   Расписание специализации
</div>
<?php
    $this->renderPartial('_base', array('dates' => $dates, 'model' => $model, 'workDays' => $workDays) ); 