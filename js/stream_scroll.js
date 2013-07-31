var stream_scrolled = false;
var end_text = '<div class="end_activity alert content-item"><b>No more!</b></div>';
$(function(){
   $stream = $('#stream');
   $stream.scroll(function() { 
       if (stream_scrolled === false 
           && $stream.scrollTop() + 100 >= ($(document).height() - ($stream.height()))) 
       {            
           stream_scrolled = true;
           var loading_image = new HtmlElement('loading', {id: 'stream'});
           loading_image.appendTo('#stream');
           load_stream(stream_id_global, loading_image);
       }       
   });
});

function load_stream(stream_id, loading_image){
    var url = window.location.protocol + '//' + window.location.host + window.location.pathname + '?r=activity/loadStream';
    $.ajax({        
        type: 'POST',
        url: url,
        data: {
            stream_id: stream_id,
        },
        success: function(msg){
            var obj = $.parseJSON(msg);
            if (obj.length > 0) {
                $.each(obj, function(index, value){
                    addStream($.parseJSON(value).data);
                });
                var last_stream_id = $.parseJSON(obj[obj.length-1]).data.id;
                stream_id_global = last_stream_id;
            }
            $('#loading_stream').remove();
            stream_scrolled = false;
            if (obj.length < 10) {
                stream_scrolled = true;
                $('#stream').append(end_text);
            }
            
        }
    });
}

function addStream(data){
    var stream_html = new HtmlElement('stream', data);
    stream_html.appendTo('#stream');
    stream_html.showMe();
}