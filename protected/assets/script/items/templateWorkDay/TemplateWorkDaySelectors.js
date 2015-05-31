var TemplateWorkDaySelectors = function(containerId) {
  
    this.TEMPLATE_WORK_DAY_FULL_SELECTOR = '#' + containerId; 
    
    this.PROCESS_FULL_SELECTOR = this.TEMPLATE_WORK_DAY_FULL_SELECTOR + ' .templateWorkDay__process';
    this.INFO_MESSAGE_FULL_SELECTOR = this.TEMPLATE_WORK_DAY_FULL_SELECTOR + ' .templateWorkDay__infoMessage';
    this.ERROR_MESSAGE_FULL_SELECTOR = this.TEMPLATE_WORK_DAY_FULL_SELECTOR + ' .templateWorkDay__errorMessage';
    this.TEMPLATE_IS_NOT_EXISTS_MESSAGE_FULL_SELECTOR = this.TEMPLATE_WORK_DAY_FULL_SELECTOR + ' .templateWorkDay__templateIsNotExistsMessage';
    
    this.GENERAL_INFO_FULL_SELECTOR = this.TEMPLATE_WORK_DAY_FULL_SELECTOR + ' .templateWorkDay__generalInfo';
    this.TEMPLATE_NAME_FULL_SELECTOR = this.GENERAL_INFO_FULL_SELECTOR + ' .templateWorkDay__templateName'; 
    
    this.QUIT_BUTTON_FULL_SELECTOR = this.TEMPLATE_WORK_DAY_FULL_SELECTOR  + ' .templateWorkDay__quitButton';
    
};