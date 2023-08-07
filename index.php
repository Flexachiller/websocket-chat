<?php

    session_start();

    $errors = '';

    if(isset($_SESSION['user_data']))
    {
        header('Location: chatroom.php');
    }

    if(isset($_POST['login']))
    {
        require_once 'database/ChatUser.php';

        $user = new Chatuser();

        $user->setUserEmail($_POST['user_email']);

        $user_data = $user->getUserDataByEmail();

        if(is_array($user_data) && count($user_data) > 0)
        {
            if($user_data['user_status'] === 'Enable')
            {
                if($user_data['user_password'] === $_POST['user_password'])
                {
                    $user->setUserId($user_data['user_id']);
                    $user->setUserLoginStatus('Login');

                    if($user->updateUserLoginData())
                    {
                        $_SESSION['user_data'][$user_data['user_id']] = [
                            'id' => $user_data['user_id'],
                            'name' => $user_data['user_name'],
                            'profile' => $user_data['user_profile']
                        ];

                        header('Location: chatroom.php');
                    }
                }
                else
                {
                    $errors = 'Wrong password';
                }
            }
            else
            {
                $errors = 'Please verify your Email address';
            }
        }
        else
        {
            $errors = 'Wrong Email address';
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

            if ($errors !== '')
            {
                echo '
                    <div>
                    '. $errors .'
                    </div>
                    ';
            }
        ?>
    </div>
    <div>
        <div>Login</div>
        <div>
            <form action="" method="post">
                <div>
                    <label>Enter your email</label>
                    <input type="text" name="user_email">
                </div>
                <div>
                    <label>Enter your password</label>
                    <input type="password" name="user_password">
                </div>
                <div>
                    <input type="submit" name='login' value="Login">
                </div>
            </form>
        </div>
    </div>
</body>
</html>