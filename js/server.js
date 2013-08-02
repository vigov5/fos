socket_io_port = 8090;

var io = require('socket.io').listen(socket_io_port);
var redis = require('redis');

io.configure(function() {
    io.set('close timeout', 60 * 60 * 24);
});

function RedisConnection(redis_channel, type) {
    this.redis_conn = redis.createClient();
    this.redis_channel = redis_channel;
}

RedisConnection.prototype.subscribe = function(socket) {
    this.redis_conn.subscribe(this.redis_channel);
    this.redis_conn.on('message', function(channel, message) {
        console.log(message);
        socket.emit('data', message);
    });
};

RedisConnection.prototype.unsubscribe = function() {
    this.redis_conn.unsubscribe(this.redis_channel);
};

RedisConnection.prototype.destroy = function() {
    if (this.redis_conn !== null) {
        this.redis_conn.quit();
    }
};

io.sockets.on('connection', function(socket) {
    var redis_connection;
    socket.on('subscribe', function(redis_channel) {
        redis_connection = new RedisConnection(redis_channel);
        redis_connection.subscribe(socket);
    });
    socket.on('disconnect', function() {
        if (!redis_connection) {
            return;
        }
        redis_connection.unsubscribe();
        redis_connection.destroy();
    });
});
