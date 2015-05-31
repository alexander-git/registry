var WorkDaySelectors = function(id) {
  
    this.WORK_DAY_FULL_SELECTOR = '#' + id; 
    
    this.PROCESS_FULL_SELECTOR = this.WORK_DAY_FULL_SELECTOR + ' .workDay__process';
    this.INFO_MESSAGE_FULL_SELECTOR = this.WORK_DAY_FULL_SELECTOR + ' .workDay__infoMessage';
    this.ERROR_MESSAGE_FULL_SELECTOR = this.WORK_DAY_FULL_SELECTOR + ' .workDay__errorMessage';
    
    this.GENERAL_INFO_FULL_SELECTOR = this.WORK_DAY_FULL_SELECTOR + ' .workDay__generalInfo';
    this.DATE_FULL_SELECTOR = this.GENERAL_INFO_FULL_SELECTOR + ' .workDay__date';
    this.SPECIALIZARTION_NAME_FULL_SELECTOR = this.GENERAL_INFO_FULL_SELECTOR + ' .workDay__specializationName'; 
    this.DOCTOR_INFO_FULL_SELECTOR = this.GENERAL_INFO_FULL_SELECTOR + ' .workDay__doctorInfo';
    this.DOCTOR_NAME_FULL_SELECTOR = this.DOCTOR_INFO_FULL_SELECTOR + ' .workDay__doctorName';
   
    this.PUBLISHED_FULL_SELECTOR = this.WORK_DAY_FULL_SELECTOR + ' .workDay__published';
    
    this.DAY_IS_NOT_EXISTS_MESSAGE_FULL_SELECTOR = this.WORK_DAY_FULL_SELECTOR + ' .workDay__dayIsNotExistsMessage';
    
    this.NEXT_BUTTON_FULL_SELECTOR = this.WORK_DAY_FULL_SELECTOR + ' .workDay__nextButton';
    this.PREVIOUS_BUTTON_FULL_SELECTOR = this.WORK_DAY_FULL_SELECTOR + ' .workDay__previousButton';
    this.PERFORM_BUTTON_FULL_SELECTOR = this.WORK_DAY_FULL_SELECTOR + ' .workDay__performButton';
    this.QUIT_BUTTON_FULL_SELECTOR = this.WORK_DAY_FULL_SELECTOR  + ' .workDay__quitButton';
    
};