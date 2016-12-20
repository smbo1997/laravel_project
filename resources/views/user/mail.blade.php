<!DOCTYPE html>
<html>
    <head>
        <style>
            .media-heading
            {
                color:#003bb3;
                font-weight: 700;
            }


            .msg-date
            {
                background: none;
                text-align: center;
                color:#aaa;
                border:none;
                box-shadow: none;
                border-bottom: 1px solid #ddd;
            }
            .msg
            {
                padding:5px;
                /*border-bottom:1px solid #ddd;*/
                margin:0;
            }
            .msg-wrap
            {
                width: 400px;
                padding:10px;
                max-height: 400px;
                overflow: auto;
                background-color: #c1bdba; ;
            }

            .time
            {
                color:#bfbfbf;
            }

            .send-wrap
            {
                border-top: 1px solid #eee;
                border-bottom: 1px solid #eee;
                padding:10px;
            }
            .media-body {
                overflow: hidden;
                zoom: 1;
            }
            .pull-right {
                float: right;
            }
            .to_user{
                color: #00FF00;
                font-weight: 700;
                margin-top: 0;
                margin-bottom: 5px;
            }
        </style>
    </head>
    <body>
        <div class="msg-wrap">
            <?php
            if (!empty($getMessages)) {
                foreach ($getMessages as $key => $value) {
                    if ($to_user_id == $value->from_user) {
                        ?>
                        <div class="media msg ">
                            <div class="media-body">
                                <small class="pull-right time"><?php echo $value->created_at; ?></small>
                                <h5 class="to_user "><?php echo $value->first_name . ' ' . $value->last_name; ?></h5>
                                <small class="col-lg-10"><?php echo $value->content; ?></small>
                            </div>
                        </div>
                    <?php } if ($currentuser == $value->from_user) { ?>
                        <div class="media msg ">                                    
                            <div class="media-body">
                                <small class="pull-right time"><?php echo $value->created_at; ?></small>
                                <h5 class="media-heading"><?php echo $value->first_name . ' ' . $value->last_name; ?></h5>
                                <small class="col-lg-10"><?php echo $value->content; ?></small>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
    </body>
</html>