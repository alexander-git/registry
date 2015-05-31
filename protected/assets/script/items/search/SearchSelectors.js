var SearchSelectors = function(containerId) {

    this.SEARCH_FULL_SELECTOR = '#' + containerId;
    
    this.RESULT_PANEL_FULL_SELECTOR = this.SEARCH_FULL_SELECTOR  + ' .search__resultPanel';
    this.RESULT_FULL_SELECTOR =  this.RESULT_PANEL_FULL_SELECTOR + ' .search__result';
    
    this.INPUT_PANEL_FULL_SELECTOR = this.SEARCH_FULL_SELECTOR   + ' .search__inputPanel';
    this.TEXT_TO_SEARCH_FULL_SELECTOR = this.INPUT_PANEL_FULL_SELECTOR + ' .search__textToSearch';
    this.SEARCH_BUTTON_FULL_SELECTOR = this.INPUT_PANEL_FULL_SELECTOR + ' .search__searchButton';
    this.SHOW_ALL_BUTTON_FULL_SELECTOR = this.INPUT_PANEL_FULL_SELECTOR + ' .search__showAllButton';
    this.PROCESS_FULL_SELECTOR = this.SEARCH_FULL_SELECTOR  + ' .search__process';
    this.NOTHIN_IS_FOUND_FULL_SELECTOR = this.SEARCH_FULL_SELECTOR  + ' .search__nothingIsFound';
    this.ERROR_MESSAGE = this.SEARCH_FULL_SELECTOR  + ' .search__errorMessage';
   
    this.SELECT_BUTTON_FULL_SELECTOR = this.SEARCH_FULL_SELECTOR  + ' .search__selectButton';
    this.QUIT_BUTTON_FULL_SELECTOR = this.SEARCH_FULL_SELECTOR  + ' .search__quitButton';
};
