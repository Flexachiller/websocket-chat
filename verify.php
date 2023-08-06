<?php

    $errors = '';
    session_start();

    if(isset($_GET['code'])){
        require_once 'database/Chatuser.php';
        $user = new ChatUser();
        $user->setUserVerificationCode($_GET['code']);
        if($user->isValidEmailVerificationCode())
        {
            $user->setUserStatus('Enable');
            if($user->enableUserAccount())
            {
                $_SESSION['success_message'] = "Your email verified";
                header('Location: index.php');
            }
            else
            {
                $errors = 'Something went wrong, try again';
            }
        }
        else
        {
            $errors = 'Something went wrong, try again';
        }
    }

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>