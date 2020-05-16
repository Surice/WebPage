window.onload = function() {
    if(location.hash != "home"){
        window.location.hash = "home";
    }
}



//idk what this doing. paste ist only by stack overflow
//using jQuery
/*
(function($){
    $('.anchor-scrolls').on('click', function(evt){
       evt.preventDefault(); //prevents hash from being append to the url
    });
 )(window.jQuery);
*/