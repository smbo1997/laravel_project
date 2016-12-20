$(document).ready(function () {
    var smiles = [
        {
            key: ':H',
            value: '<img  src="/smile/1.gif"  "/>'
        },
        {
            key: ':C',
            value: '<img  src="/smile/4.gif" "/>'
        },
        {
            key: ':)',
            value: '<img  src="/smile/3.gif"  "/>'
        },
        {
            key: ':A',
            value: '<img  src="/smile/2.gif"  "/>'
        },
        {
            key: ':D',
            value: '<img  src="/smile/7.gif"  "/>'
        },
        {
            key: ':(',
            value: '<img  src="/smile/6.gif"  "/>'
        },
        {
            key: ':X',
            value: '<img  src="/smile/5.gif"  "/>'
        },
        {
            key: ':J',
            value: '<img  src="/smile/8.gif"  "/>'
        },
        {
            key: ':Q',
            value: '<img  src="/smile/12.gif"  "/>'
        },
        {
            key: ':B',
            value: '<img  src="/smile/11.gif"  "/>'
        },
        {
            key: ':L',
            value: '<img  src="/smile/9.gif"  "/>'
        },
        {
            key: ':o',
            value: '<img  src="/smile/20.gif" "/>'
        },
        {
            key: ':E',
            value: '<img  src="/smile/18.gif"  "/>'
        },
        {
            key: ':R',
            value: '<img  src="/smile/13.gif"  "/>'
        },
        {
            key: ':W',
            value: '<img  src="/smile/15.gif"  "/>'
        },
        {
            key: ':K',
            value: '<img  src="/smile/14.gif"  "/>'
        },
        {
            key: ':G',
            value: '<img  src="/smile/10.gif"  "/>'
        },
        {
            key: ':F',
            value: '<img  src="/smile/17.gif"  "/>'
        },
        {
            key: ':P',
            value: '<img  src="/smile/19.gif"  "/>'
        },
        {
            key: ':Z',
            value: '<img  src="/smile/16.gif"  "/>'
        }
    ];
    function chatBody(userId, name) {
        var html = '<div class="chat">' +
                '<div class="row col-xs-5 col-md-3 chat-window-now chat_window_' + userId + ' get_chat" id="chat_window_' + userId + '" user="' + userId + '" >' +
                '<div class="col-xs-12 col-md-12">' +
                '<div class="panel panel-default">' +
                '<div class="panel-heading top-bar">' +
                '<div class="col-md-8 col-xs-8">' +
                '<h3 class="panel-title"><span class="glyphicon glyphicon-comment" id="online_user_' + userId + '"></span>' + name + '</h3>' +
                '</div>' +
                '<div class="col-md-4 col-xs-4" style="text-align: right;">' +
                '<span  class="glyphicon glyphicon-minus icon_minim"></span>' +
                '<span class="glyphicon glyphicon-remove icon_close" id="' + userId + '"></span>' +
                '</div>' +
                '</div>' +
                '<div class="panel-body msg_container_base message-base" id="message_' + userId + '">' +
                '</div>' +
                '<div class="panel-footer">' +
                '<div class="input-group">' +
                '<input type="text" class="form-control input-sm chat_input messageContent_' + userId + '"    placeholder="Write your message here..." />' +
                '<span class="input-group-btn">' +
                '<button class="btn btn-primary btn-sm btn-send" send-user="' + userId + '">Send</button>' +
                '</span>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
        return html;
    }
    var chatnumber = (localStorage.getItem("chatnumber")) ? localStorage.getItem("chatnumber") : 0;
    var users_open_chats = [];
    if (chatnumber > 0) {
        var chat_boxes_html = $.parseJSON(localStorage.getItem("chat_boxes_html"));
        if (chat_boxes_html) {
            $.each(chat_boxes_html, function (key, value) {
                $("#chat").append(value.chatBody);
                $('#chat_window_' + value.userId).attr('count_messages', value.count_messages);
                $('#message_' + value.userId).html(value.chat_html);
                $('#message_' + value.userId).scrollTop($('#message_' + value.userId).prop('scrollHeight'));
            });
        }
    } else {
        $("#chat").html('');
    }
    $(document).on('click', '.chat-box', function () {
        if (chatnumber < 4) {
            var token = $("input[name=_token]").val();
            var userId = $(this).val();
            var check = $('.user_' + userId).attr('user');
            if (check == 0) {
                chatnumber++;
                localStorage.setItem("chatnumber", chatnumber);
                $('.user_' + userId).attr('user', '1');
                var current_user = $(this).attr('current_user');
                var name = $(this).attr('user-name');
                $("#chat").append(chatBody(userId, name));
                $.ajax({
                    url: '/getSmallChatMessages',
                    type: 'POST',
                    data: {_token: token, userId: userId},
                    success: function (data) {
                        var html = '<p class="count_messages_' + userId + '" data_count=' + data.count_messages + '></p>';
                        $('#chat_window_' + userId).attr('count_messages', data.count_messages);
                        if (data.getMessages.length > 0) {
                            $.each(data.getMessages, function (key, value) {
                                if (value.from_user == userId) {

                                    html += '<div class = "row msg_container base_receive" >' +
                                            '<div class = "col-md-10 col-xs-10" >' +
                                            '<div class = "messages msg_receive" >' +
                                            '<p>' + value.content + '</p>' +
                                            '<time>' + value.created_at + '</time>' +
                                            '</div>' +
                                            '</div>' +
                                            '</div>';
                                }
                                if (value.from_user == current_user) {
                                    html += '<div class="row msg_container base_sent">' +
                                            ' <div class="col-md-10 col-xs-10">' +
                                            '<div class="messages msg_sent">' +
                                            '<p>' + value.content + '</p>' +
                                            '<time>' + value.created_at + '</time>' +
                                            '</div>' +
                                            '</div>' +
                                            '</div>';
                                }
                            })
                            $('#message_' + userId).html(html);
                            $('#message_' + userId).scrollTop($('#message_' + userId).prop('scrollHeight'));
                            users_open_chats = (localStorage.getItem("chat_boxes_html")) ? $.parseJSON(localStorage.getItem("chat_boxes_html")) : [];
                            users_open_chats.push({userId: userId, chatBody: chatBody(userId, name), chat_html: html, count_messages: data.count_messages});
                            localStorage.setItem('chat_boxes_html', JSON.stringify(users_open_chats));
                        }
                    }

                });
            }
        }

    });

//   function onlineUsers() {
//     var Ids = [];
//     var chats = $('div').find('.get_chat');
//     $.each($('.get_chat'), function (key, value) {
//     Ids.push($(value).attr('user'));
//     });
//     if (Ids.length > 0) {
//     $.ajax({
//     url: '/welcome/checkOnline',
//     type: 'POST',
//     data: {myfriendsId: Ids},
//     success: function (data) {
//     var jsonData = $.parseJSON(data);
//     $('.glyphicon-comment').css('color', '');
//     $.each(jsonData.onlineUsers, function (key, value) {
//     $('#online_user_' + value.id).css('color', '#00FF00');
//     });
//     }
//     
//     });
//     }
//     }
//
//
//    setInterval(function () {
//        onlineUsers();
//    }, 6000);

    $(document).on('click', '.btn-send', function () {
        var sendUser = $(this).attr('send-user');
        if ($('.messageContent_' + sendUser).val() == "") {
            return false;
        }
        var token = $("input[name=_token]").val();
        var new_message_count = parseInt($('.count_messages_' + sendUser).attr('data_count')) + 1;
        $('.count_messages_' + sendUser).attr('data_count', new_message_count);
        var new_count = parseInt($('#chat_window_' + sendUser).attr('count_messages')) + 1
        $('#chat_window_' + sendUser).attr('count_messages', new_count);
        var message = $('.messageContent_' + sendUser).val();
        var message_base = $('#message_' + sendUser);
        var sendMessage = message;
        $.each(smiles, function (key, value) {
            //  console.log(value);
            sendMessage = sendMessage.replace(value.key, value.value);
        });

        $.ajax({
            url: '/sendSmallChatmessage',
            type: 'POST',
            data: {_token: token, text: sendMessage, userId: sendUser},
            success: function (data) {
                if (data.data) {
                    var t = new Date();
                    var h = t.getHours();
                    var m = t.getMinutes();
                    if (m < 10)
                        m = '0' + m;
                    var y = t.getFullYear();
                    var M = t.getMonth();
                    if (M < 10)
                        M = '0' + M;
                    var d = t.getDate();
                    if (d < 10)
                        d = '0' + d;
                    var s = t.getSeconds();
                    if (s < 10)
                        s = '0' + s;
                    message_base.append(
                            '<div class="row msg_container base_sent">' +
                            ' <div class="col-md-10 col-xs-10">' +
                            '<div class="messages msg_sent">' +
                            '<p>' + sendMessage + '</p>' +
                            '<time>' + y + '-' + M + '-' + d + ' ' + h + ':' + m + ':' + s + '</time>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                            );
                    $('.messageContent_' + sendUser).val("");
                    message_base.scrollTop(message_base.prop('scrollHeight'));
                }
                return false;
            }
        });
    });


    function receiveMessages() {
        var token = $("input[name=_token]").val();
        var users = [];
        var chats = $('div').find('.get_chat');
        $.each(chats, function (key, value) {
            users.push({
                id: $(value).attr('user'), count: $(value).attr('count_messages')
            });
        });
        if (users.length > 0) {
            $.ajax({
                url: '/receiveSmallchatMessages',
                type: 'POST',
                data: {_token: token, users: users},
                success: function (data) {
                    if (data.receiveMessages!= 0)
                    {
                        $.each(data.receiveMessages, function (key, value) {
                            $('#chat_window_' + key).attr('count_messages', data.count_messages[key]);
                            $('.count_messages_' + key).attr('data_count', data.count_messages[key]);
                            $.each(value, function (key, value) {
                                var html = '';
                                html += '<div class = "row msg_container base_receive" >' +
                                        '<div class = "col-md-10 col-xs-10" >' +
                                        '<div class = "messages msg_receive" >' +
                                        '<p>' + value.content + '</p>' +
                                        '<time>' + value.created_at + '</time>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>';
                                $('#message_' + value.from_user).append(html);
                                $('#message_' + value.from_user).scrollTop($('#message_' + value.from_user).prop('scrollHeight'));
                            })
                        });
                    }

                }
            });
        }
    }

    setInterval(function () {
        receiveMessages()
    }, 4000);


    $(document).on('click', '.icon_close', function () {
        var id = $(this).attr('id');
        $('.user_' + id).attr('user', '0');
        var deletechat = $('.chat_window_' + id);
        //console.log(users_open_chats);
        deletechat.remove();
        chatnumber--;
        if (chatnumber > 0) {

            var chat_boxes_html = $.parseJSON(localStorage.getItem("chat_boxes_html"));
            var new_chat_boxes_html = [];
            $.each(chat_boxes_html, function (key, value) {
                //console.log(value);
                if (value.userId != id)
                    new_chat_boxes_html.push(value);
            });
            localStorage.setItem("chatnumber", chatnumber);
            localStorage.setItem('chat_boxes_html', JSON.stringify(new_chat_boxes_html));
            users_open_chats = JSON.stringify(new_chat_boxes_html);
        } else
        {
            localStorage.removeItem("chat_boxes_html");
            localStorage.removeItem("chatnumber");
        }
    });

    $('.logout').click(function () {
        localStorage.clear();
    });

    $(window).load(function () {
        var chats = $('div').find('.get_chat');
        $.each($('.chat-box'), function (key, value) {
            if (chat_boxes_html !== undefined) {
                $.each(chat_boxes_html, function (key, item) {
                    if ($(value).attr('value') == item.userId) {
                        $('.user_' + item.userId).attr('user', '1');
                    }
                });
            }
        });
    });
});
