<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exceptions;

require 'vendor/autoload.php';


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_setup_errors', 1);

$errors = '';

$success_message = '';

if(isset($_POST['register']))
{ 
    if(!empty(trim($_POST['user_name']))&& 
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

        $user->setUserCreatedOn(date('Y.m.d H:i:s'));

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
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'ssl://smtp.yandex.ru'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'krishtalev2017r';
                $mail->Password = 'ksixcjzxwhsydunq';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;
                //
                $mail->setFrom('krishtalev2017r@yandex.ru', 'flexachiller');
                $mail->addAddress($user->getUserEmail());
                $mail->isHTML(true);
                $mail->Subject = 'Registration Verification for Chat';
                $mail->Body = '
                            <p>Thank you for registration for Chat app</p>
                            <p>This is a verification email.  Please, click the link to verify your email address.</p>
                            <p><a href="http://localhost:8080/websocket-chat/verify.php?code=' . $user->getUserVerificationCode() . '">Click to Verify</a></p>
                            ';
                $mail->send();

                $success_message = 'Verification code sent to ' . $user->getUserEmail() . 'Please, verify it before login';
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
            $errors = '';
        }
        elseif($success_message !== '')
        {
            echo $success_message . "<br><br>";
            $success_message = '';
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