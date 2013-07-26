socket_io_port = 8080;

function SocketClient(channel) {
    var host = window.location.host.split(':')[0];
    var socket = io.connect('http://' + host, {port : socket_io_port});

    socket.on('connect', function() {
        socket.emit('subscribe', channel);
    });

    socket.on('stream', function(msg){
        addNewStream($.parseJSON(msg));
    });

    socket.on('disconnect', function() {
    });
}

function addNewStream(data){
    var stream_html = new HtmlElement('stream', data);
    stream_html.prependTo('#stream');
    stream_html.showMe();
}
