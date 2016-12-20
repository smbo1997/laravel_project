$(document).ready(function () {

    $('.create_chat').click(function () {
        $('.send-message').removeAttr('disabled');
        $('.send-message').val('');
             var mydiv = $('.msg-wrap');
        var userId = $('.create_chat').attr('user_id');
        var adminId = $('.create_chat').attr('admin_id');
        $('#content-messages').attr('admin_id', adminId);
        $('#content-messages').attr('user_id', userId);
        /*$.ajax({
         url: '/welcome/supportMessage',
         data: {userId: userId, adminId: adminId},
         type: 'Post',
         success: function (data) {
         var jsonData = $.parseJSON(data);
         var html = '<div id="message_count" data-count=' + jsonData.count_messages + '>Count Messages' + ' ' + jsonData.count_messages + '</div>';
         if (jsonData.messages.length > 0) {
         
         $.each(jsonData.messages, function (key, value) {
         
         if (value.from_user == userId) {
         
         html += '<div class="media msg ">' +
         '<div class="media-body">' +
         '<small class="pull-right time"><i class="fa fa-clock-o"></i>' + value.date + '</small>' +
         '<h5 class="to_user ">' + value.name + ' ' + value.lname + '</h5>' +
         '<small class="col-lg-10">' + value.text + '</small>' +
         '</div>' +
         '</div>';
         }
         if (value.from_user == current_user) {
         html += '<div class="media msg ">' +
         '<div class="media-body">' +
         '<small class="pull-right time"><i class="fa fa-clock-o"></i>' + value.date + '</small>' +
         '<h5 class="media-heading">' + value.name + ' ' + value.lname + '</h5>' +
         '<small class="col-lg-10">' + value.text + '</small>' +
         '</div>' +
         '</div>';
         }
         })
         }
         
         $('.msg-wrap').html(html);
         mydiv.scrollTop(mydiv.prop('scrollHeight'));
         }
         
         });*/
    });
});