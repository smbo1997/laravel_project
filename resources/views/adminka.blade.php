<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        th {
            width: 20%;
        }
    </style>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href=" https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">



</head>
<body>
<br>
<br>
<div class="container">
    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Name</th>
            <th>Last Name</th>
            <th>Update</th>
            <th>Delete</th>
            <th>View</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Name</th>
            <th>Last Name</th>
            <th>Update</th>
            <th>Delete</th>
            <th>View</th>
        </tr>
        </tfoot>
        <tbody>


        @foreach($users as $user)

            <tr scope="row">
            <th class="first_name_{{ $user->id }}" contenteditable="">{{$user->first_name }}</th>
            <th class="last_name_{{$user->id }}" contenteditable>{{$user->last_name}}</th>
            <th id={{$user->id }}>
                <button class="btn btn-info btn-lg update_user" id={{$user->id }}>
                    <span class="glyphicon glyphicon-pencil"></span> Update
                </button>
            </th>
            <th id={{ $user->id }}>
                <button class="btn btn-info btn-lg delete_user" id={{$user->id }}>
                    <span class="glyphicon glyphicon-trash "></span> Delete
                </button>
            </th>
            <th  id={{$user->id }}>
                <button class="btn btn-info btn-lg" id={{$user->id }}>
                    <span class="glyphicon glyphicon-eye-open"></span>  View
                </button>
            </th>
        </tr>
        @endforeach

        </tbody>
    </table>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    {{--datatable--}}


<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
        } );

        $(document).on("click", ".update_user", function () {
            var id_user = $(this).attr('id');
            var first_name = $('.first_name_' + id_user).html();
            var last_name = $('.last_name_' + id_user).html();
            $.ajax({
                url: '/update_user',
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    id_user: id_user,
                    first_name: first_name,
                    last_name: last_name,
                },
                success: function (data) {
//                    location.reload();
                }
            });
        });


        $(document).on("click", ".delete_user", function () {
            var id_user = $(this).attr('id');
            alert(id_user)
            $.ajax({
                url: '/delete_user',
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    id_user: id_user,
                },
                success: function (data) {
                    location.reload();
                }
            });
        });



    } );
</script>
</body>
</html>