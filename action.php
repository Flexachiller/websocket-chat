<?php
session_start();

if(isset($_POST['action']) && $_POST['action'] == 'leave')
{
    require "database/ChatUser.php";

    $user = new ChatUser();
    
    $user->setUserId($_POST['user_id']);

    $user->setUserLoginStatus('Logout');

    if($user->updateUserLoginData())
    {
        unset($_SESSION['user_data']);

        session_destroy();
        
        echo json_encode(['status'=>1]);
    }
}