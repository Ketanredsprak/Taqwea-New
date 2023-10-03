$(function() {

    try {
        var socket = io.connect(socketUrl, {
            reconnection: true,
            reconnectionDelay: 1000,
            reconnectionDelayMax: 5000,
            reconnectionAttempts: Infinity,
            transports: ['websocket'],
        });

        socket.emit('chat_join', { "userId": uid });

        socket.on('update_messages', function(data) {
            receiveMessageHtml(data);
        });

        socket.on('read_mark_message', function(data) {
            let uuid = $('#sendMessage_thread_uuid').val();
            if (uuid == data.thread_uuid &&
                $('#chatDetailList').length
            ) {
                $(".checkmark").each(function(index) {
                    $(this).addClass('seen');
                });
            }
        });
    } catch (err) {
        console.log(err);
    }


    window.sendChatMessage = function sendChatMessage(thread_uuid, fromId, toId, message, thread_id) {

        let sendData = { 'from_id': fromId, 'to_id': toId, 'thread_uuid': thread_uuid, 'message': message, 'thread_id': thread_id };
        socket.emit(
            'send_message',
            sendData
        );
        sendMessageHtml(sendData);
    }

    $(document).on('click', '.send_chat_message', function() {
        var thread_uuid = $('#sendMessage_thread_uuid').val();
        var fromId = $('#sendMessage_fromId').val();
        var toId = $('#sendMessage_toId').val();
        var thread_id = $('#sendMessage_thread_id').val();
        var message = $('#sendMessage_message').val().trim();
        if (message) {
            sendChatMessage(thread_uuid, fromId, toId, message, thread_id);
            $('#sendMessage_message').val('');
        }

    });

    window.sendMessageHtml = function sendMessageHtml(message) {
        let messageTime = moment.utc(message.created_at).local().format('DD MMM YY hh:mm A');

        var html = '<div class="msgBox msgBox-send"> <div class="msgBox_body"> <div class="msgBox_body_textBox">' + message.message + '</div> <div class="d-flex justify-content-end"><div class="msgBox_body_time">' + messageTime + '</div><span class="checkmark"></span>';

        html += '</div></div></div>';
        $('#chatDetailList').append(html);
        $('#chatDetailList').scrollTop($('#chatDetailList').get(0).scrollHeight, -1);
    }

    window.receiveMessageHtml = function receiveMessageHtml(message) {
        let uuid = $('#sendMessage_thread_uuid').val();
        let toId = $('#sendMessage_toId').val();
        let messageTime = moment.utc(message.created_at).local().format('DD MMM YY hh:mm A');
        var html = '<div class="msgBox msgBox-receive"> <div class="msgBox_body"> <div class="msgBox_body_textBox">' + message.message + '</div> <div class="msgBox_body_time">' + messageTime + '</div></div></div>';

        if (uuid == message.thread_uuid &&
            toId == message.from_id &&
            $('#chatDetailList').length
        ) {
            $('#chatDetailList').append(html);
            $('#chatDetailList').scrollTop($('#chatDetailList').get(0).scrollHeight, -1);

            socket.emit(
                'read_message',
                message
            );
        } else {
            $.each($('#userListBox li'), function(e) {
                if ($(this).data('chat_id') == message.thread_uuid && $(this).data('chat-user') == message.from_id) {
                    var count = parseInt($(this).find('span.bagde').text());
                    if (!count) {
                        count = 0;
                    }
                    $(this).find('span.bagde').text(count + 1);
                    $(this).find('span.bagde').show();

                    $(this).remove();
                    html = $(this).html();
                    $("#userListBox").prepend('<li class="userList-searchBox d-flex justify-content-between align-items-center" data-chat_id="' + message.thread_uuid + '" data-chat-user="' + message.from_id + '" >' + html + '</li>')
                }
            })

        }
    }

    window.readAllMessage = function readAllMessage() {
        let thread_uuid = $('#sendMessage_thread_uuid').val();
        let dataRead = { 'thread_uuid': thread_uuid };
        socket.emit(
            'read_message',
            dataRead
        );
    }
    classUserList();

    if (chatId && studentId) {
        chatUserDetail(chatId, studentId);

    }
});

window.chatUserDetail = function chatUserDetail(chatId, studentId) {
    if (chatId != '' && chatId != undefined) {
        var url = process.env.MIX_APP_URL + '/tutor/chat/' + chatId + '/' + studentId;
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                if (response.success) {
                    $("#chatDetail").html(response.data);
                    $('#chatDetailList').scrollTop($('#chatDetailList').get(0).scrollHeight, -1);
                    readAllMessage();
                    removeHeaderCount();
                }
            },
            error: function(data) {
                handleError(data);
            },
        });
    }
};


window.classUserList = function classUserList() {
    var url = process.env.MIX_APP_URL + '/tutor/chat/list';
    var class_id = $("#tutor-classes").val();
    var search = $("#search-text").val();
    $.ajax({
        url: url,
        data: { "search": search, "class_id": class_id },
        type: "GET",
        async: false,
        success: function(response) {
            $("#chatList").html(response.data);
        },
        error: function(data) {
            handleError(data);
        },
    });
};

window.removeHeaderCount = function removeHeaderCount() {
    var unRead = 1;
    $('ul#userListBox li').each(function() {
        let count = $(this).closest('.userList-searchBox').find(".bagde").text();
        if (parseInt(count)) {
            unRead = 0;
        }
    });
    if (unRead) {
        $(".chat-header").removeClass('chat-info');
    }
}

$(document).on('keyup', '#search-text', function() {
    if ($(this).val() != '') {
        $('.search-clear').show();
    } else {
        $('.search-clear').hide();
    }

    classUserList();
});
$(document).on('change', '#tutor-classes', function() {
    classUserList();
});

$(document).on('click', 'ul#userListBox li', function(e) {
    e.preventDefault();
    var chatId = $(this).data('chat_id');
    var studentId = $(this).data('chat-user');
    $(this).closest('.userList-searchBox').find(".bagde").text(0);
    $(this).closest('.userList-searchBox').find(".bagde").hide();
    $("ul#userListBox li").removeClass('active');

    $(this).addClass('active');
    chatUserDetail(chatId, studentId);
});

$(document).on('click', '.search-clear', function() {
    $("#search-text").val('');
    $(this).hide();
    classUserList();
});

setInterval(function() {
    $(".chat-now").each(function(index) {
        let startTime = moment.utc($(this).data('date-time')).format('YYYY-MM-DD HH:mm:ss');
        let currentTime = moment.utc().format('YYYY-MM-DD HH:mm:ss');
        if (startTime <= currentTime) {
            $('#sendMessage_message').attr('disabled', true);
        }
    });

}, 1000)

setTimeout(function() {
    $(".userList-searchBox").each(function(index) {
        let currentUser = $(this).data('chat-user');
        let currentChatId = $(this).data('chat_id');

        if (studentId == currentUser && chatId == currentChatId) {
            $("ul#userListBox li").removeClass('active');
            $(this).addClass('active');
        }
    });

}, 1000)


