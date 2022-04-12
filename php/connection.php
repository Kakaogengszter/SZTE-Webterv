<?php


class Database{
    private $host;
    private $user;
    private $pwd;
    private $db;
    private $port;

    public $mysqli;


    public function __construct(){

        $this->host = "localhost";
        $this->user = "root";
        $this->pwd = "";
        $this->db = "szte-webterv";
        $this->port = "3306";

        $this->mysqli = new mysqli($this->host,$this->user,$this->pwd,$this->db,$this->port);

    }


    public function insertUsersToDB($username, $email, $password, $birthdate){
        $db = new Database();

        $sql = "INSERT INTO users (username,email,password,birthdate,picture) VALUES ('$username','$email','$password','$birthdate','default.jpg')";

        $db -> mysqli -> query($sql);
    }

    public function login($username){
        $db = new Database();

        $sql = "SELECT * FROM users WHERE username = '$username' ";
        return $db -> mysqli -> query($sql);
    }


    public function profilePicsUpdate($userID,$imgname){
        $db = new Database();

        $sql_update = "UPDATE users SET picture = '$imgname' WHERE userid = $userID";

        return $db -> mysqli -> query($sql_update);

    }

    public function deleteProfilePicWhenModified(){
        $db = new Database();

        $id = $_SESSION['userID'];

        $sqlselect = "SELECT * FROM users WHERE id = $id";
        $resSelect = $db -> mysqli -> query($sqlselect);

        $row = $resSelect -> fetch_assoc();

        $currentProfilePicture = $row["picture"];

        $fileName = "../profilePics/$currentProfilePicture";

        if($currentProfilePicture != "default.jpg"){
            unlink($fileName);
        }
    }

    public function get_user_id(string $username): int
    {

        $sql_get_addressee_id = "SELECT id FROM users where username = '$username'";

        $res = $this->mysqli ->query($sql_get_addressee_id);
        $row = $res -> fetch_assoc();

        if(!is_null($row)){
            return (int)$row["id"];
        }

        return 0;

    }

    public function insertMessageToDB(int $userID, int $addressee_ID, string $content)
    {
        $sql_add = "INSERT INTO inbox (kitolID,kinekID,message) values ($userID,$addressee_ID,'$content')";
        $this->mysqli -> query($sql_add);
    }

}