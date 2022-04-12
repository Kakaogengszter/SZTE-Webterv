<?php
include "php/includes.php";
require_once("php/messagesSelect.php");

$dataBase = new Database();


$id = $_SESSION["userID"];


$dataListTable = $dataBase-> mysqli -> query("SELECT * FROM inbox WHERE sender_id = $id");
$messageArray = array();
foreach ($dataListTable as $DLT) {
    $messageData = new Message($DLT["sender_id"], $DLT["receiver_id"], $DLT["message"]);
    $messageArray[] = $messageData;

}

if(!empty($messageData)){
    $kuldoUsername = $messageData -> kitol();
    $messageContent = $messageData -> messageContentArray();

    $hossz = count($messageContent);
    $message = $messageData -> egyesites();
}

if(isset($_SESSION["error"])){
    $error = $_SESSION["error"];
}else{
    $error[] = null;
}



?>




<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Főoldal</title>
    <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/app.js" defer></script>
</head>

<body>

<?php

navigationGenerate("profile");

?>

<main>

    <h2>Üzenetek</h2>
    <table class="top-uploaders-table">
        <tr>
            <th id="kitol">Kitől</th>
            <th id="kinek">Üzenet</th>
        </tr>
            <?php
            if(!empty($messageData)){
            for($i = 0;$i < $hossz;$i++)
            {
            ?>

        <tr>
            <td><?php echo $kuldoUsername[$i] ?></td>
            <td><?php echo $message[$i][$kuldoUsername[$i]] ?></td>

        </tr>

        <?php
        }
            }else{
                ?>
        <td>Még senki sem küldött üzenetet :(</td>
        <td>Majd itt lesz az üzenet szövege</td>
        <?php
            }
        ?>
    </table>


    <?php
    if (isset($_GET["siker"])) {
        echo "<div class='success'>Megvan a felhasználó!</div>";
    }

    if (count($error) > 0 && isset($_SESSION["error"])) {
        echo "<div class='errors'>";

        echo $error[0];

        echo "</div>";
    }
    unset($_SESSION["error"]);
    ?>

<div align="center">
    <form action="php/messageSend.php" method="post" autocomplete="off">
        <label class="required-label" for="cimzett">Címzett </label>
        <input type="text" id="cimzett" name="cimzett" required>

        <button type="submit" name="user_check" id="user_check">Check</button>


        <br>

        <label for="content">Szöveg </label>
        <input type="text" id="content" name="content">

        <button type="submit" name="send_message" id="send_message">Küldés</button>
    </form>
</div>


</main>

<?php footerGenerate(); ?>

</body>

</html>
