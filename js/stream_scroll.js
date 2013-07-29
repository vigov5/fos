$(function(){
   var stream_scrolled = false;
   $stream = $('#stream');
   $stream.scroll(function() { 
       if (stream_scrolled === false 
           && $stream.scrollTop() + 100 >= ($(document).height() - ($stream.height()))) 
       {            
           stream_scrolled = true;           
           var loading_image = new HtmlElement('loading', {id: 'stream'});
           loading_image.appendTo('#stream');
       }       
   });
});