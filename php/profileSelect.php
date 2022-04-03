<?php

session_start();
require_once('connection.php');


class User{
    private $ID;
    private $username;
    private $email;
    private $password;
    private $birthdate;
    private $picture;


    public function __construct($ID, $username, $email, $password, $birthdate, $picture)
    {
        $this->ID = $ID;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->birthdate = $birthdate;
        $this->picture = $picture;
    }


    public function getID()
    {
        return $this->ID;
    }


    public function setID($ID)
    {
        $this->ID = $ID;
    }


    public function getUsername()
    {
        return $this->username;
    }


    public function setUsername($username)
    {
        $this->username = $username;
    }


    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function getPassword()
    {
        return $this->password;
    }


    public function setPassword($password)
    {
        $this->password = $password;
    }


    public function getBirthdate()
    {
        return $this->birthdate;
    }


    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }


    public function getPicture()
    {
        return $this->picture;
    }


    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

}

?>
