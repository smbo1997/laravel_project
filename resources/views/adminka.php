<headers>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</headers>


<div class="container">
<br>
<br>
<br>
    <?php foreach($users as $user){  ?>

        <table class='table  table-bordered table-hover table-inverse'>
            <tr scope="row" >
                 <th class="first_name" contenteditable="" id=<?php echo $user->id ?>><?php echo $user->first_name ?></th>
                 <th class="last_name" contenteditable id=<?php echo $user->id ?>><?php echo $user->last_name?></th>
                 <th class="last_name" id=<?php echo $user->id ?>>
                     <button  class="btn btn-info btn-lg">
                          <span class="glyphicon glyphicon-pencil"></span> Update
                     </button>
                 </th>
                <th class="last_name" id=<?php echo $user->id ?>>
                    <button class="btn btn-info btn-lg">
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </th>
                <th class="last_name" id=<?php echo $user->id ?>>
                    <button class="btn btn-info btn-lg">
                        <span class="glyphicon glyphicon-ban-circle"></span> Block
                    </button>
                </th>
            </tr>
        </table>
    <?php } ?>
</div>
<style>
    th{
        width:20%;
    }
</style>
