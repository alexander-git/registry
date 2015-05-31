var TimeEditorSelectors = function(containerId) {
    
    this.CONTAINER_FULL_SELECTOR = '#' + containerId; 
    
    this.TIME_ITEM_TEMPLATE_FULL_SELECTOR = this.CONTAINER_FULL_SELECTOR + ' .timeEditor__timeItemTemplate';
    
    this.INPUT_PANEL_FULL_SELECTOR = this.CONTAINER_FULL_SELECTOR + ' .timeEditor__inputPanel';
    this.INTERVAL_BEGIN_FULL_SELECTOR = this.INPUT_PANEL_FULL_SELECTOR + ' .timeEditor__intervalBegin';
    this.INTERVAL_END_FULL_SELECTOR = this.INPUT_PANEL_FULL_SELECTOR + ' .timeEditor__intervalEnd';
    this.INTERVAL_DURATION_FULL_SELECTOR = this.INPUT_PANEL_FULL_SELECTOR + ' .timeEditor__intervalDuration';
    this.ADD_INTERVAL_BUTTON_FULL_SELECTOR = this.INPUT_PANEL_FULL_SELECTOR + ' .timeEditor__addIntervalButton';
    this.SINGLE_TIME_FULL_SELECTOR = this.INPUT_PANEL_FULL_SELECTOR + ' .timeEditor__singleTime';
    this.ADD_SINGLE_TIME_BUTTON_FULL_SELECTOR = this.INPUT_PANEL_FULL_SELECTOR + ' .timeEditor__addSingleTimeButton';
    this.INPUT_ERROR_MESSAGE_FULL_SELECTOR = this.INPUT_PANEL_FULL_SELECTOR + ' .timeEditor__inputErrorMessage';
 
    this.TIME_PANEL_FULL_SELECTOR = this.CONTAINER_FULL_SELECTOR + ' .timeEditor__timePanel';
    this.TIME_FULL_SELECTOR = this.TIME_PANEL_FULL_SELECTOR + ' .timeEditor__time';
    this.TIME_ITEM_FULL_SELECTOR = this.TIME_FULL_SELECTOR + ' .timeEditor__timeItem'; 
    this.TIME_INSTRUMENTS_FULL_SELECTOR = this.TIME_PANEL_FULL_SELECTOR + ' .timeEditor__timeInstruments';
    
    this.TIME_ITEM_FREE_CLASS = '-timeEditor--timeFree';
    this.TIME_ITEM_BUSY_CLASS = '-timeEditor--timeBusy';
    this.TIME_ITEM_RECORD_IMPOSSIBLE_CLASS = '-timeEditor--recordImpossible';
    
    this.TIME_INSTRUMENTS_BUTTON_FULL_SELECTOR = this.TIME_INSTRUMENTS_FULL_SELECTOR + ' span';
    this.NORMAL_MODE_BUTTON_FULL_SELECTOR = this.TIME_INSTRUMENTS_FULL_SELECTOR + ' .timeEditor__normalModeButton';
    this.FREE_BUTTON_FULL_SELECTOR = this.TIME_INSTRUMENTS_FULL_SELECTOR + ' .timeEditor__freeButton';
    this.BUSY_BUTTON_FULL_SELECTOR = this.TIME_INSTRUMENTS_FULL_SELECTOR + ' .timeEditor__busyButton';
    this.RECORD_IMPOSSIBLE_BUTTON_FULL_SELECTOR = this.TIME_INSTRUMENTS_FULL_SELECTOR + ' .timeEditor__recordImpossibleButton';
    this.DELETE_BUTTON_FULL_SELECTOR = this.TIME_INSTRUMENTS_FULL_SELECTOR + ' .timeEditor__deleteButton';
    
    this.TIME_INSTRUMENTS_ACTIVE_BUTTON_CLASS = '-active';
    this.TIME_INSTRUMNETS_ACTIVE_BUTTON_FULL_SELECTOR = this.TIME_INSTRUMENTS_BUTTON_FULL_SELECTOR + '.' + this.TIME_INSTRUMENTS_ACTIVE_BUTTON_CLASS;

};
