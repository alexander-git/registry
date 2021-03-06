<?php
/* @var $this ScheduleController */

require_once '_defineMainMenu.php';
$this->additionalLayout = 'adminOneColumn';

$this->pageTitle = 'Общее рассписание';

$this->renderPartial('//include/_schedule');

$getScheduleUrl = $this->createUrl('admin/schedule/getCommon');
$this->renderPartial('_baseRegisterJs', array('getScheduleUrl' => $getScheduleUrl) );  

?>   
<div class="mainBlockHeader -roundedCornersTop -pear">
   Общее расписание
</div>
<?php
    $this->renderPartial('_base', array('dates' => $dates, 'model' => $model, 'workDays' => $workDays) ); 


