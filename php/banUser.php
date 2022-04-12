<?php

session_start();

require_once("connection.php");

if(!isset($_POST["delete_comment"])){
    header("location: ../recipes.php");
}

$db = new Database();
$errors = [];

$recipe_name= $_SESSION["recipe_name"];

$username = trim($_POST["username"]);


if(empty($username)){
    $errors[] = "Írj be valami nevet!";
}

if(count($errors) == 0){
    $username_id = $db -> get_user_id($username);
    if(empty($username_id)){
        $errors[] = "Nincs meg a felhasználó!";
    }
}

if(count($errors) == 0){

    $sql_delete_comments = "DELETE FROM comments WHERE user_id = $username_id";
    $db -> mysqli -> query($sql_delete_comments);
    header("location: ../recipe.php?name=$recipe_name&siker");
}else{
    header("location: ../recipe.php?name=$recipe_name");
}

$_SESSION["ban_error"] = $errors;



