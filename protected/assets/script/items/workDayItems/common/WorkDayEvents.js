var WorkDayEvents = (function() {
    
    return {
        'WORK_DAY_CREATE' : 'workDayCreate',
        'WORK_DAY_UPDATE' : 'workDayUpdate',
        'WORK_DAY_DELETE' : 'workDayDelete',
        'WORK_DAY_RECEIVED' : 'workDayReceived', // Событие генерируется когда 
                                                 // WorkDay или SafeWorkDay успешно получает 
                                                 // информацию о загруженном дне. 
        'WORK_DAY_IS_NOT_EXISTS' : 'workDayIsNotExists'
    };
    
})();