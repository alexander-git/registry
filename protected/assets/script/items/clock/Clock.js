
var Clock = function(initialDate, selector) {
    
    var _currentDate = initialDate;
    // Селектор элемента в котором будет отображаться дата и время
    var _clockSelector = selector;
    
    var UPDATE_INTERVALE_IN_MILISECONDS = 1000;

    init();
    
    function init() {
        displayCurrentDate();
        
        setInterval(
            function() { 
                _currentDate = new Date(_currentDate.getTime() + UPDATE_INTERVALE_IN_MILISECONDS);
                displayCurrentDate();
            }, 
            UPDATE_INTERVALE_IN_MILISECONDS
        );
    }
   
    function displayCurrentDate() {
        $(_clockSelector).html(ClockHelper.getDateTimeTextView(_currentDate) );
    }

       
};