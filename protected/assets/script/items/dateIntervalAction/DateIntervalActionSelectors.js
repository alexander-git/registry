var DateIntervalActionSelectors = function(containerId) {

    this.DATE_INTERVAL_ACTION_FULL_SELECTOR = '#' + containerId;
       

    this.DATE_BEGIN_FULL_SELECTOR = this.DATE_INTERVAL_ACTION_FULL_SELECTOR + ' .dateIntervalAction__dateBegin';
    this.DATE_END_FULL_SELECTOR = this.DATE_INTERVAL_ACTION_FULL_SELECTOR + ' .dateIntervalAction__dateEnd';
    this.PERFORM_BUTTON_FULL_SELECTOR = this.DATE_INTERVAL_ACTION_FULL_SELECTOR + ' .dateIntervalAction__performButton'; 
    this.PROCESS_FULL_SELECTOR = this.DATE_INTERVAL_ACTION_FULL_SELECTOR  + ' .dateIntervalAction__process';
    this.INPUT_ERROR_FULL_SELECTOR = this.DATE_INTERVAL_ACTION_FULL_SELECTOR + ' .dateIntervalAction__inputError';
    this.SUCCESS_MESSAGE_FULL_SELECTOR = this.DATE_INTERVAL_ACTION_FULL_SELECTOR + ' .dateIntervalAction__successMessage';
    this.ERROR_MESSAGE = this.DATE_INTERVAL_ACTION_FULL_SELECTOR  + ' .dateIntervalAction__errorMessage';
   
};
