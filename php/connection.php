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
    
    public function insertCommentToDB($userID,$recipeID,$comment){
        $db = new Database();
        $sql = "INSERT INTO comments (user_id,recipe_id,comment) VALUES ('$userID','$recipeID','$comment')";
        $db->mysqli->query($sql);
    }
    public function deleteComment($commentid){
        $db = new Database();
        $sql ="DELETE FROM comments WHERE id = '$commentid'";
        $db->mysqli->query($sql);
    }

    public function login($username){
        $db = new Database();

        $sql = "SELECT * FROM users WHERE username = '$username' ";
        return $db -> mysqli -> query($sql);
    }


    public function profilePicsUpdate($userID,$imgname){
        $db = new Database();

        $sql_update = "UPDATE users SET picture = '$imgname' WHERE id = $userID";

        return $db -> mysqli -> query($sql_update);

    }

}