<?php

session_start();
require_once('connection.php');

class Message{

    private $kitol;
    private $kinek;


    public function __construct($kitol, $kinek)
    {
        $this->kitol = $kitol;
        $this->kinek = $kinek;
    }


    public function getKitol()
    {
        return $this->kitol;
    }


    public function setKitol($kitol)
    {
        $this->kitol = $kitol;
    }


    public function getKinek()
    {
        return $this->kinek;
    }


    public function setKinek($kinek)
    {
        $this->kinek = $kinek;
    }




    public function kitol(){

        $db = new Database();

        $kitolID = $this->getKinek();


        $dataListTable = $db->run_select_query_to_array("SELECT username FROM users INNER JOIN inbox ON inbox.kitolID = users.userID WHERE inbox.kinekID = $kitolID");


        $userArray = array();
        foreach ($dataListTable as $DLT) {
            $userData = $DLT["username"];
            $userArray[] = $userData;

        }

        return $userArray;

    }

    public function messageContentArray() {
        $db = new Database();

        $kinekID = $this->getKinek();

        $messageDataList = $db -> run_select_query_to_array("SELECT message from inbox where kinekID = $kinekID");

        $messageConent = array();
        foreach ($messageDataList as $DLT) {
            $messageData = $DLT["message"];
            $messageConent[] = $messageData;

        }

        return $messageConent;
    }


    public function egyesites(){

        $messageConent = $this->messageContentArray();
        $userArray = $this->kitol();



        $length = count($messageConent);

        $messageWithUsername = array();
        for ($i = 0; $i < $length;$i++){
            $messageWithUsername[] = [$userArray[$i] => $messageConent[$i]];
        }


        return $messageWithUsername;

    }


}
