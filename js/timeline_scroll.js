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
            setTime($('.human-time'));
        }
    });
}

function addNewActivity(data){
    var activity_html = new HtmlElement('activity', data);
    activity_html.appendTo('#activity');
    activity_html.showMe();
}

function getDate(datetime){
    return datetime.getDate() + '/' + (parseInt(datetime.getMonth()) + 1) + '/' + datetime.getFullYear();
}

function setTime(all_span) {
    var now = new Date().getTime();
    now = parseInt(now/1000);
    all_span.each(function(){
        var dateStr = $(this).attr('created_at');
        var datesplit = dateStr.split(' ');
        var date = datesplit[0].split('-');
        var time = datesplit[1].split(':');
        var datetime = new Date(date[0], (date[1] - 1), date[2], time[0], time[1], time[2]);
        var timestamp = parseInt(datetime.getTime()/1000);
        var seconds = now - timestamp;
        switch (true) {
            case (seconds < 10):
                var html = ' about a few seconds ago';
                $(this).html(html);
                $(this).attr('changed', 1);
                break;
            case (seconds < 60 * 2):
                var html = 'about one minute ago';
                $(this).html(html);
                $(this).attr('changed', 1);
                break;
            case (seconds < 60 * 50):
                var html = 'about ' + parseInt(seconds / 60) + ' minutes ago';
                $(this).html(html);
                $(this).attr('changed', 2);
                break;
            case (seconds < 60 * 60 * 2):
                var html = 'about one hour ago';
                $(this).html(html);
                $(this).attr('changed', 2);
                break;
            case (seconds < 60 * 60 * 24):
                var html = 'about ' + parseInt(seconds / (60 * 60)) + ' hours ago';
                $(this).html(html);
                $(this).attr('changed', 3);
                break;
            default:
                var html = ' at ' + getDate(datetime);
                $(this).html(html);
                $(this).attr('changed', 0);
                break;
        }
    });
}

$(function(){
    var ONE_SECOND = 1000;
    var ONE_MINUTE = 60 * ONE_SECOND;
    var ONE_HOUR = 60 * ONE_MINUTE;
    setTime($('.human-time'));
    var interval1 = setInterval(function(){
        setTime($('span[changed="1"]'));
    }, ONE_SECOND);
    var interval1 = setInterval(function(){
        setTime($('span[changed="2"]'));
    }, ONE_MINUTE);
    var interval1 = setInterval(function(){
        setTime($('span[changed="3"]'));
    }, ONE_HOUR);
});