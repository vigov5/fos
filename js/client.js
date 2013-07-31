socket_io_port = 8080;

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
        } else if (packet.msg_type == 'notification') {
            sessionStorage.setItem('is_new_notify', 'true');
            addNewNotification(packet.data);
        }
    });

    socket.on('disconnect', function() {
    });
}

function addNewStream(data){
    var stream_html = new HtmlElement('stream', data);
    stream_html.prependTo('#stream');
    stream_html.showMe();
}

function addNewNotification(data){
    notify_num++;
    if (notify_num > 1) {
        $('.notify_num').fadeOut(250, function(){
            $('.notify_num').html(notify_num);
            $('.notify_num').fadeIn(250);
        });
    } else if (notify_num === 1) {
        var txt = $(".notification-menu").children().children().html();
        txt += ' <span class="notify_num badge badge-important"></span>'
        $(".notification-menu").children().children().html(txt);
    }
}
