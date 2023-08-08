<?php session_start();

if(!isset($_SESSION['user_data']))
{
    header('Location: index.php');
}

require "database/ChatUser.php";
$user = new ChatUser();

$user_id = '';

foreach($_SESSION['user_data'] as $key => $value)
{
    $user_id = $value['id'];
}

$user->setUserId($user_id);

$user_data = $user->getUserDataById();

$message = '';

if(isset($_POST['edit']))
{
    $user_profile = $_POST['hidden_user_profile'];

    if($_FILES['user_profile']['name'] !== '')
    {
        $user_profile = $user->uploadImage($_FILES['user_profile']);
        $_SESSION['user_data'][$user_id]['profile'] = $user_profile;
    }

    $user->setUserName($_POST['user_name']);
    $user->setUserEmail($_POST['user_email']);
    $user->setUserPassword($_POST['user_password']);
    $user->setUserProfile($user_profile);
    $user->setUserId($user_id);

    if($user->updateData())
    {
        $message = '<div>Profile detail updated</div>';
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
    <?= $message;?>
    <div>Profile</div>
    <div><a href="chatroom.php">Go to chat</a></div>
    <div>
        <form method="post" enctype="multipart/form-data">
            <div>
                <label>Name</label>
                <input type="text" name="user_name" value="<?= $user_data['user_name'];?>">
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="user_email" value="<?= $user_data['user_email'];?>">
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="user_password" value="<?= $user_data['user_password'];?>">
            </div>
            <div>
                <label>Profile</label>
                <input type="file" name="user_profile">
                <br>
                <img src="<?= $user_data['user_profile'];?>" width="100">
                <input type="hidden" name="hidden_user_profile" value="<?= $user_data['user_profile'];?>">
            </div>
            <div>
                <input type="submit" name="edit" value="Edit">
            </div>

        </form>
    </div>
</body>
</html>