<?php

require_once '_defineMainMenu.php';
$this->additionalLayout = 'adminOneColumn';

$this->pageTitle = 'Расписание группы';

$this->renderPartial('//include/_schedule');

$getScheduleUrl = $this->createUrl(
        'admin/schedule/getGroup', 
        array('idGroup' => $idGroup)
);
$this->renderPartial('_baseRegisterJs', array('getScheduleUrl' => $getScheduleUrl) );  

?>   
<div class="mainBlockHeader -roundedCornersTop -pear">
   Расписание группы
</div>
<?php
    $this->renderPartial('_base', array('dates' => $dates, 'model' => $model, 'workDays' => $workDays) ); 