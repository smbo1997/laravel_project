$(document).ready(function () {
    $('#calendar').fullCalendar({
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: function (start, end, timezone, callback) {
            $.ajax({
                url: '/calendardata',
                success: function (data) {
                    var jsonData = $.parseJSON(data);
                    var events = [];
                    $.each(jsonData.userdata, function (key, value) {
                        if (value.birthday !== null) {
                            events.push({
                                title: value.first_name + ' ' + value.last_name,
                                start: value.birthday
                                        //end:formatRange(value.birthday, 'MMMM D YYYY')
                            });
                        }
                    });

                    console.log(events);
                    callback(events);
                }
            });
        }

//                [
//            {
//                title: 'All Day Event',
//                start: '2016-12-01'
//            }
//        ]
    });
});

