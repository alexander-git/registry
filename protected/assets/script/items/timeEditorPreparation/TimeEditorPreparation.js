var TimeEditorPreparation = function(id) {
      
    var ID = id;
    var Sel = new TimeEditorPreparationSelectors(ID);    // Селекторы и css-классы
    
    var _timeEditor = null;
       
    init();
       
    function init() {
        _timeEditor = new TimeEditor(ID);
        var initialTime = readInitialTime();
        _timeEditor.prepare(initialTime);
    }
       
    // Регистрация событий 
    ////////////////////////////////////////////////////////////////////////////
    $(Sel.PERFORM_BUTTON_FULL_SELECTOR).click(function() {
        createInputsForRequest();
        return true;
    });

    // Вспомогательные функции
    ////////////////////////////////////////////////////////////////////////////
    function readInitialTime() {
        var initialTime = [];
        var t = $(Sel.INITIAL_TIME_ITEMS_FULL_SELECTOR);
        for (var i = 0; i < t.length; i++) {
            var timeTextView = $(t[i]).find(Sel.INITIAL_TIME_TEXT_VIEW_SELECTOR).text();
            var state = $(t[i]).find(Sel.INITIAL_TIME_STATE_SELECTOR).text();
            initialTime.push({
                'timeTextView' : timeTextView, 
                'state' : state
            });
        }
        return initialTime;
    }

    function createInputsForRequest() {
        var inputsContainer = $(Sel.TIME_ITEMS_CONVERTED_TO_INPUTS_FULL_SELECTOR); 
        inputsContainer.html(''); // Очистка предыдущх элементов
        var time = _timeEditor.getTimeTextViews();
        var timeStates = _timeEditor.getTimeStates();
        for (var i = 0; i < time.length; i++) {     
            var tmplData = {
                'time' : time[i],
                'timeState' : timeStates[i]
            };
            $(Sel.TIME_ITEM_AS_INPUT_TEMPLATE_FULL_SELECTOR).tmpl(tmplData).appendTo(inputsContainer);
        }
    }
    
};

