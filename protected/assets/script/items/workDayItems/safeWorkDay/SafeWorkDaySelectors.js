var SafeWorkDaySelectors = function(id) {
  
    this.SAFE_WORK_DAY_FULL_SELECTOR = '#' + id; 
    
    this.PROCESS_FULL_SELECTOR = this.SAFE_WORK_DAY_FULL_SELECTOR + ' .safeWorkDay__process';
    this.INFO_MESSAGE_FULL_SELECTOR = this.SAFE_WORK_DAY_FULL_SELECTOR + ' .safeWorkDay__infoMessage';
    this.ERROR_MESSAGE_FULL_SELECTOR = this.SAFE_WORK_DAY_FULL_SELECTOR + ' .safeWorkDay__errorMessage';
    
    this.GENERAL_INFO_FULL_SELECTOR = this.SAFE_WORK_DAY_FULL_SELECTOR + ' .safeWorkDay__generalInfo';
    this.DATE_FULL_SELECTOR = this.GENERAL_INFO_FULL_SELECTOR + ' .safeWorkDay__date';
    this.SPECIALIZARTION_NAME_FULL_SELECTOR = this.GENERAL_INFO_FULL_SELECTOR + ' .safeWorkDay__specializationName'; 
    
    this.DOCTOR_INFO_FULL_SELECTOR = this.GENERAL_INFO_FULL_SELECTOR + ' .safeWorkDay__doctorInfo';
    this.DOCTOR_NAME_FULL_SELECTOR = this.DOCTOR_INFO_FULL_SELECTOR + ' .safeWorkDay__doctorName';
    this.PUBLISHED_INFO_FULL_SELECTOR = this.GENERAL_INFO_FULL_SELECTOR + ' .safeWorkDay__publishedInfo';
    this.PUBLISHED_FULL_SELECTOR = this.PUBLISHED_INFO_FULL_SELECTOR + ' .safeWorkDay__published';
    
    this.DAY_IS_NOT_EXISTS_MESSAGE_FULL_SELECTOR = this.SAFE_WORK_DAY_FULL_SELECTOR + ' .safeWorkDay__dayIsNotExistsMessage';
    
    this.NEXT_BUTTON_FULL_SELECTOR = this.SAFE_WORK_DAY_FULL_SELECTOR + ' .safeWorkDay__nextButton';
    this.PREVIOUS_BUTTON_FULL_SELECTOR = this.SAFE_WORK_DAY_FULL_SELECTOR + ' .safeWorkDay__previousButton';
    this.QUIT_BUTTON_FULL_SELECTOR = this.SAFE_WORK_DAY_FULL_SELECTOR  + ' .safeWorkDay__quitButton';
    
};