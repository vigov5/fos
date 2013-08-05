socket_io_port = 8090;

function SocketClient(channel) {
    var host = window.location.host.split(':')[0];
    var socket = io.connect('http://' + host, {port : socket_io_port});

    socket.on('connect', function() {
        socket.emit('subscribe', channel);
    });

    socket.on('data', function(msg){
        var packet = $.parseJSON(msg);
        if (packet.msg_type == 'stream') {
            addNewStream(packet.data);
            if (packet.data.comment_content !== null) {
                addNewComment(packet.data);
            }
        } else if (packet.msg_type == 'notification') {
            sessionStorage.setItem('is_new_notify', 'true');
            addNewNotification(packet.data);
        } else if (packet.msg_type == 'update') {
            sessionStorage.setItem('is_new_notify', 'true');
        }
    });

    socket.on('disconnect', function() {
    });
}

function addNewStream(data){
    var stream_html = new HtmlElement('stream', data);
    stream_html.prependTo('#stream');
    stream_html.showMe();
    show_bubble(true);
}

function addNotificationBadge(notification_num){
    var txt = $(".notification-menu").children().children().html();
    txt += ' <span class="notify_num badge badge-important">' + notification_num + '</span>';
    $(".notification-menu").children().children().html(txt);
}

function addNewNotification(data){
    notify_num++;
    if ($('.notify_num').length) {
        $('.notify_num').fadeOut(250, function(){
            $('.notify_num').html(notify_num);
            $('.notify_num').fadeIn(250);
        });
    } else if (notify_num !== 0){
        addNotificationBadge(notify_num);
    }
    if (notify_num != 0) {
        var title = document.title;
        if (notify_num === 1) {
            title = "(" + notify_num + ") " + title;
        } else {
            title = title.slice(title.indexOf(" "));
            title = "(" + notify_num + ") " + title;
        }
        document.title = title;
    }
}
