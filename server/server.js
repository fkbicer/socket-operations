const io = require('socket.io')(3000, {
    cors: {
        origin: ["http://localhost:8080"],
    },
});

io.on('connection', socket => {
    console.log(socket.id);

    socket.on("send-message", async (message, room) => {
        if (room === '') {
            socket.broadcast.emit("recieve-message", message);
            console.log(message);
        } else {
            socket.to(room).emit("recieve-message", message);
        }

        // Dinamik import ile node-fetch'i içe aktarın
        try {
            const { default: fetch } = await import('node-fetch');
            const response = await fetch('http://localhost/socket-test/php/api/v1/create_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message })
            });
            const data = await response.json();
            console.log('PHP Response:', data);
        } catch (error) {
            console.error('Error:', error);
        }
    });

    socket.on('join-room', (room, cb) => {
        socket.join(room);
        cb(`Joined to: ${room}`);
    });
});
