$(document).ready(function () {
    $('.deleteuser').click(function () {
        var imageId = $(this).val();
        $.ajax({
            url: '/admin/deleteUserimage/' + imageId,
            type: "GET",
            success: function (data) {
                location.reload();
            }
        });
    });
    $('.usersFriendDelete').click(function () {
        var userid = $(this).attr('user_id');
        $.ajax({
            url: '/admin/usersFriendDelete/' + userid,
            type: "GET",
            success: function (data) {
                location.reload();
            }
        });
    });
    $('#selectkey').change(function () {
        $('#selectlanguage').val(0);
        $('#selectlanguage').trigger('change');
    });
    $('#selectlanguage').change(function () {
        var language = [];
        var get_key = $('#selectkey option:selected').val();
        var getlanguage = $('#selectlanguage option:selected').val();
        language.push({language_key: $('#selectkey option:selected').val(), language: $('#selectlanguage option:selected').val()});
        // console.log(language);
        $.ajax({
            url: '/admin/checklanguagekey',
            type: "POST",
            data: {getlanguage: language},
            success: function (data) {
                var jsonData = $.parseJSON(data);
                if (jsonData.getword !== null && jsonData.getword.length > 0) {
                    $.each(jsonData.getword, function (key, value) {
                        if (value.text) {
                            $('#text').val(value.text);
                            $('#translate').attr('name', 'updateword');
                            $('#translate').text('update');
                        }
                    });
                } else {
                    $('#text').val('');
                    $('#translate').attr('name', 'addword');
                    $('#translate').text('Add');
                }
            }
        });
    });
    $('#key').keyup(function () {
        var key = $(this).val();
        //console.log(key);
        $.ajax({
            url: '/admin/searchWord',
            type: 'POST',
            data: {key: key},
            success: function (data) {
                if (data)
                    $('.keyText').html("<h5 style='color:red; font-size:15px'>It has been!</h5>");
                else
                    $('.keyText').html('');
            }
        });
    });
    $('.addlanguage').click(function () {
        var languageCode = $('.languageCode').val();
        var languageName = $('.languageName').val();
        if (languageCode.length > 0 && languageName.length > 0) {
            $.ajax({
                url: '/admin/addlanguage',
                type: 'POST',
                data: {languageCode: languageCode, languageName: languageName},
                success: function (data) {
                    location.reload();
                }
            });
        }
    });

    $('.addKey').click(function () {
        var keyName = $('.keyName').val();
        if (keyName.length > 0) {
            $.ajax({
                url: '/admin/addkey',
                type: 'POST',
                data: {keyName: keyName},
                success: function (data) {
                    location.reload();
                }
            });
        }
    });

    $('.key').keyup(function () {
        var key = $(this).val();
        //console.log(key);
        $.ajax({
            url: '/admin/searchWord',
            type: 'POST',
            data: {key: key},
            success: function (data) {
                if (data)
                    $('.keyText').html("<h5 style='color:red; font-size:15px'>It has been!</h5>");
                else
                    $('.keyText').html('');
            }
        });
    });

    $('.addnewuser').click(function () {
        var firstname = $('.firstname').val();
        var lastname = $('.lastname').val();
        var username = $('.uname').val();
        var email = $('.email').val();
        var password = $('.password').val();
        if (firstname.length > 0 && lastname.length > 0 && username.length > 0 && email.length > 0 && password.length > 0) {
            $.ajax({
                url: '/admin/createNewUser',
                type: 'POST',
                data: {firstname: firstname, lastname: lastname, username: username, email: email, password: password},
                success: function (data) {
                    location.reload();
                }
            });
        }
    });

    $('.addelement').click(function () {
        var elementname = $('.elementname').val();
        var elementcontent = $('.elementcontent').val();
        if (elementname.length > 0 && elementcontent.length > 0) {
            $.ajax({
                url: '/admin/addelement',
                type: 'POST',
                data: {elementname: elementname, elementcontent: elementcontent},
                success: function (data) {
                    location.reload();
                }
            });
        }
    });


    $('.editable-click').editable();

});