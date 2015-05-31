
var ClockHelper = (function() {
    
    var monthNamesWithEndings = [
        "января", 
        "февраля",
        "марта",
        "апреля",
        "мая",
        "июня", 
        "июля", 
        "августа", 
        "сентября", 
        "октября", 
        "ноября", 
        "декабря"
    ];
    
    var dayNames = [
        'Воскресенье',
        'Понедельник',
        'Вторник',
        'Среда',
        'Четверг',
        'Пятница',
        'Суббота'
    ];
    
    function getDateTimeTextView(date) { 
        
        var year = date.getFullYear(); 
        var monthNumber = date.getMonth();
        var day = date.getDate();
        var dayOfWeekNumber = date.getDay();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seconds = date.getSeconds();
        
        if (hours <= 9) {
            hours = "0" + hours;
        }
        if (minutes <= 9) { 
            minutes = "0" + minutes;
        }
        if (seconds <= 9) {
            seconds = "0" + seconds;
        }
        
        var result = 
            dayNames[dayOfWeekNumber] + ", " +
            day + " " +  monthNamesWithEndings[monthNumber] + " " + year + " г. " +
            hours + ":" + minutes + ":" + seconds;
        return result;
    }
    
    return {
        'getDateTimeTextView' : getDateTimeTextView
    };
        
})();