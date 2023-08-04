<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_setup_errors', 1);

$errors = '';

$success_message = '';

if(isset($_POST['register']) && 
    !empty(trim($_POST['user_name']))&& 
    !empty(trim($_POST['user_email']))&& 
    !empty(trim($_POST['user_password'])))
{
    session_start();

    if(isset($_SESSION['user_data']))
    {
        header('Location: chatroom.php');
    }

    require_once('database/ChatUser.php');

    $user = new ChatUser();

    $user->setUserName($_POST['user_name']);

    $user->setUserEmail($_POST['user_email']);

    $user->setUserPassword($_POST['user_password']);

    $user->setUserProfile($user->createAvatar(strtoupper($_POST['user_name'][0])));

    $user->setUserStatus('Disabled');

    $user->setUserCreatedOn(date('d.m.Y H:i'));

    $user->setUserVerificationCode(md5(uniqid()));

    $user_data = $user->getUserDataByEmail();

    if(is_array($user_data) && count($user_data) > 0)
    {
        $errors = 'This Email is already registered';
    }
    else
    {
        if($user->saveData())
        {
            $success_message = 'Registration completed';
        }
        else
        {
            $errors = 'Something went wrong';
        }
    }
}
else
{
    $errors = 'Please, enter every field';
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
    <?php
        if($errors !== '')
        {
            echo $errors . "<br><br>";
        }
        elseif($success_message !== '')
        {
            echo $success_message . "<br><br>";
        }   
    ?>

    <form action="" method="post">
        <label>Enter your name</label>
        <input type="text" name="user_name">
        <br><br>

        <label>Enter your Email</label>
        <input type="email" name="user_email">
        <br><br>

        <label>Enter your password</label>
        <input type="password" name="user_password">
        <br><br>

        <input type="submit" name="register" value="Register">
    </form>
</body>
</html>