(function () {
    'use strict';
    require('dotenv').config();
    var express = require('express');
    var request = require('request');
    var app = express();
    var moment = require('moment');
    var mysql = require('mysql');
    const cors = require("cors");
    const dotenv = require("dotenv");
    const fs = require("fs").promises;
    const awsSecretManagers = require("./awsSecretManagers");
    app.use(express.static(__dirname + '/public'));
    var con;
      var server = app.listen(process.env.AAP_PORT, async () => {
        try {
            //get secretsString:
            if (process.env.APP_ENV == 'production') {
                await awsSecretManagers();
            } 
            con = mysql.createConnection({
                host: process.env.DB_HOST,
                user: process.env.DB_USERNAME,
                password: process.env.DB_PASSWORD,
                database: process.env.DB_DATABASE,
                port: process.env.DB_PORT,
            });
        
            //configure dotenv package
        } catch (error) {
            //log the error and crash the app
            console.log("Error in setting environment variables", error);
            process.exit(-1);
        }
    });
    var io = require('socket.io')(server);
  
    var connectedUsers = new Set();
    io.on('connection', function (socket) {
        
        socket.on('join', function (data) {
            socket.class_id = parseInt(data.class_id);
            socket.user_id = data.uid;
            socket.user_type = data.user_type;
            socket.join(data.class_id);
            socket.is_live = '1';
            updateClassJoinStatus(socket);
        });

        socket.on('raise_hand', function(data){
            let roomId = parseInt(data.class_id);
            socket.to(roomId).emit('raise_hand_request', data);
        });

        socket.on('raise_hand_accept', function(data){
            let roomId = parseInt(data.class_id);
            socket.to(roomId).emit('raise_hand_accepted', data);
        });

        socket.on('raise_hand_complete', function(data){
            let roomId = parseInt(data.class_id);
            socket.to(roomId).emit('raise_hand_completed', data);
        });

        socket.on('raise_hand_reject', function(data){
            let roomId = parseInt(data.class_id);
            socket.to(roomId).emit('raise_hand_rejected', data);
        });

        socket.on('extra_hour_request', function(data){
            let roomId = parseInt(data.class_id);
            socket.to(roomId).emit('extra_hour_request', data);
        });

        socket.on('extra_hour_request_accepted', function(data){
            let roomId = parseInt(data.class_id);
            socket.to(roomId).emit('extra_hour_request_accepted', data);
        });

        socket.on('disconnect', function () {
            connectedUsers.delete(socket.userId);
            socket.is_live = '0';
            if (socket.user_id && socket.class_id) {
                updateClassJoinStatus(socket);
            }
            socket.removeAllListeners();
            socket.leave();
        });

        socket.on('end_call', function(data){
            let roomId = parseInt(data.class_id);
            socket.to(roomId).emit('class_completed', data);
        });

        socket.on('show_whiteboard', function(data){
            let roomId = parseInt(data.class_id);
            socket.to(roomId).emit('show_whiteboard', data);
        });

        socket.on('video_profiles', function(data){
            let roomId = parseInt(data.class_id);
            socket.to(roomId).emit('video_profiles', data);
        });

        // Chatting tutor and student
        var chatRoom = "chatRoom";
        socket.on('chat_join', function (data) {
            socket.userId = data;
            connectedUsers.add(data);
            socket.join(chatRoom);
        });

        // save message
        socket.on('send_message', function (data) {
            var currentDate = moment().utc().format('YYYY-MM-D H:mm:ss');
            var sql = "INSERT INTO `messages` (`from_id`, `to_id`, `message`, `created_at`, `updated_at`, `thread_uuid`, `thread_id`) VALUES ('"+data.from_id+"', '"+data.to_id+"', '"+data.message+"',  '"+currentDate+"', '"+currentDate+"', '"+data.thread_uuid+"', '"+data.thread_id+"');";
            con.query(sql, function (err, result) {
               
                let sendData = {'id': result.insertId,'from_id':data.from_id, 'to_id':data.to_id, 'thread_uuid':data.thread_uuid, 'message':data.message, 'thread_id':data.thread_id}
                socket.to(chatRoom).emit('update_messages', sendData);
                var userConnect = 1;
                for(let userConnected of connectedUsers) {
                    if (userConnected.userId == data.to_id) {
                        userConnect = 0;
                    }
                }
                if (userConnect) {
                    sendPushNotification(data);
                }

            });              
        });

        // User read message event
        socket.on('read_message', function (data) {
            socket.to(chatRoom).emit('read_mark_message', data);
            // update read status
            if (data.id !=undefined) {
                var sql = "UPDATE `messages` SET `is_readed` = 1 WHERE `messages`.`id` = "+data.id+";";
                con.query(sql, function (err, result) {
                       
                });
            }
        });

        function updateClassJoinStatus(socket)
        {
            var sql = `UPDATE class_bookings SET is_live = '${socket.is_live}' WHERE student_id = ${socket.user_id} AND class_id = ${socket.class_id};`;
            if (socket.user_type == 'tutor') {
                sql = `UPDATE class_webinars SET is_live = '${socket.is_live}' WHERE id = ${socket.class_id};`;
            }
            con.query(sql, function (err, result) {
            });
        }

        // Send web push if user offline
        function sendPushNotification(data)
        {
            //Send data to server
            const options = {
                url: `${process.env.API_URL}/web-push`,
                method: 'POST',
                body: JSON.stringify({'user_id': data.to_id, 'message':data.message}),
                headers: {
                'Content-Type': 'application/json'
                }
            };
            request.post(options, function (resData, jwRes) {
                console.log(jwRes.body);
            });
  
        }
    });

})();