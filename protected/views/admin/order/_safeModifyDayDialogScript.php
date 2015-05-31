<?php

if (!isset($safeModifyDayDialogId) ) {
    throw new LogicException(); 
}

$this->renderPartial('//include/_safeWorkDay');
$this->renderPartial('//include/_orderInfoStore');

$getWorkDayByIdUrl = $this->createUrl('admin/schedule/getWorkDayById');
$getWorkDayByAttributesUrl = $this->createUrl('admin/schedule/getWorkDayByAttributes');
$updateTimeStateUrl = $this->createUrl('admin/schedule/updateWorkTimeState');
$deleteTimeUrl = $this->createUrl('admin/schedule/deleteWorkTime');
 
Yii::app()->clientScript->registerScript(
   'safeModifyDayDialog',
    "
    $(document).ready(function() {
        
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
        
        // Нужны селеторы отдельно.
        // Хотя они и используются внутри класса OrderInfoStore.
        var orderInfoStoreSelectors = new OrderInfoStoreSelectors();
        
        var orderInfoStore = new OrderInfoStore();

        // Открытие диалога изменения времени в определнном дне расписания.
        $('.-jsSafeModifyDayDialogButton').live('click', function(e) {
            var orderInfoStoreElement = $(this).closest(orderInfoStoreSelectors.ORDER_INFO_STORE_SELECTOR); 

            orderInfoStore.prepare(orderInfoStoreElement);

            var date = orderInfoStore.getDate();
            var idSpecialization = orderInfoStore.getIdSpecialization();
            var idDoctor = orderInfoStore.getIdDoctor();
            var specializationName = orderInfoStore.getSpecializationName();
            var doctorName = orderInfoStore.getDoctorName();

            var workDayInfo = {
                 'date' :  date,
                 'idSpecialization' : idSpecialization,
                 'idDoctor' : idDoctor,
                 'specializationName' : specializationName,
                 'doctorName' : doctorName
            };
            
            var getWorkDayOnAttributes = true;
            safeModifyDayDialog.prepare(workDayInfo, getWorkDayOnAttributes);
        });
    });  
    ",
   CClientScript::POS_HEAD
);  

