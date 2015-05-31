var Render = (function() {
    
    // У элемента заданного селектором должна быть определена ширина(css width),
    // либо свойство display должно быть со значение inline-block.
    // Функцию нужно вызывать при каждом изменении размера окна - $(window).resize().
    // Использование выглядит так :
    // 
    //  $(window).resize(function(){ 
    //     palceInCenterOfWindow('#id');   
    //  }); 
    //  
    //  $(document).ready(function() {
    //      $(window).resize();
    //      // Если свойство display - inline-block, то элемент должен быть 
    //      // скрыт до полного построения DOM, иначе он будет дёргаться по мере отображения документа.
    //      $('#id').css('visibility', 'visible'); 
    //      // Либо если display - none и задана абсолютная ширина.
    //      $('#id').show();
    //  });
    
    function palceInCenterOfWindow(selector) { 
       $(selector).css({ 
                position: 'absolute', 
                left: ($(document).width() - $(selector).outerWidth())/2, 
                top: ($(document).height() - $(selector).outerHeight())/2 
            }
        );
    }

    return {
        'palceInCenterOfWindow' : palceInCenterOfWindow
    };
	
})();