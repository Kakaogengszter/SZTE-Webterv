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
        $this->db = "recipes";
        $this->port = "3306";

        $this->mysqli = new mysqli($this->host,$this->user,$this->pwd,$this->db,$this->port);

    }

    public function run_select_query($sql){

        $array = array();
        $res = mysqli_query($this->mysqli, $sql) or die ('Failure in sql select!');
        while($row = mysqli_fetch_assoc($res)){

            $array[] = $row;

        }
        return $array;

    }

    public function insertUsersToDB($username, $email, $password, $birthdate){
        $db = new Database();

        $sql = "INSERT INTO users (username,email,password,birthdate,picture) VALUES ('$username','$email','$password','$birthdate','default.jpg')";
        var_dump($sql);

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
        var_dump($sql_update);

        return $db -> mysqli -> query($sql_update);

    }

    public function deleteProfilePicWhenModifyed(){
        $db = new Database();

        $id = $_SESSION['userID'];

        $sqlselect = "SELECT * FROM users WHERE userID = $id";
        $resSelect = $db -> mysqli -> query($sqlselect);

        $row = $resSelect -> fetch_assoc();

        $currentProfilePicture = $row["picture"];

        $fileName = "../profilePics/$currentProfilePicture";

        if($currentProfilePicture != "default.jpg"){
            unlink($fileName);
        }
    }

}