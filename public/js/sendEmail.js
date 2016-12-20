$(document).ready(function () {
    $('.sendemail').click(function () {
        var mails = [];
        var toMail = $('li').find('.select2-selection__choice');
        $.each($('.select2-selection__choice'), function (key, value) {
            mails.push($(value).attr('title'));
        });
        if (mails.length > 0) {
            var fromMail = $('.fromEmail').attr('id');
            var fromName = $('.fromname').attr('id');
            var subject = $('.subject').val();
            var content = $('.content').html();
            var css = $('.cssstyles').html();
            var token = $("input[name=_token]").val();
            $.ajax({
                url: '/sendEmailMessage',
                type: 'POST',
                data: {_token: token, fromMail: fromMail, subject: subject, content: content, fromName: fromName, toMail: mails, css: css},
                success: function (data) {
                    //location.reload();
                }

            });
        }

    });
    $('.addstyles').click(function () {
        var styles = $('.stylecontent').val();
        $('.bd-example-modal-sm').attr('style', 'display:none;');
        $('.styles').html(styles);
    });

    $('.savetemplate').click(function () {
        var templatename = $('.contentname').val();
        var templatecontent = $('.createdcontent').html();
        var tmplatestyles = $('.tmplatestyles').html();
        if (templatename.length > 0 && templatecontent.length > 0) {
            $.ajax({
                url: '/welcome/addtemplate',
                type: 'POST',
                data: {templatename: templatename, templatecontent: templatecontent, tmplatestyles: tmplatestyles},
                success: function (data) {
                    location.reload();
                }
            });
        }
    });


    $('.addtemplate').click(function () {
        $('.mailcontent').attr('id', '');
    });


    $('.seetext').click(function () {
        var html = $('.createdcontent').html();
        if ($(".createdcontent").html().trim().length !== 0) {
            $('.createdcontent').text(html);
            $('.seedesign').removeAttr('disabled', 'disabled');
            $('.seetext').attr('disabled', 'disabled');
            $('.mycreatedtemplates').attr('disabled', 'disabled');
            $('.popbtn').removeAttr('disabled', 'disabled');
            $('.dropmenu').removeAttr('disabled', 'disabled');
        }
    });

    $('.seedesign').click(function () {
        var text = $('.createdcontent').text();
        if ($(".createdcontent").html().trim().length !== 0) {
            $('.createdcontent').html(text);
            $('.seedesign').attr('disabled', 'disabled');
            $('.dropmenu').attr('disabled', 'disabled');
            $('.seetext').removeAttr('disabled', 'disabled');
            $('.mycreatedtemplates').removeAttr('disabled', 'disabled');
            $('.popbtn').attr('disabled', 'disabled');
        }

    });

    $('.gettemplates').click(function () {
        var id = $(this).attr('id');
        $.ajax({
            url: '/welcome/gettemplates',
            type: 'POST',
            data: {templateid: id},
            success: function (data) {
                var jsonData = $.parseJSON(data);
                if (jsonData.templates.length > 0) {
                    $.each(jsonData.templates, function (key, value) {
                        var newContent = value.content;
                        $.each(jsonData.userdata, function (key, value) {
                            newContent = newContent.replace(key, value);
                            $('.mailcontent').html(newContent);
                        });
                        $('.cssstyles').html(value.css);
                    });
                }
            }
        });
    });

    $('.mytemplates').click(function () {
        var id = $(this).attr('id');
        var styles = $('.styles').html();
        $('.seedesign').attr('disabled', 'disabled');
        $('.popbtn').attr('disabled', 'disabled');
        $('.seetext').removeAttr('disabled', 'disabled');
        $.ajax({
            url: '/welcome/gettemplates',
            type: 'POST',
            data: {templateid: id},
            success: function (data) {
                var jsonData = $.parseJSON(data);
                if (jsonData.templates.length > 0) {
                    $.each(jsonData.templates, function (key, value) {
                        $('.createdcontent').html(value.content);
                        $('.tmplatestyles').html(value.css);
                    });
                }
                $('.styles').append(styles);
            }
        });
    });

    $('.addelement').click(function () {
        var content = $(this).attr('content');
        var html = $('.createdcontent').text();
        $('.createdcontent').text(html + content);

    });

    $('.adddata').click(function () {
        var content = $(this).attr('content');
        var html = $('.createdcontent').text();
        $('.createdcontent').text(html + content);
    });


    $('.removeicon').click(function () {
        var id = $(this).attr('elementid');
        $.ajax({
            url: '/welcome/removeTemplate',
            type: 'POST',
            data: {id: id},
            success: function (data) {
                location.reload();
            }
        });
    });

    $('.getcssstyles').click(function () {
        var styles = $('.styles').text();
        $('.stylecontent').val(styles);
    });

});




