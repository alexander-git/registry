var TimeEditor = function(containerId) {
      
    var DURATION_OF_SHOW_INPUT_ERROR_MESSAGE = 5 * 1000;
    var TIME_PANEL_FADE_IN_TIME = 600;
    
    var Sel = new TimeEditorSelectors(containerId);    // Селекторы и css-классы
 
    // Режимы работы
    //////////////////////////////////////////////////////////////////////////// 
    var NORMAL_MODE = 'normalMode';
    var TIME_FREE_MODE = 'timeFreeTimeMode';
    var TIME_BUSY_MODE = 'timeBusyMode';
    var TIME_RECORD_IMPOSSIBLE_MODE = 'timeRecordImpossibleMode';
    var TIME_DELETE_MODE = 'timeDeleteMode'; 
    
    // Внутренние переменные
    //////////////////////////////////////////////////////////////////////////// 
    var _mode = NORMAL_MODE;
    var _time = null;
    var _isNeedCompletelyHideInputErrorMessage = false;
    var _modifyTimeFunctions = null;
    
    // Работа с внутренними переменными
    ////////////////////////////////////////////////////////////////////////////
    this.setNeedCompletleyHideInputErrorMessage = function(value) {
        _isNeedCompletelyHideInputErrorMessage = value;
    };
    
    this.setModifyTimeFunctions = function(value) {
        _modifyTimeFunctions = value;
    };
    
    function isNeedCompletelyHideErrorMessage() {
        return _isNeedCompletelyHideInputErrorMessage;
    }
    
    function isSetModifyTimeFunctions() {
        return _modifyTimeFunctions !== null;
    }

    // Изменение режима работы
    ////////////////////////////////////////////////////////////////////////////
    function goToNormalMode() {
        _mode = NORMAL_MODE;
        deselectButtonsOnTimeInstruments();
        makeButtonActiveOnSelector(Sel.NORMAL_MODE_BUTTON_FULL_SELECTOR);
        prepareCorsurToWorkWithTimeItemsAccordingCurrentMode();
    }
    
    function goToTimeFreeMode() {
        _mode = TIME_FREE_MODE;
        deselectButtonsOnTimeInstruments();
        makeButtonActiveOnSelector(Sel.FREE_BUTTON_FULL_SELECTOR);
        prepareCorsurToWorkWithTimeItemsAccordingCurrentMode();
    }
    
    function goToTimeBusyMode() {
        _mode = TIME_BUSY_MODE;
        deselectButtonsOnTimeInstruments();
        makeButtonActiveOnSelector(Sel.BUSY_BUTTON_FULL_SELECTOR);
        prepareCorsurToWorkWithTimeItemsAccordingCurrentMode();
    }
    
    function goToTimeRecordImpossibleMode() {
        _mode = TIME_RECORD_IMPOSSIBLE_MODE;
        deselectButtonsOnTimeInstruments();
        makeButtonActiveOnSelector(Sel.RECORD_IMPOSSIBLE_BUTTON_FULL_SELECTOR);
        prepareCorsurToWorkWithTimeItemsAccordingCurrentMode();
    }
    
    function goToTimeDeleteMode() {
        _mode = TIME_DELETE_MODE;
        deselectButtonsOnTimeInstruments();
        makeButtonActiveOnSelector(Sel.DELETE_BUTTON_FULL_SELECTOR);
        prepareCorsurToWorkWithTimeItemsAccordingCurrentMode();
    }
    
    // Регистрация событий для элементов диалога
    ////////////////////////////////////////////////////////////////////////////
 
    // Щелчки по кнопкам
    ////////////////////////////////////////////////////////////////////////////
    $(Sel.NORMAL_MODE_BUTTON_FULL_SELECTOR).click(function() {
        goToNormalMode();
    });
   
    $(Sel.FREE_BUTTON_FULL_SELECTOR).click(function() {
        if (checkRepeatedButtonClick(this) ) {
            return;
        }
        goToTimeFreeMode();
    });
    
    $(Sel.BUSY_BUTTON_FULL_SELECTOR).click(function() {
        if (checkRepeatedButtonClick(this) ) {
            return;
        }
        goToTimeBusyMode();
    });
   
    $(Sel.RECORD_IMPOSSIBLE_BUTTON_FULL_SELECTOR).click(function() {
        if (checkRepeatedButtonClick(this) ) {
            return;
        }
        goToTimeRecordImpossibleMode();
    });
   
    $(Sel.DELETE_BUTTON_FULL_SELECTOR).click(function() {
        if (checkRepeatedButtonClick(this) ) {
            return;
        }
        goToTimeDeleteMode();
    });
    
    
    $(Sel.ADD_INTERVAL_BUTTON_FULL_SELECTOR).click(function() {
        var timeBeginTextView = $(Sel.INTERVAL_BEGIN_FULL_SELECTOR).val();
        var timeEndTextView = $(Sel.INTERVAL_END_FULL_SELECTOR).val();
        var durationTextView = $(Sel.INTERVAL_DURATION_FULL_SELECTOR).val();
        
        if ( (!isTimeCorrect(timeBeginTextView) ) || (!isTimeCorrect(timeEndTextView) ) ) {
            showInputErrorMessage(TimeEditorConst.TIME_FORMAT_INPUT_ERROR_MSG);
            return;
        } 
        
        var timeBegin = TimeHelper.getTimeFromTextView(timeBeginTextView);
        var timeEnd = TimeHelper.getTimeFromTextView(timeEndTextView);
        if (timeBegin >= timeEnd) {
            showInputErrorMessage(TimeEditorConst.INTERVAL_BEGIN_GREATHER_INTERVAL_END_MSG);
            return;
        }
        
        if (!isDurationCorrect(durationTextView) ) {
            showInputErrorMessage(TimeEditorConst.DURATION_FORMAT_ERROR_MSG);
            return;
        }
        
        var duration = TimeHelper.getDurationFromTextView(durationTextView);
        var intervalLength = timeEnd - timeBegin;
        if (duration > intervalLength) {
            showInputErrorMessage(TimeEditorConst.DURATION_GREATHER_INTERVAL_LENGTH);
            return;
        }
        
        addInterval(timeBeginTextView, timeEndTextView, durationTextView);
    });
    
    $(Sel.ADD_SINGLE_TIME_BUTTON_FULL_SELECTOR).click(function() {
        var singleTimeTextView = $(Sel.SINGLE_TIME_FULL_SELECTOR).val();
        if (!isTimeCorrect(singleTimeTextView) ) {
            showInputErrorMessage(TimeEditorConst.TIME_FORMAT_INPUT_ERROR_MSG);
            return;
        } 
        addSingleTime(singleTimeTextView);
    });
      
    // Щелчок по timeItem 
    $(Sel.TIME_ITEM_FULL_SELECTOR).live('click', function() {
        var useDefaultModifyMethod = !isSetModifyTimeFunctions();
        var timeTextView = $(this).text();
        if (useDefaultModifyMethod) {
             // Стандартный способ - не требуется никаких дополнительных действий.
            if (_mode === TIME_FREE_MODE) {
                makeTimeFree(timeTextView);
            } else if (_mode === TIME_BUSY_MODE) {
                makeTimeBusy(timeTextView);
            } else if (_mode === TIME_RECORD_IMPOSSIBLE_MODE) {
                makeTimeRecordImpossible(timeTextView);
            } else if (_mode === TIME_DELETE_MODE) {
                deleteTime(timeTextView);
            }
        } else {
            modifyTimeUsingModifyTimeFunctions(timeTextView);
        }
    });
    
    function makeTimeFree(timeTextView) {
        _time.makeTimeFree(timeTextView);
        repaintTimePanel();
    }
    
    function makeTimeBusy(timeTextView) {
        _time.makeTimeBusy(timeTextView);
        repaintTimePanel();
    }
    
    function makeTimeRecordImpossible(timeTextView) {
        _time.makeTimeRecordImpossible(timeTextView);
        repaintTimePanel();
    }
    
    function deleteTime(timeTextView) {
        _time.deleteTime(timeTextView);
        repaintTimePanel();
    }
    
    function modifyTimeUsingModifyTimeFunctions(timeTextView) {
        if (_mode === TIME_FREE_MODE) {
            _modifyTimeFunctions.makeFree(timeTextView, function() {
                makeTimeFree(timeTextView);
            });
        } else if (_mode === TIME_BUSY_MODE) {
            _modifyTimeFunctions.makeBusy(timeTextView, function() {
                makeTimeBusy(timeTextView);
            });
        } else if (_mode === TIME_RECORD_IMPOSSIBLE_MODE) {
            _modifyTimeFunctions.makeRecordImpossible(timeTextView, function() {
                makeTimeRecordImpossible(timeTextView);
            }); 
        } else if (_mode === TIME_DELETE_MODE) {
            _modifyTimeFunctions.delete(timeTextView, function() {
                deleteTime(timeTextView);
            });
        }
    }
         
    function addInterval(timeBeginTextView, timeEndTextView, durationTextView) {
        _time.addInterval(timeBeginTextView, timeEndTextView, durationTextView);   
       repaintTimePanel();
    }
    
    function addSingleTime(singleTimeTextView) {
        _time.addTime(singleTimeTextView, TimeItemState.FREE);
        repaintTimePanel();
    }
    
    function showInputErrorMessage(message) {
        var error = $(Sel.INPUT_ERROR_MESSAGE_FULL_SELECTOR);
        error.text(message);
        error.removeClass('-hidden');
        if (isNeedCompletelyHideErrorMessage() ) {
            error.show();
        } 
        hideInputErrorMessage();
    }

    function hideInputErrorMessage() {
        var error = $(Sel.INPUT_ERROR_MESSAGE_FULL_SELECTOR);
        setTimeout(
            function() {
                error.addClass('-hidden'); 
                error.text('hidden');
                 if (isNeedCompletelyHideErrorMessage() ) {
                    error.hide();
                 } 
            } , 
            DURATION_OF_SHOW_INPUT_ERROR_MESSAGE
        );       
    }
    
    function isTimeCorrect(time) {
        if (!(/^[0-9]{2}:[0-9]{2}$/.test(time) ) ) {
            return false;
        }  
        var hours = parseInt(time.substring(0, 2) );
        var minutes = parseInt(time.substring(3) );
              
        if (hours < 0 || hours > 23) {
            return false;
        }
        if (minutes < 0 || minutes > 59) {
            return false;
        }
        
        return true;
    }
    
    function isDurationCorrect(duration) {
        if (!(/^[0-9]+$/).test(duration) ) {
            return false;
        }
        
        var minutes = parseInt(duration);
        if (minutes < 1 || minutes >= (24 * 60) ) {
            return false;
        }
        
        return true;
    }
    
    // Вспомогательные функции
    ////////////////////////////////////////////////////////////////////////////
    function deselectButtonsOnTimeInstruments() {
        $(Sel.TIME_INSTRUMNETS_ACTIVE_BUTTON_FULL_SELECTOR).removeClass(Sel.TIME_INSTRUMENTS_ACTIVE_BUTTON_CLASS);
    }
    
    function checkRepeatedButtonClick(button) {
        if ($(button).hasClass(Sel.TIME_INSTRUMENTS_ACTIVE_BUTTON_CLASS) ) {
            goToNormalMode();
            return true;
        } else {
            return false;
        }
    }    
        
    function makeButtonActiveOnSelector(selector) {
        $(selector).addClass(Sel.TIME_INSTRUMENTS_ACTIVE_BUTTON_CLASS);
    }
   
    function repaintTimePanel() {
        var isPanelHasTimeItemsBeforeUpdate = ($(Sel.TIME_ITEM_FULL_SELECTOR).length !== 0);
        updateTimeItemsView();            
        
         // Если нет ни одного timeItem то скрываем панель управления временем
        if ($(Sel.TIME_ITEM_FULL_SELECTOR).length === 0) {
            $(Sel.TIME_PANEL_FULL_SELECTOR).hide();
        } else {
            if (!isPanelHasTimeItemsBeforeUpdate) {
                goToNormalMode();
            }
            if (!$(Sel.TIME_PANEL_FULL_SELECTOR).is(':visible') ) {
                $(Sel.TIME_PANEL_FULL_SELECTOR).fadeIn(TIME_PANEL_FADE_IN_TIME);
            }
        }
    }
    
    function updateTimeItemsView() {
        //Временное хранилище созданных элементов 
        var tempContainer = $('<div></div>');
        // Удаляем все элементы timItem из контейнера
        $(Sel.TIME_ITEM_FULL_SELECTOR).remove();
        
        // И в соответсвии с моделью отображаем заново
        var timeItems = _time.getTimeItems();
        for (var i in timeItems) {
            var t = timeItems[i];
            var c = getTimeItemClassOnTimeItemState(t.state);
            
            var tmplData = {
                'time' : t.timeTextView
            };
            
            $(Sel.TIME_ITEM_TEMPLATE_FULL_SELECTOR).tmpl(tmplData).addClass(c).
                appendTo(tempContainer);
        }
       $(tempContainer.html()).prependTo(Sel.TIME_FULL_SELECTOR);
       
       prepareCorsurToWorkWithTimeItemsAccordingCurrentMode();
    }
    
    function inputPanelToDefatultState() {
        $(Sel.INTERVAL_BEGIN_FULL_SELECTOR).val('00:00');
        $(Sel.INTERVAL_END_FULL_SELECTOR).val('00:00');
        $(Sel.INTERVAL_DURATION_FULL_SELECTOR).val('0');
        $(Sel.SINGLE_TIME_FULL_SELECTOR).val('00:00');
    }

    function getTimeItemClassOnTimeItemState(timeItemState) {
        if (timeItemState === TimeItemState.FREE) {
            return Sel.TIME_ITEM_FREE_CLASS;
        } else if (timeItemState === TimeItemState.BUSY) {
            return Sel.TIME_ITEM_BUSY_CLASS;
        } else if (timeItemState === TimeItemState.RECORD_IMPOSSIBLE) {
            return Sel.TIME_ITEM_RECORD_IMPOSSIBLE_CLASS;
        }
     }
     
      // time - массив объектов {timeTextView, state } 
    function setTimeOnTimeTextViewStateArray(time) {
        _time = new Time();
        for (var i in time) {
            _time.addTime(time[i].timeTextView, time[i].state);
        }
    }
    
    // Изменение курсора
    ////////////////////////////////////////////////////////////////////////////
    function prepareCorsurToWorkWithTimeItemsAccordingCurrentMode() {
        switch(_mode) {
            case NORMAL_MODE :
                 $(Sel.TIME_ITEM_FULL_SELECTOR).css('cursor', 'auto');
                 break;
            case TIME_FREE_MODE :
            case TIME_BUSY_MODE :
            case TIME_RECORD_IMPOSSIBLE_MODE :
            case TIME_DELETE_MODE :
                $(Sel.TIME_ITEM_FULL_SELECTOR).css('cursor', 'pointer');
                break;
        }
    }
    
    this.prepare = function(initialTime) {
        _time = new Time();
        if (initialTime !== undefined) {
            setTimeOnTimeTextViewStateArray(initialTime);
        }
        
        goToNormalMode();
        inputPanelToDefatultState();
        repaintTimePanel();
    };   
    
    this.getTimeTextViews = function() {
        var timeItems = _time.getTimeItems();
        var time = [];
        for (var i in timeItems) {
            time.push(timeItems[i].timeTextView);
        }
        return time;
    };
    
    this.getTimeStates =  function() {
        var timeItems = _time.getTimeItems();
        var timeStates = [];
        for (var i in timeItems) {
            timeStates.push(timeItems[i].state);
        }
        return timeStates;
    }; 
};
