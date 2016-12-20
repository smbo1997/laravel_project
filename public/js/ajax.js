$(document).ready(function () {

    $('.smiles').click(function () {
        $('.smile_box').toggle();
    });

    $(document).on('click', '.add_friend', function () {
        var userId = $(this).val();
        var token = $("input[name=_token]").val();
        $.ajax({
            url: "/addFriendFromSearch",
            data: {_token: token, userId: userId},
            type: "POST",
            success: function (data) {
                if (data) {
                    $("#addFriend_" + userId).text('Request is done');
                    $("#addFriend_" + userId).attr('disabled', 'disabled');
                    $("#addFriend_" + userId).toggleClass('btn-default btn-primary');
                }
            }
        });
    });
    $('#username').keyup(function () {
        var username = $(this).val();
        // console.log(username);
        $.ajax({
            url: "/welcome/checkUser",
            type: "POST",
            data: {username: username},
            success: function (data) {
                if (data)
                    $("#busy").text('This name is already taken!');
                else
                    $("#busy").text('');
            }
        });
    });
    $('#SearchUsername').keyup(function () {
        var username = $(this).val();
        $.ajax({
            url: '/welcome/searchUser',
            type: 'POST',
            data: {username: username},
            success: function (data) {
                if (data)
                    $('.text').html("<h5 style='color:green; font-size:13px'>Your Username is correct!</h5>");
                else
                    $('.text').html("<h5 style='color:red; font-size:13px'>Your Username is not correct!</h5>");
            }
        });
    });
    $('.friend').click(function () {
        var id = $(this).val();
        var token = $("input[name=_token]").val();
        $.ajax({
            url: '/AddUserRequestFromFriendsPage',
            type: 'POST',
            data: {id: id, _token: token},
            success: function (response) {
                location.reload();
            }
        });
    });
    $('.del-friend').click(function () {
        var id = $(this).val();
        var token = $("input[name=_token]").val();
        $.ajax({
            url: '/DeleteUserFromFriendsPage',
            type: 'POST',
            data: {id: id, _token: token},
            success: function (response) {
                location.reload();
            }
        });
    });
    $('.prof-del-friend').click(function () {
        var id = $(this).val();
        $.ajax({
            url: '/welcome/DeleteFriend/' + id,
            type: 'GET',
            success: function () {
                history.go(-1);
            }
        });
    });
    $(document).on('click', '.search-del-friend', function () {
        var userId = $(this).val();
        var id = $(this).attr('data');
        var token = $("input[name=_token]").val();
        $.ajax({
            url: '/deleteFriendFromSearch',
            type: 'POST',
            data: {userId: id, _token: token},
            success: function (response) {
                if (response) {
                    $("#user_" + userId).text('Add friend');
                    $("#user_" + userId).attr('id','addFriend_'+userId);
                    $("#user_" + userId).attr('data','');
                    $("#user_" + userId).removeClass('btn-success search-del-friend');
                    $("#user_" + userId).addClass('btn-default add_friend');
                }
            }
        });
    });
    $('.addwithprofil').click(function () {
        var id = $(this).attr('id');
        $.ajax({
            url: '/welcome/ProfileAddFriend/' + id,
            type: 'GET',
            success: function () {
                location.reload();
            }
        });
    });
    $('.activate').click(function () {
        var userId = $('.activate').attr('userid');
        var language = $('.activate').attr('language');
        $.ajax({
            url: '/welcome/checkactivation',
            type: 'POST',
            data: {userId: userId},
            success: function () {
                window.location.href = '/' + language + '/welcome/login';
            }
        });
    });
    $('.searchUsers').keyup(function () {
        var userName = $(this).val();
        var language = $(this).attr('name')
        var token = $("input[name=_token]").val();
        $('.addusersintable').empty();
        if (userName == '') {
            $('.search').css('display', 'none');
        }
        $.ajax({
            url: '/searchusers',
            type: 'POST',
            data: {_token: token, user_name: userName},
            success: function (data) {
                var html = '';
                if (data) {
                    var jsonData = $.parseJSON(data);
                    var currentuser = jsonData.currentuser;
                    $('.search').css('display', 'block');
                    var userId = '';
                    $.each(jsonData.users, function (key, value) {

                        var imageuri = '';
                        if (value.image != null) {
                            imageuri = '/users_image/user_' + value.id + '/general/' + value.image;
                        } else {
                            imageuri = '/users_image/avatar.png';
                        }
                        if ((value.from_user == currentuser && value.status == 0) || (value.to_user == currentuser && value.status == 0)) {

                            button = '<button class = "btn btn-primary" style = "margin-top: 43px;"  value = "' + value.id + '" id = "primary_' + value.id + '" disabled ="disabled" >Request is done</button>';
                        } else if ((value.from_user == currentuser && value.status == 1) || (value.to_user == currentuser && value.status == 1)) {
                            (value.from_user == currentuser && value.status == 1) ? userId = value.to_user : userId = value.from_user;
                            button = '<button class = "btn btn-success search-del-friend "  style = "margin-top: 43px;" value = "' + userId + '"    id = "user_' + userId + '"   data="' + value.table_id + '"> Remove From Friend List </button>';
                        } else if (value.from_user == null && value.to_user == null) {

                            var button = '<button class = "btn btn-default add_friend" style = "margin-top: 43px;" value = "' + value.id + '" id = "addFriend_' + value.id + '">Add friend </button>';
                        }

                        html = '<tr>' +
                                '<td>' +
                                '<h5>' +
                                '<a href="' + '/' + language + '/user_profile/' + value.id + '">' +
                                '<img  width = "100px" height = "100px" src = "' + imageuri + '" >' +
                                value.first_name + ' ' + value.last_name +
                                '</a>' +
                                '</h5>' +
                                '</td>' +
                                '<td>' +
                                button +
                                '</td>' +
                                '</tr>';
                        $('.addusersintable').append(html);
                    });
                }

            }
        });
    });
});

