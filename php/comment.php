<?php
require_once("connection.php");


class comment{

    private $username;
    private $comment;


    public function __construct($username, $comment)
    {
        $this->username = $username;
        $this->comment = $comment;
    }



    public function getUsername()
    {
        return $this->username;
    }


    public function setUsername($username): void
    {
        $this->username = $username;
    }


    public function getComment()
    {
        return $this->comment;
    }


    public function setComment($comment): void
    {
        $this->comment = $comment;
    }




}
