<?php

session_start();
require_once('connection.php');

class Message{

    private $kitol;
    private $kinek;
    private $content;
    private $kitolUsername;
    private $kinekUsername;


    public function __construct($kitol, $kinek, $content)
    {
        $this->kitol = $kitol;
        $this->kinek = $kinek;
        $this->content = $content;
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


    public function getContent()
    {
        return $this->content;
    }


    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getKitolUsername()
    {
        return $this->kitolUsername;
    }

    /**
     * @param mixed $kitolUsername
     */
    public function setKitolUsername($kitolUsername)
    {
        $this->kitolUsername = $kitolUsername;
    }

    /**
     * @return mixed
     */
    public function getKinekUsername()
    {
        return $this->kinekUsername;
    }

    /**
     * @param mixed $kinekUsername
     */
    public function setKinekUsername($kinekUsername)
    {
        $this->kinekUsername = $kinekUsername;
    }




    public function kitolUsername(){
        $db = new Database();

        $userID = $this->getKitol();


        $dataListTable = $db->run_select_query("SELECT username FROM users INNER JOIN inbox ON inbox.kitolID = users.userID WHERE users.userID =$userID");


        $messageArray = array();
        foreach ($dataListTable as $DLT) {
            $userData = $DLT["username"];
            $messageArray[] = $userData;
        }

        $this->setKitol($messageArray[0]);

        return $messageArray;

    }



    public function kinekUsername(){



    }


}
