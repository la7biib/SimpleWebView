jQuery(function ($) {
    "use strict";
    
    /*if($(window).width()>=1200)
    $("body").height($(window).height());
   */
    $("body").css('min-height',$(window).height()+'px');
    
    $(".dash-trigger").click(function(e){
        e.preventDefault();
        var p =$(this).parent();
        $(".dash-button").not(p).removeClass("active");
        p.toggleClass("active");
    });
    
    $(".closePop").click(function(e){
        e.preventDefault();
        var p =$(this).parents(".dash-button");
        p.removeClass("active");
    });
    
    $(".triggerMenu").click(function(e){
        e.preventDefault();
        var p =$(this).parent();
        p.toggleClass("active");
    });
    
    
});