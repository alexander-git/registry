$(window).resize(function(){ 
    Render.palceInCenterOfWindow('#loginForm');
 }); 

$(document).ready(function() {
     $(window).resize();
     $('#loginForm').css('visibility', 'visible');
});

$(window).load(function() {
    // Когда будут загружены все изображения снова отцентрируем форму.
    $(window).resize();
});