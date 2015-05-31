var TimeEditorPreparationSelectors = function(containerId) {
  
    this.TIME_EDITOR_PREPARATON_FULL_SELECTOR = '#' + containerId; 
    

    this.INITIAL_TIME_ITEMS_FULL_SELECTOR =  this.TIME_EDITOR_PREPARATON_FULL_SELECTOR + ' .timeEditorPreparation__initialTimeItem';
    this.INITIAL_TIME_TEXT_VIEW_SELECTOR =  '.timeEditorPreparation__initialTimeTextView';
    this.INITIAL_TIME_STATE_SELECTOR = '.timeEditorPreparation__initialTimeState';

    this.TIME_ITEM_AS_INPUT_TEMPLATE_FULL_SELECTOR = this.TIME_EDITOR_PREPARATON_FULL_SELECTOR + ' .timeEditorPreparation__timeItemAsInputTemplate';
    this.TIME_ITEMS_CONVERTED_TO_INPUTS_FULL_SELECTOR = this.TIME_EDITOR_PREPARATON_FULL_SELECTOR+ ' .timeEditorPreparation__timeItemsConvertedToInputs';
   
    this.PERFORM_BUTTON_FULL_SELECTOR = this.TIME_EDITOR_PREPARATON_FULL_SELECTOR+ ' .timeEditorPreparation__performButton';  
};