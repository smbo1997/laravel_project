$(document).ready(function () {
    var path = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
   
    function interval() {

        var userId = $('.messageread').attr('id');
        var token = $("input[name=_token]").val();
        if (userId) {
            $.ajax({
                url: '/getnotreadmessages',
                type: 'POST',
                data: {_token: token, userId: userId},
                success: function (data) {

                    var jsonData = $.parseJSON(data);
                    if (jsonData.getnotreadmessages > 0) {
                        $('.notread').css('display', 'block');
                        $('.notread').text(jsonData.getnotreadmessages);
                    }
                }
            });
        }
    }
    if (path !== 'mymessages') {
        setInterval(interval, 3000);
    }


});

