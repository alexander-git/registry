var Time = function(timeBeginTextView, timeEndTextView, durationTextView) {
    
    this._timeItems = initTimeItems(timeBeginTextView, timeEndTextView, durationTextView);
  
    this.isEmpty = function() {
        return (this._timeItems.length  === 0);
    };
  
    this.getTimeItems = function() {
        return this._timeItems;
    };
    
    this.addInterval = function(timeBeginTextView, timeEndTextView, durationTextView) {
        var interval = createInterval(timeBeginTextView, timeEndTextView, durationTextView);
        for (var i in interval) {
            var t = interval[i];
            // Элементы, которые уже существовали не заменяем
            if (this._timeItems[t.time] === undefined) {
                this._timeItems[t.time] = t;
            }
        }
    };
    
    this.addTime = function(timeTextView, state) {
        if (state === undefined) {
           state = TimeItemState.FREE; 
        }
        var time = TimeHelper.getTimeFromTextView(timeTextView);
         // Элементы, которые уже существовали не заменяем
        if (this._timeItems[time] === undefined) {
            this._timeItems[time] = new TimeItem(timeTextView, time, state);
        }
    };
    
    this.makeTimeFree = function(timeTextView) {
        this._setTimeItemState(timeTextView, TimeItemState.FREE);
    };
    
    this.makeTimeBusy = function(timeTextView) {
        this._setTimeItemState(timeTextView, TimeItemState.BUSY);
    };
    
    this.makeTimeRecordImpossible = function(timeTextView) {
        this._setTimeItemState(timeTextView, TimeItemState.RECORD_IMPOSSIBLE);
    };
      
    this.deleteTime = function(timeTextView) {
        var time = TimeHelper.getTimeFromTextView(timeTextView);
        delete this._timeItems[time];
    };
    
    this._setTimeItemState = function(timeTextView, state) {
        var time = TimeHelper.getTimeFromTextView(timeTextView);
        this._timeItems[time].state = state;
    };
    
    function initTimeItems(timeBeginTextView, timeEndTextView, durationTextView) {
        if ((timeBeginTextView === undefined) ||
            (timeEndTextView === undefined) ||
            (durationTextView === undefined) 
           ) 
        {
            return [];
        } else {
            return createInterval(timeBeginTextView, timeEndTextView, durationTextView);
        }
    }
    ////////////////////////////////////////////////////////////////////////////
    
    // Вспомогательные функции
    ////////////////////////////////////////////////////////////////////////////
   
    function createInterval(timeBeginTextView, timeEndTextView, durationTextView) {
        var time = [];
        
        var timeBegin = TimeHelper.getTimeFromTextView(timeBeginTextView);
        var timeEnd = TimeHelper.getTimeFromTextView(timeEndTextView);
        var duration = TimeHelper.getDurationFromTextView(durationTextView);
        var currentTime = timeBegin;
        while(currentTime + duration <= timeEnd) {
            var currentTimeTextView = TimeHelper.getTextViewFromTime(currentTime);
            time[currentTime] = new TimeItem(currentTimeTextView, currentTime, TimeItemState.FREE);
            currentTime += duration;
        }
        
        return time;
    }
     
};