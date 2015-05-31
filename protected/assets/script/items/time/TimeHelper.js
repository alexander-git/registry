var TimeHelper = (function() {
    
    var MAX_END_TIME = (24 * 60) - 1;
    var MINUTES_IN_HOUR = 60;
    
    function getTimeFromTextView(timeTextView) {
        var hours = parseInt(timeTextView.substring(0, 2) );
        var minutes = parseInt(timeTextView.substring(3) );
        return (hours * MINUTES_IN_HOUR) + minutes;
    }
    
    function getTextViewFromTime(time) {
        var hours = Math.floor(time / MINUTES_IN_HOUR);
        var minutes = time % MINUTES_IN_HOUR;
        
        // Дополним ведущими нулями если это необходимо
        var hoursStr = hours.toString();
        if (Math.floor(hours / 10) === 0)  {
            hoursStr = '0' + hoursStr;
        }
        var minutesStr = minutes.toString();
        if (Math.floor(minutes / 10) === 0)  {
            minutesStr = '0' + minutesStr;
        }
        
        return hoursStr + ':' + minutesStr;
    }

    function getDurationFromTextView(duration) {
        if ( (typeof duration) === 'string') {
            return parseInt(duration);
        } else {
            return duration;
        }
    }
    
    return {
       'getTimeFromTextView' : getTimeFromTextView,
       'getTextViewFromTime' : getTextViewFromTime,
       'getDurationFromTextView' : getDurationFromTextView
    };
     
})();
