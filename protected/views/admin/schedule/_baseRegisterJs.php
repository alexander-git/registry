<?php

if (!isset($getScheduleUrl) ) {
    throw new LogicException();
}

$modifyDayDialogId = 'modifyDayDialog';
$safeModifyDayDialogId = 'safeModifyDayDialog';
$selectTemplateWorkDayDialogId = 'selectTemplateWorkDayDialog';
$viewTemplateWorkDayDialogId = 'viewTemplateWorkDayDialog';

// url для Schedule
$deleteWorkDaysUrl = $this->createUrl('admin/schedule/deleteWorkDays');
$updatePublisedInWorkDaysUrl = $this->createUrl('admin/schedule/updatePublishedInWorkDays');
$acceptTemplateWorkDayUrl = $this->createUrl('/admin/schedule/acceptTemplateWorkDay'); 

// Общие url для WorkDay и SafeWorkDay.
$getWorkDayByIdUrl = $this->createUrl('admin/schedule/getWorkDayById');
$getWorkDayByAttributesUrl = $this->createUrl('admin/schedule/getWorkDayByAttributes');
// url для WorkDay.
$createWorkDayUrl = $this->createUrl('admin/schedule/createWorkDay');
$updateWorkDayUrl = $this->createUrl('admin/schedule/updateWorkDay');
//url для SafeWorkDay.
$updateTimeStateUrl = $this->createUrl('admin/schedule/updateWorkTimeState');
$deleteTimeUrl = $this->createUrl('admin/schedule/deleteWorkTime');

$searchTemplateWorkDayUrl = $this->createUrl('/admin/search/templateWorkDaySelect');

$getTemplateWorkDayUrl = $this->createUrl('admin/schedule/getTemplateWorkDay');

Yii::app()->clientScript->registerScript(
   'schedule',
    "
    $(document).ready(function() {        
        
        var scheduleUrls = {
            'getSchedule' : '$getScheduleUrl',
            'deleteWorkDays' : '$deleteWorkDaysUrl',
            'updatePublishedInWorkDays' : '$updatePublisedInWorkDaysUrl',
            'acceptTemplateWorkDay' : '$acceptTemplateWorkDayUrl'
        };
        var schedule = new Schedule(scheduleUrls);
            
        var modifyDayDialogUrls = {
            'getWorkDayById' : '$getWorkDayByIdUrl',
            'getWorkDayByAttributes' : '$getWorkDayByAttributesUrl',
            'createWorkDay' : '$createWorkDayUrl',
            'updateWorkDay' : '$updateWorkDayUrl',
        };
        modifyDayDialog = new WorkDay(
            '$modifyDayDialogId', 
            modifyDayDialogUrls, 
            WorkDayViewMode.DIALOG
        );  
        schedule.setModifyDayDialog(modifyDayDialog);
        
        var safeWorkDayUrls = {
            'getWorkDayById' : '$getWorkDayByIdUrl',
            'getWorkDayByAttributes' : '$getWorkDayByAttributesUrl',
            'updateTimeState' : '$updateTimeStateUrl',
            'deleteTime' : '$deleteTimeUrl'
        };
        var safeModifyDayDialog = new SafeWorkDay(
            '$safeModifyDayDialogId', 
            safeWorkDayUrls, 
            SafeWorkDayViewMode.DIALOG
        );    
        schedule.setSafeModifyDayDialog(safeModifyDayDialog);
        
        var selectTemplateWorkDayDialog = new Search(
            '$selectTemplateWorkDayDialogId', 
            '$searchTemplateWorkDayUrl',
            'search',
            SearchViewMode.DIALOG
        );         
        schedule.setSelectTemplateWorkDayDialog(selectTemplateWorkDayDialog);
        

        var templateWorkDayUrls = {
            'getTemplateWorkDay' : '$getTemplateWorkDayUrl'
        };
        var viewTemplateWorkDayDialog = new TemplateWorkDay(
            '$viewTemplateWorkDayDialogId',
            templateWorkDayUrls,
            TemplateWorkDayViewMode.DIALOG
        ); 
        schedule.setViewTemplateWorkDayDialog(viewTemplateWorkDayDialog);
    });
    ",
   CClientScript::POS_HEAD
); 
