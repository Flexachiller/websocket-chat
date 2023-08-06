<?php

    session_start();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <?php
            if(isset($_SESSION['success_message']))
            {
                echo '
                    <div>
                    '. $_SESSION['success_message'] .'
                    </div>
                    ';
                unset($_SESSION['success_message']);
            }
        ?>
    </div>
</body>
</html>