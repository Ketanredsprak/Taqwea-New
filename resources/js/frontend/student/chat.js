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
            if (data.to_id == uid) {
                receiveMessageHtml(data);
            }
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
        var message = $('#sendMessage_message').val().trim();
        var thread_uuid = $('#sendMessage_thread_uuid').val();
        var fromId = $('#sendMessage_fromId').val();
        var thread_id = $('#sendMessage_thread_id').val();
        var toId = $('#sendMessage_toId').val();
        if (message) {
            sendChatMessage(thread_uuid, fromId, toId, message, thread_id);
            $('#sendMessage_message').val('');
        }

    });

    window.sendMessageHtml = function sendMessageHtml(message) {
        let messageTime = moment.utc(message.created_at).local().format('DD MMM YY hh:mm A');
        var html = '<div class="msgBox msgBox-send"> <div class="msgBox_body"> <div class="msgBox_body_textBox">' + message.message + '</div> <div class="d-flex justify-content-end"><div class="msgBox_body_time">' + messageTime + '</div> <span class="checkmark"></span>';

        html += '</div></div></div>';
        $('#chatDetailList').append(html);
        $('#chatDetailList').scrollTop($('#chatDetailList').get(0).scrollHeight, -1);

    }

    window.receiveMessageHtml = function receiveMessageHtml(message) {
        let messageTime = moment.utc(message.created_at).local().format('DD MMM YY hh:mm A');
        let uuid = $('#sendMessage_thread_uuid').val();
        var html = '<div class="msgBox msgBox-receive"> <div class="msgBox_body"> <div class="msgBox_body_textBox">' + message.message + '</div> <div class="msgBox_body_time">' + messageTime + '</div></div></div>';
        if ($('#chatDetailList').length && uuid == message.thread_uuid) {
            $('#chatDetailList').append(html);
            $('#chatDetailList').scrollTop($('#chatDetailList').get(0).scrollHeight, -1);

            socket.emit(
                'read_message',
                message
            );

        } else {
            $.each($('#userListBox li'), function(e) {
                if ($(this).data('chat_id') == message.thread_uuid) {

                    var count = parseInt($(this).find('span.bagde').text());
                    if (!count) {
                        count = 0;
                    }
                    $(this).find('span.bagde').text(count + 1);
                    $(this).find('span.bagde').show();

                    $(this).remove();
                    html = $(this).html();
                    $("#userListBox").prepend('<li class="userList-searchBox d-flex justify-content-between align-items-center" data-chat_id="' + message.thread_uuid + '" >' + html + '</li>')

                }
            })
        }
    }

    window.readAllMessage = function readAllMessage() {
        let thread_uuid = $('#sendMessage_thread_uuid').val();
        let toId = $('#sendMessage_fromId').val();
        let dataRead = { 'thread_uuid': thread_uuid, 'to_id': toId };
        socket.emit(
            'read_message',
            dataRead
        );
    }

    classUserList();
    if (chat_id) {
        chatUserDetail(chat_id);
    }
});

window.chatUserDetail = function chatUserDetail(chatId) {
    if (chatId != '' && chatId != undefined) {
        var url = process.env.MIX_APP_URL + '/student/chat/' + chatId;

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
}

window.classUserList = function classUserList() {
    var url = process.env.MIX_APP_URL + '/student/chat/list';
    $.ajax({
        url: url,
        data: { "search": $("#search-text").val() },
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
        $('#tutor-search-chat').show();
    } else {
        $('#tutor-search-chat').hide();
    }

    classUserList();
});


$(document).on('click', 'ul#userListBox li', function(e) {
    e.preventDefault();
    var chat_id = $(this).data('chat_id');
    $(this).closest('.userList-searchBox').find(".bagde").text(0);
    $(this).closest('.userList-searchBox').find(".bagde").hide();
    $("ul#userListBox li").removeClass('active');
    $(this).addClass('active');
    chatUserDetail(chat_id);
});

$(document).on('click', '#tutor-search-chat', function() {
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
        let currentChatId = $(this).data('chat_id');

        if (chat_id == currentChatId) {
            $("ul#userListBox li").removeClass('active');
            $(this).addClass('active');
        }
    });

}, 1000)