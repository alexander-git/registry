var ScheduleSelectors = function() {
    
    this.LOADING_PROCESS_FULL_SELECTOR = '.scheduleLoadingProcess';
    this.ERROR_MESSAGE_FULL_SELECTOR = '.scheduleErrorMessage';
    
    this.DATES_STORE_FULL_SELECTOR = '.scheduleDatesStore'
    this.DATES_STORE_ITEM_FULL_SELECTOR = this.DATES_STORE_FULL_SELECTOR + ' .scheduleDatesStore__item';
    this.DATES_STORE_DATE_NUMBER_FULL_SELECTOR = this.DATES_STORE_ITEM_FULL_SELECTOR + ' .scheduleDatesStore__dateNumber';
    this.DATES_STORE_DATE_FULL_SELECTOR_PREFIX = this.DATES_STORE_ITEM_FULL_SELECTOR + ' .scheduleDatesStore__date_';
    this.INITIAL_DATE_FULL_SELECTOR = this.DATES_STORE_DATE_FULL_SELECTOR_PREFIX + '0';
    this.DATES_STORE_DATE_NUMBER_SELECTOR = '.scheduleDatesStore__dateNumber';
    this.DATES_STORE_DATE_SELECTOR_PREFIX = '.scheduleDatesStore__date_';
    
    this.CONTROL_PANEL_FULL_SELECTOR = '.scheduleControlPanel';
    this.DATE_CHANGER_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__dateChanger';
    this.DATE_INTERVAL_FULL_SELECTOR = this.DATE_CHANGER_FULL_SELECTOR + ' .scheduleControlPanel__dateInterval';
    this.NEXT_DATE_BUTTON_FULL_SELECTOR = this.DATE_CHANGER_FULL_SELECTOR + ' .scheduleControlPanel__nextDateButton';
    this.PREV_DATE_BUTTON_FULL_SELECTOR = this.DATE_CHANGER_FULL_SELECTOR + ' .scheduleControlPanel__prevDateButton';
    
    
    this.DATE_JUMP_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__dateJump';
    this.JUMP_DATE_INPUT_FIELD_FULL_SELECTOR = this.DATE_JUMP_FULL_SELECTOR + ' .scheduleControlPanel__jumpDateInputField';
    this.JUMP_DATE_BUTTON_FULL_SELECTOR = this.DATE_JUMP_FULL_SELECTOR + ' .scheduleControlPanel__jumpDateButton';
   
    this.INSTRUMENTS_ACTIVE_BUTTON_CLASS = '-active';
    this.INSTRUMENTS_ACTIVE_BUTTON_SELECTOR = '.' + this.INSTRUMENTS_ACTIVE_BUTTON_CLASS;
   
    this.NORMAL_MODE_BUTTON_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__normalModeButton';
    this.CELL_SELECT_DESELECT_BUTTON_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__cellSelectDeselectButton';
    this.AREA_SELECT_BUTTON_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__areaSelectButton';
    this.AREA_DESELECT_BUTTON_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__areaDeselectButton';
    this.COMPLETELY_DESELECT_BUTTON_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__completelyDeselectButton';
    this.SAFE_UPDATE_DAY_BUTTON_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__safeUpdateDayButton';
    this.CREATE_UPDATE_DAY_BUTTON_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__createUpdateDayButton';
    this.DELETE_DAY_BUTTON_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__deleteDayButton';
    this.PUBLISH_DEPUBLISH_DAY_BUTTON_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__publishDepublishDayButton';   
    this.DELETE_SELECTED_BUTTON_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__deleteSelectedButton';
    this.PUBLISH_SELECTED_BUTTON_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__publishSelectedButton';
    this.DEPUBLISH_SELECTED_BUTTON_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__depublishSelectedButton';
    this.ACCEPT_TEMPLATE_WORK_DAY_TO_SELECTED_BUTTON_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__acceptTemplateWorkDayToSelectedButton';
    this.VIEW_TEMPLATE_WORK_DAY_BUTTON_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__viewTemplateWorkDayButton';
    this.SELECT_TEMPLATE_WORK_DAY_INPUT_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__selectTemplateWorkDayInput';
    this.SELECT_TEMPLATE_WORK_DAY_BUTTON_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__selectTemplateWorkDayButton';
    this.CLEAR_TEMPLATE_WORK_DAY_BUTTON_FULL_SELECTOR = this.CONTROL_PANEL_FULL_SELECTOR + ' .scheduleControlPanel__clearTemplateWorkDayButton';
    
   
    this.SCHEDULE_TABLE_FULL_SELECTOR = '.scheduleTable';
    
    this.DATE_HEAD_CELLS_FULL_SELECTOR_PREFIX = this.SCHEDULE_TABLE_FULL_SELECTOR + ' .scheduleTable__dateHeadCell_';
    
    this.SELECTABLE_CELL_FULL_SELECTOR = this.SCHEDULE_TABLE_FULL_SELECTOR + ' .sheduleTable__selectableCell';
    this.SELECTABLE_CELL_SELECTED_CLASS = 'sheduleTable__selectableCell--selected';
    this.SELECTED_CELL_FULL_SELECTOR = this.SCHEDULE_TABLE_FULL_SELECTOR + ' .' + this.SELECTABLE_CELL_SELECTED_CLASS;
    
    this.CELL_STATE_VIEW_SELECTOR = '.scheduleTable__cellStateView';
    this.CELL_POSITION_FULL_SELECTOR_PREFIX = this.SCHEDULE_TABLE_FULL_SELECTOR + ' .scheduleTable__cellPosition_';
    
    this.CELL_INFO_STORE_SELECTOR = '.scheduleTable__cellInfoStore';
    this.ROW_STORE_CLASS = 'scheduleTable__rowStore';
    this.COL_STORE_CLASS = 'scheduleTable__colStore';
    this.ROW_STORE_SELECTOR = '.' + this.ROW_STORE_CLASS;
    this.COL_STORE_SELECTOR = '.' + this.COL_STORE_CLASS;
    this.STATE_STORE_SELECTOR = '.scheduleTable__stateStore';
    this.ID_WORK_DAY_STORE_SELECTOR = '.scheduleTable__idWorkDayStore';
    this.DATE_NUMBER_STORE_SELECTOR = '.scheduleTable__dateNumberStore';
    
    this.ROW_INFO_STORE_SELECTOR = '.scheduleTable__rowInfoStore';
    this.ID_SPECIALIZATION_STORE_SELECTOR = '.scheduleTable__idSpecializationStore';
    this.SPECIALIZATION_NAME_SELECTOR = '.scheduleTable__specializationNameStore';
    this.ID_DOCTOR_STORE_SELECTOR = '.scheduleTable__idDoctorStore';
    this.DOCTOR_NAME_STORE_SELECTOR = '.scheduleTable__doctorNameStore';
};