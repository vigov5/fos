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
