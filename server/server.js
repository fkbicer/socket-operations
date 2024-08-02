const io = require('socket.io')(3000, {
    cors : {
        origin : ["http://localhost:8080"],
    },
})

io.on('connection', socket => {
    console.log(socket.id)
    socket.on("send-message" , (message, room) => {
        if (room === ''){
            socket.broadcast.emit("recieve-message" , message)
            console.log(message)
        } else {
            socket.to(room).emit("recieve-message" , message)
        }
        
    })
    socket.on('join-room', (room, cb) => {
        socket.join(room)
        cb(`Joined to: ${room}`)

    })

})