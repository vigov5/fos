var timeline_scrolled = false;
var end_activity = '<div class="end_activity alert content-item"><b>No more activities!</b></div>';
$(function(){
    $window = $(window);
    $window.scroll(function() {
        if (timeline_scrolled === false
            && $window.scrollTop() + 100 >= ($(document).height() - ($window.height())))
        {
            timeline_scrolled = true;
            var loading_image = new HtmlElement('loading', {id: 'timeline'});
            loading_image.appendTo('#content');
            load_activity(activity_id_global, loading_image);
        }
    });
});

function load_activity(activity_id, loading_image){
    var url = window.location.protocol + '//' + window.location.host + window.location.pathname + '?r=activity/loadMore';
    $.ajax({        
        type: 'POST',
        url: url,
        data: {
            activity_id: activity_id,
            profile_id: profile_id,
        },
        success: function(msg){
            var obj = $.parseJSON(msg);
            if (obj.length > 0) {
                $.each(obj, function(index, value){
                    addNewActivity($.parseJSON(value).data);
                });
                var last_activity_id = $.parseJSON(obj[obj.length-1]).data.id;
                activity_id_global = last_activity_id;
            }
            $('#loading_timeline').remove();
            timeline_scrolled = false;
            if (obj.length < 10) {
                timeline_scrolled = true;
                $('#activity').append(end_activity);
            }
            
        }
    });
}

function addNewActivity(data){
    var activity_html = new HtmlElement('activity', data);
    activity_html.appendTo('#activity');
    activity_html.showMe();
}