<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8' />
        <link href="{{URL::asset('css/fullcalendar.min.css')}}" rel='stylesheet' />
        <link href="{{URL::asset('css/fullcalendar.print.min.css')}}" rel='stylesheet' media='print' />

        <script src="{{URL::asset('js/jquery.min.js')}}"></script>
        <script src="{{URL::asset('js/moment.min.js')}}"></script>
        <script src="{{URL::asset('js/fullcalendar.js')}}"></script>
        <script src="{{URL::asset('js/calendar.js')}}"></script>
        <style>

            body {
                margin: 40px 10px;
                padding: 0;
                font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
                font-size: 14px;
            }

            #calendar {
                max-width: 900px;
                margin: 0 auto;
            }

        </style>
    </head>
    <body>
        <div id='calendar'></div>
    </body>
</html>
