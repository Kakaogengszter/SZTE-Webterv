<?php
session_start();
require_once("connection.php");


$db = new Database();
$errors = [];

$id = $_SESSION["admin"] ?? $_SESSION["userID"];

$username = trim($_POST["username"]);
$email = trim($_POST["email"]);
$pwd = trim($_POST["aPassword"]);
$newPwd = trim($_POST["newPassword"]);
$birthdate = trim($_POST["birthday"]);


if(($username == $newPwd)){
    $errors[] = "A felhasználónév és a jelszó nem lehet ugyanaz!";
}

if(strlen($username) < 6){
    $errors[] = "A felhasználónévnek legalább 6 karakternek kell lennie!";
}

if(strlen($newPwd) < 6 && !empty($newPwd)){
    $errors[] = "Az új jelszónak legalább 6 karakternek kell lennie!";
}

if(empty($pwd)){
    $errors[] = "Kérem írja be az aktuális jelszavát!";
}

if (count($errors) === 0){
    $hash = password_hash($newPwd, PASSWORD_DEFAULT);

    $pwd = "SELECT password FROM users WHERE id = $id";
    $res = $db -> mysqli -> query($pwd);
    $row = $res -> fetch_assoc();

    if(password_verify($_POST['aPassword'],$row['password'])){


      if(!empty($newPwd) && !empty($birthdate)){
            $sql = " UPDATE users
               SET username= '$username', password='$hash', email = '$email',birthdate='$birthdate'
               WHERE id=$id ";

            $db -> mysqli -> query($sql);


        }else if(!empty($newPwd)){
            $sql = " UPDATE users
               SET username= '$username', password='$hash', email = '$email'
               WHERE id=$id ";

            $db -> mysqli -> query($sql);

        }else if(!empty($birthdate)){
            $sql = " UPDATE users
               SET username= '$username', birthdate='$birthdate', email = '$email'
               WHERE id=$id ";
            $db -> mysqli -> query($sql);

        }else{
            $sql = " UPDATE users
               SET username= '$username', email = '$email'
               WHERE id=$id ";
            $db -> mysqli -> query($sql);

        }

        if ($db -> mysqli -> connect_errno == 0){
            header("Location: ../profile.php?siker");
        }

    }
    if(isset($_POST["delete"])){
        $sql_delete_profile = "DELETE FROM users WHERE id = $id";
        $db -> mysqli -> query($sql_delete_profile);
        session_destroy();
        header("Location: ../index.php");
    }

}else{
    header("LOCATION: ../profile.php");
    $_SESSION["errors"] = $errors;
}



?>