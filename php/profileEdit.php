<?php
session_start();
require_once("connection.php");

if (!isset($_POST["update"])){
    die();
}

$db = new Database();

$id = $_SESSION['userID'];
$username = trim($_POST["username"]);
$email = trim($_POST["email"]);
$pwd = trim($_POST["aPassword"]);
$newPwd = trim($_POST["newPassword"]);
$birthdate = trim($_POST["birthday"]);



if (($username != $pwd) && (strlen($username) > 6 ) && (strlen($pwd) > 6)){
    $hash = password_hash($newPwd, PASSWORD_DEFAULT);

    $pwd = "SELECT password FROM users WHERE userID = $id";
    $res = $db -> mysqli -> query($pwd);
    $row = $res -> fetch_assoc();

    if(password_verify($_POST['aPassword'],$row['password'])){


        if(empty($username) || empty($email) || empty($pwd)){
            var_dump("A felhasználónév, email, aktuális jelszó nem lehet üresen!");
        }else if(!empty($newPwd) && !empty($birthdate)){
            $sql = " UPDATE users
               SET username= '$username', password='$hash', email = '$email',birthdate='$birthdate'
               WHERE userID=$id ";
                var_dump($sql);

            $db -> mysqli -> query($sql);
        }else if(!empty($newPwd)){
            $sql = " UPDATE users
               SET username= '$username', password='$hash', email = '$email'
               WHERE userID=$id ";
            var_dump($sql);

            $db -> mysqli -> query($sql);
        }
        else if(!empty($birthdate)){
            $sql = " UPDATE users
               SET username= '$username', birthdate='$birthdate', email = '$email'
               WHERE userID=$id ";
            var_dump($sql);
            $db -> mysqli -> query($sql);
        }else{
            $sql = " UPDATE users
               SET username= '$username', email = '$email'
               WHERE userID=$id ";
            var_dump($sql);
            $db -> mysqli -> query($sql);
        }






        if ($db -> mysqli -> connect_errno == 0){
            $_SESSION['update'] = "Sikeres módosítás!";
            header("Location: ../profile.php");
        } else {
            $_SESSION['update'] = "A jelenlegi jelszó nem megfelelő";
        }
    }else{
        $_SESSION['update'] = "A módosítás sikertelen!";
        echo ("A módosítás sikertelen!");
    }
}
header("Location: ../profile.php");

?>