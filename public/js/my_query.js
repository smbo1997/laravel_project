$(document).ready(function () {
    $('.deleteAccount').click(function () {
        $.ajax({
            url: '/deleteaccount',
            data: '',
            type: 'POST',
            success: function (data) {
             window.location = "/login";
            }
        });
    });
});


