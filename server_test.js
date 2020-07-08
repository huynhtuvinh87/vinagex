var app = require('express')(), port = 8890;
var server = require('http').Server(app);
var Redis = require('ioredis');
var redis = new Redis();
var users = {};

server.listen(port, function () {
    console.log('Listening on port ' + port);
});
var io = require('socket.io')(server);
io.on('connection', function (socket) {
    console.log("New connect");
    var userId = socket.handshake.query.userid;
    var room = socket.handshake.query.room;
    socket.join(room);
    if (userId in users) {
        //fail
        console.log('Đã tồn tại');
    } else {
        console.log("Added");
        users[userId] = socket;
    }

    //disconnect
    socket.on('disconnect', function () {
        console.log(socket.id + ': disconnect');
        delete users[userId];
    });

});

redis.subscribe('chat', 'focus', function (err, count) {
    // Now we are subscribed to both the 'news' and 'music' channels.
    // `count` represents the number of channels we are currently subscribed to.
});

redis.on("message", function (channel, message) {
    var message = JSON.parse(message);
    console.log(message);
    if (channel == 'chat') {
        var receive = message.receive;
        var sender = message.sender;
        var senderSocket = users[sender] || null;
        var receiveSocket = users[receive] || null;
        if (receiveSocket) {
            receiveSocket.join(message.message_id);
        }
        if (senderSocket) {
            senderSocket.join(message.message_id);
//        io.to(users[message.receive].id).emit(channel, message);
            io.to(message.message_id).emit(channel, message);
            console.log("Message was succefully sent!");
        }
    } else if (channel == 'focus') {
        var senderSocket = users[message.sender] || null;
        if (senderSocket) {
            senderSocket.broadcast.to(message.message_id).emit(channel, message);
        }
    }
});