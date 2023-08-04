<?php

class ChatUser
{
    private $user_id;
    private $user_email;
    private $user_name;
    private $user_password;
    private $user_profile;
    private $user_status;
    private $user_created_on;
    private $user_verification_code;
    private $user_login_status;
    public $connect;

    public function __construct()
    {
        require_once("DatabaseConnection.php");

        $database = new DatabaseConnection();

        $this->connect = $database->connect();
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }

    public function getUserName()
    {
        return $this->user_name;
    }

    public function setUserEmail($user_email)
    {
        $this->user_email = $user_email;
    }

    public function getUserEmail()
    {
        return $this->user_email;
    }

    public function setUserPassword($user_password)
    {
        $this->user_password = $user_password;
    }

    public function getUserPassword()
    {
        return $this->user_password;
    }

    public function setUserProfile($user_profile)
    {
        $this->user_profile = $user_profile;
    }

    public function getUserProfile()
    {
        return $this->user_profile;
    }

    public function setUserStatus($user_status)
    {
        $this->user_status = $user_status;
    }

    public function getUserStatus()
    {
        return $this->user_status;
    }

    public function setUserCreatedOn($user_created_on)
    {
        $this->user_created_on = $user_created_on;
    }

    public function getUserCreatedOn()
    {
        return $this->user_created_on;
    }

    public function setUserVerificationCode($user_verification_code)
    {
        $this->user_verification_code = $user_verification_code;
    }

    public function getUserVerificationCode()
    {
        return $this->user_verification_code;
    }

    public function setUserLoginStatus($user_login_status)
    {
        $this->user_login_status = $user_login_status;
    }

    public function getUserLoginStatus()
    {
        return $this->user_login_status;
    }

    public function createAvatar($character)
    {
        $path = "images/" . time() . ".png";
        $image = imagecreate(200,200);
        $red = rand(0,255);
        $green = rand(0,255);
        $blue = rand(0,255);
        imagecolorallocate($image, $red, $green, $blue);
        $textcolor = imagecolorallocate($image, 255, 255, 255);

        $font = dirname(__FILE__) . '/font/Arial.ttf';

        imagettftext($image, 100, 0, 55, 150, $textcolor, $font, $character);
        imagepng($image, $path);
        imagedestroy($image);
        return $path;
    }


    public function getUserDataByEmail()
    {
        $query = "
                SELECT * FROM chat_user_table
                WHERE user_email = :user_email
                ";

        $statement = $this->connect->prepare($query);

        $statement->bindParam(':user_email', $this->user_email);

        if($statement->execute())
        {
            $user_data = $statement->fetch(PDO::FETCH_ASSOC);
        }

        return $user_data;
    }

    public function saveData(){
        $query = "
                INSERT INTO chat_user_table 
                (user_name, user_email, user_password, user_profile, 
                user_status, user_created_on, user_verification_code)
                VALUES 
                (:user_name, :user_email, :user_password, :user_profile, 
                :user_status, :user_created_on, :user_verification_code)
                ";
        $params = [
            ':user_name'=> $this->user_name,
            ':user_email'=> $this->user_email,
            ':user_password'=> $this->user_password,
            ':user_profile'=> $this->user_profile,
            ':user_status'=> $this->user_status,
            ':user_created_on'=> $this->user_created_on,
            ':user_verification_code'=> $this->user_verification_code
        ];
        $statement = $this->connect->prepare($query);

        foreach ($params as $key => $value) {
            $statement->bindParam($key, $value);
        }

        if($statement->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}


?>