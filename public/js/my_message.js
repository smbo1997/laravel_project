$(document).ready(function () {


    $(window).load(function () {
        $('.notread').css('display', 'none');
        var Ids = [];
        var userId = $('.messageread').attr('id');
        var token = $("input[name=_token]").val();
        if (userId) {
            $.ajax({
                url: '/getnotreadusersmessages',
                type: 'POST',
                data: {_token: token, userId: userId},
                success: function (data) {
                    var jsonData = $.parseJSON(data);
                    if (jsonData.getnotreadmessages) {
                        $.each(jsonData.getnotreadmessages, function (key, value) {
                            $('#usernotsee_' + key).text(value);
                        });

                    }
                }
            });
        }

        $.each($('.create_chat'), function (key, value) {

            Ids.push(value.value);
        });
        if (Ids.length > 0) {
            $.ajax({
                url: '/checkOnline',
                type: 'POST',
                data: {_token: token, myfriendsId: Ids},
                success: function (data) {
                    var jsonData = $.parseJSON(data);
                    $('.online').text('');
                    $.each(jsonData.onlineUsers, function (key, value) {
                        $('#online_user_' + value.id).text('Online');

                    })
                }
            });
        }
    });

    function interval() {
        var userId = $('.messageread').attr('id');
        var token = $("input[name=_token]").val();
        if (userId) {
            $.ajax({
                url: '/getnotreadusersmessages',
                type: 'POST',
                data: {_token: token, userId: userId},
                success: function (data) {
                    var jsonData = $.parseJSON(data);
                    if (jsonData.getnotreadmessages) {
                        $.each(jsonData.getnotreadmessages, function (key, value) {
                            $('#usernotsee_' + key).text(value);
                        });

                    }
                }
            });

        }
    }
    setInterval(interval, 9000);

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
    function checkonline() {
        var Ids = [];
        var token = $("input[name=_token]").val();
        $.each($('.create_chat'), function (key, value) {

            Ids.push(value.value);
        });
        if (Ids.length > 0) {
            $.ajax({
                url: '/checkOnline',
                type: 'POST',
                data: {_token: token, myfriendsId: Ids},
                success: function (data) {
                    var jsonData = $.parseJSON(data);
                    $('.online').text('');
                    $.each(jsonData.onlineUsers, function (key, value) {
                        $('#online_user_' + value.id).text('Online');

                    })
                }
            });
        }
    }


    setInterval(function () {
        checkonline()
    }, 4000);



    $('.create_chat').click(function () {
        var userId = $(this).val();
        setInterval(function () {
            userId = $('#content-messages').attr('data-send-user');
            var message_count = $('#message_count').attr('data-count');
            receiveMessages(userId, message_count)
        }, 5000);


        $('.send-message').removeAttr('disabled');
        $('.fileinput').removeAttr('disabled');
        $('.mailbutton').removeAttr('disabled');
        $('.send-message').val('');
        $('.smiles').css('display', 'block');
        var useremail = $(this).attr('useremail');
        $('.mailbutton').attr('userid', userId);
        $('.mailbutton').attr('useremail', useremail);
        $('.send-message').attr('senduser', userId);
        $('#usernotsee_' + userId).text('');
        var mydiv = $('.msg-wrap');
        var current_user = $('#content-messages').attr('data-current-user');
        var send_user = $('#content-messages').attr('data-send-user', userId);
        $.ajax({
            url: '/user_messages/' + userId,
            type: 'GET',
            success: function (data) {
                console.log(data)
                var html = '<div id="message_count" data-count=' + data.count_messages + '>Count Messages' + ' ' + data.count_messages + '</div>';
                if (data.getMessages.length > 0) {
                    var images = '';
                    $.each(data.getMessages, function (key, value) {
                        if (value.from_user == userId) {
                            if (value.images !== null) {
                                images = '<img src="/users_image/imagesinmessage/' + value.images + '" height="100" width="100">';
                            } else {
                                images = '';
                            }

                            html += '<div class="media msg id_' + value.chat_id + ' ">' +
                                    '<div class="media-body">' +
                                    '<small class="pull-right time"><i class="fa fa-clock-o"></i>' + value.created_at + '</small>' +
                                    '<h5 class="to_user ">' + value.first_name + ' ' + value.last_name + '</h5>' +
                                    '<small class="col-lg-10" id="message_'+value.chat_id+'" >' + value.content + '</small>' +
                                    '<small class="col-lg-10">' + images + '</small>' +
                                    '<span class="glyphicon glyphicon-trash delete_msg" id =' + value.chat_id + ' ></span> &nbsp'+


                                    '</div>' +
                                    '</div>';
                        }
                        if (value.from_user == current_user) {
                            if (value.images !== null) {
                                images = '<img src="/users_image/imagesinmessage/' + value.images + '" height="100" width="100">';
                            } else {
                                images = '';
                                html += '<div class="media msg id_' + value.chat_id + ' ">' +
                                    '<div class="media-body">' +
                                    '<small class="pull-right time"><i class="fa fa-clock-o"></i>' + value.created_at + '</small>' +
                                    '<h5 class="media-heading">' + value.first_name + ' ' + value.last_name + '</h5>' +
                                    '<small class="col-lg-10" id="msg_' + value.chat_id + '">' + value.content + '</small>' +
                                    '<small class="col-lg-10">' + images + '</small>' +
                                    '<span class="glyphicon glyphicon-trash delete_msg" id =' + value.chat_id + ' ></span> &nbsp'+
                                    '<span type="button"  class="glyphicon glyphicon-wrench update_msg update_msg" data-toggle="modal" id =' + value.chat_id + ' data-target="#myModal"></span>'+
                                    '</div>' +
                                    '</div>';
                            }


                        }
                    })
                }

                $('.msg-wrap').html(html);
                mydiv.scrollTop(mydiv.prop('scrollHeight'));
            }

        });
    });

    // update msg

    $(document).on( "click", ".update_msg", function() {
        var msg_id = $(this).attr('id');
        var msg = $('#msg_'+msg_id).text();
        $('.modal-body').html( msg);
        $('.update_my_msg').attr('id', msg_id);
    });


    $(document).on( "click", ".update_my_msg", function() {

        var msg_id = $(this).attr('id');
        var new_msg = $('.modal-body').html();
        $.ajax({
            url: '/update_msg',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {msg_id: msg_id, new_msg:new_msg},
            success: function (data) {
                if(data == 1){
                    $('#msg_'+msg_id).html(new_msg);
                }
            }
        });
    });


    // delete msg

    $(document).on( "click", ".delete_msg", function() {
        var msg_id = $(this).attr('id');

        $.ajax({
            url: '/delete_msg',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {msg_id: msg_id},
            success: function (data) {
                if(data == 1){
                    $('.id_'+msg_id).remove();
                }
            }

        });


    });



    function receiveMessages(userId, message_count) {
        var mydiv = $('.msg-wrap');
        var token = $("input[name=_token]").val();
        $.ajax({
            url: '/receiveUserMessages',
            type: 'POST',
            data: {_token: token, userId: userId, message_count: message_count},
            success: function (data) {
                var new_message_count = data.count_messages;
                if (data.updatedMessages) {
                    console.log(data.updatedMessages);
                    var html = '';
                    var image = '';
                    $.each(data.updatedMessages, function (key, value) {
                        if (value.from_user == userId) {
                            if (value.images) {
                                image = '<img src="/users_image/imagesinmessage/' + value.images + '" height="100" width="100">';
                            } else {
                                var image = '';
                            }
                            html += '<div class="media msg id_'+value.chat_id+'">' +
                                    '<div class="media-body">' +
                                    '<small class="pull-right time"><i class="fa fa-clock-o"></i>' + value.created_at + '</small>' +
                                    '<h5 class="to_user ">' + value.first_name + ' ' + value.last_name + '</h5>' +
                                    '<small class="col-lg-10" id="message_'+value.chat_id+'" >' + value.content + '</small>' +
                                    '<small class="col-lg-10">' + image + '</small>' +
                                    '<span class="glyphicon glyphicon-trash delete_msg" id =' + value.chat_id + ' ></span> &nbsp'+
                                    '</div>' +
                                    '</div>';
                        }
                    })
                    $('.msg-wrap').append(html);
                    mydiv.scrollTop(mydiv.prop('scrollHeight'));
                    $('#message_count').attr('data-count', new_message_count);
                }
            }
        });
    }

    $('.button').click(function () {
        var smile = $(this).attr('smile');
        var message = $('.send-message').val();
        $('.send-message').val(message + '' + smile + '');
    });

    $('.send-message').bind('keypress', function (e) {
        if (e.keyCode == 13) {
            var formdata = new FormData();
            var token = $("input[name=_token]").val();
            var mydiv = $('.msg-wrap');
            var new_message_count = parseInt($('#message_count').attr('data-count')) + 1;
            $('#message_count').attr('data-count', new_message_count);
            var send_user = $('#content-messages').attr('data-send-user');
            var smile = $('.button').attr('smile');
            var current_user = $('.user_name').attr('id');
            var currentUserId = $('.user_name').attr('userid');
            var message = $('.send-message').val();
            var sendMessage = message;
            $.each(smiles, function (key, value) {
                sendMessage = sendMessage.replace(value.key, value.value);
            })

            formdata.append('text', sendMessage);
            formdata.append('userId', send_user);
            var file2 = document.getElementById("image").files[0];
            formdata.append('image', file2);
            if ($('.send-message').val() !== "" || $('.fileinput').val() !== "") {
                $.ajax({
                    url: '/send_message',
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    cache: false,
                    enctype: 'multipart/form-data',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: formdata,
                    success: function (data) {
                        var jsonData = $.parseJSON(data);
                        var images = '';
                        var html = '';
                        console.log(jsonData);
                        if (jsonData) {
                            $.each(jsonData, function (key, value) {
                                console.log(value.first_name);
                                if (value.images !== null) {
                                    images = '<img src="/users_image/imagesinmessage/' + value.images + '" height="100" width="100">';
                                } else {
                                    images = '';
                                    html += '<div class="media msg id_' + value.chat_id + ' ">' +
                                        '<div class="media-body">' +
                                        '<small class="pull-right time"><i class="fa fa-clock-o"></i>' + value.created_at + '</small>' +
                                        '<h5 class="media-heading">' + value.first_name + ' ' + value.last_name + '</h5>' +
                                        '<small class="col-lg-10" id="msg_' + value.chat_id + '">' + value.content + '</small>' +
                                        '<small class="col-lg-10">' + images + '</small>' +
                                        '<span class="glyphicon glyphicon-trash delete_msg" id =' + value.chat_id + ' ></span> &nbsp' +
                                        '<span type="button"  class="glyphicon glyphicon-wrench update_msg update_msg" data-toggle="modal" id =' + value.chat_id + ' data-target="#myModal"></span>' +
                                        '</div>' +
                                        '</div>';
                                }
                                $('.msg-wrap').append(html);
                                mydiv.scrollTop(mydiv.prop('scrollHeight'));
                                $('.send-message').val("");
                                $('.fileinput').val('');
                            });

                        }
                        return true;
                    }
                });
            }
            }
            });



    $('.send-message').click(function () {
        var userId = $(this).attr('senduser');
        var token = $("input[name=_token]").val();
        $.ajax({
            url: '/seemessages',
            type: 'POST',
            data: {_token: token, to_user: userId},
            success: function (data) {
                $('#usernotsee_' + userId).text('');

            }
        });

    });

    $('.mailbutton').click(function () {
        var userId = $(this).attr('userid');
        var to_useremail = $(this).attr('useremail');
        var useremail = $('.user_name').attr('currentuseremail');
        var username = $('.user_name').attr('id');
        var token = $("input[name=_token]").val();
        $.ajax({
            url: '/updatedmessages',
            type: 'POST',
            data: {_token: token, to_user: userId, to_useremail: to_useremail, useremail: useremail, username: username},
            success: function (data) {
                return true;

            }
        });

    });

    setInterval(function () {
        updatedmessages()
    }, 6000);

    function updatedmessages() {
        var token = $("input[name=_token]").val();
        userId = $('.send-message').attr('senduser');
        if(userId){
            $.ajax({
                url: '/updatedmessages',
                type: 'POST',
                data: {_token: token, userId: userId},
                success: function (data) {
                    var jsonData = $.parseJSON(data);
                    if(jsonData.updatedmessages){
                        $.each(jsonData.updatedmessages,function (key,value) {
                            $('#message_' + value.chat_id).text(value.content);
                        })
                    }
                }
            });
        }

    }


});