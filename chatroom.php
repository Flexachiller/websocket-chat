<?php 
session_start(); 
if(!isset($_SESSION['user_data']))
{
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
</head>
<body>
    <?php
        $user_login_id = '';

        foreach($_SESSION['user_data'] as $key => $value)
        {
            $user_login_id = $value['id'];
    ?>
    <input type="hidden" name="user_login_id" value="<?=$user_login_id;?>" id="login_user_id">
    <div>
        <img src="<?= $value['profile']; ?>" width="150">
        <h3><?= $value['name'];?></h3>
        <a href="profile.php">Edit</a>
        <input type="button" name="logout" value="Logout" id="logout">
    </div>
    <?php
        }
    ?>
    <script>
        $(document).ready(function(){
            var conn = new WebSocket('ws://localhost:8080');
            conn.onopen = function(e) {
                console.log("Connection established!");
            };

            conn.onmessage = function(e) {
                console.log(e.data);
            };
            $('#logout').click(function(){

            user_id = $('#login_user_id').val();

            $.ajax({
                url:"action.php",
                method:"POST",
                data:{user_id:user_id, action:'leave'},
                success:function(data)
                {
                var response = JSON.parse(data);

                if(response.status == 1)
                {
                    conn.close();
                    location = 'index.php';
                }
            }
        })
    });
})
    </script>
</body>
</html>