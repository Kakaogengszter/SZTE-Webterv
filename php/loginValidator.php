<?php
session_start();
require_once('connection.php');

$db = new Database();
$error = [];

if (isset($_POST['login'])){
    $userName = $_POST['username'];
    $pwd = $_POST['password'];
    $res = $db -> login($userName);

    if($userName === "" || $pwd === ""){
        $error[] = "Minden mezőt tölts ki!";
        header("Location: ../login.php");
    }else if ($res) {

        if($res -> num_rows == 1){
            //belépett
            $row = $res -> fetch_row();

            if (password_verify($pwd, $row[3]))
            {
                $_SESSION['userID'] = $row[0];
                header("Location: ../profile.php");
            }else {
                $error[] = "Helytelen jelszó!";
                header("Location: ../login.php");
            }
        }else{
            $error[] = "Helytelen felhasználónév!";
            header("Location: ../login.php");
        }
    }
    $_SESSION["errors"] = $error;

}
echo "</body>";
?>