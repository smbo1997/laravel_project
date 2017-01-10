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
<a href="admin_logout" class="btn btn-primary">Log Out</a>
<div class="container">
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Add user</button><br/><br/>
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
            <th>View Profil</th>
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
                <a href="{{url('user_view/'.$user->id)}}"   class="btn btn-info btn-lg" id={{$user->id }}>
                    <span class="glyphicon glyphicon-eye-open"></span>  View Profil
                </a>
            </th>
        </tr>
        @endforeach

        </tbody>
    </table>


    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add User</h4>
                </div>
                <div class="modal-body" >
                    {{--First Name <br>--}}
                    <input type="test" placeholder="first name" class="first_name" required >
                    <br>
                    <br>
                    <input type="test" placeholder="last name"  class="last_name" required >
                    <br>
                    <br>
                    <input type="email" placeholder="email" class="email" required >
                    <br>
                    <br>
                    <input type="date" class="date" class="date" required >
                    <br>
                    <br>

                    <select id="myselect" class="form-control" >
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                    </select>
                    <br>
                    <input type="password" placeholder="password" required  class="password">
                    <br>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default add_user" >Add User</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    {{--datatable--}}


<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
//        $('#example').DataTable( {
//            "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
//        } );

//        $(document).ready(function () {
            $('#example').DataTable();
//        });
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
                }
            });
        });


        $(document).on("click", ".delete_user", function () {
            var id_user = $(this).attr('id');
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


        $(document).on("click", ".add_user", function () {
            var last_name = $('.last_name').val();
            var first_name = $('.first_name').val();
            var email = $('.email').val();
            var date = $('.date').val();
            var gender = $( "#myselect option:selected" ).text();
            var password = $('.password').val();
            $.ajax({
                url: '/add_user_admin',
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    last_name: last_name,
                    first_name: first_name,
                    email: email,
                    date: date,
                    gender: gender,
                    password: password,
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