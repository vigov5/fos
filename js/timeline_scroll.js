$(function(){
    var timeline_scrolled = false; 
    $window = $(window);
    $window.scroll(function() { 
        if (timeline_scrolled === false 
            && $window.scrollTop() + 100 >= ($(document).height() - ($window.height()))) 
        {
            timeline_scrolled = true;
            var loading_image = new HtmlElement('loading', {id: 'timeline'});
            loading_image.appendTo('#content');            
        }
    });
});