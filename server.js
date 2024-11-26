const express = require('express');
const http = require('http');
const socketIo = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

app.use(express.static('public')); // Serve the frontend files

io.on('connection', (socket) => {
  console.log('New user connected:', socket.id);

  socket.on('join', () => {
    socket.broadcast.emit('userJoined', socket.id);
  });

  socket.on('signal', (data) => {
    socket.to(data.to).emit('signal', { ...data, from: socket.id });
  });

  socket.on('disconnect', () => {
    socket.broadcast.emit('userLeft', socket.id);
  });
});

server.listen(3000, () => {
  console.log('Server running on http://localhost:3000');
});