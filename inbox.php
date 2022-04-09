<?php

require_once("php/messagesSelect.php");

$dataBase = new Database();


$id = $_SESSION["userID"];


$dataListTable = $dataBase->run_select_query("SELECT * FROM inbox WHERE kinekID = $id");
$messageArray = array();
foreach ($dataListTable as $DLT) {
    $messageData = new Message($DLT["kitolID"], $DLT["kinekID"], $DLT["message"]);
    $messageArray[] = $messageData;

}

if(!empty($messageData)){
    $kuldoUsername = $messageData -> kitol();
    $messageContent = $messageData -> messageContentArray();

    $hossz = count($messageContent);
    $message = $messageData -> egyesites();
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
<nav class="navbar">
    <a class="brand" href="./index.php">Receptoldal</a>

    <ul class="nav-menu">

        <li class="nav-item"><a class="nav-link active" href="./index.php">Főoldal</a></li>
        <li class="nav-item"><a class="nav-link" href="./recipes.html">Receptek</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Bejelentkezés</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">Regisztráció</a></li>

        <li class="nav-item"><a class="nav-link" href="profile.php">Profil</a></li>
        <li class="nav-item"><a class="nav-link" href="inbox.php">Üzenetek</a></li>
        <li class="nav-item"><a class="nav-link" href="php/logout.php">Kijelentkezés</a></li>
    </ul>

    <div class="burger">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>
</nav>

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

    <form action="php/messageSend.php" method="post" autocomplete="off">
        <label class="required-label" for="cimzett">Címzett </label>
        <input type="text" id="cimzett" name="cimzett" required>

        <button type="button">Check</button>
        <p id="exist_user"></p>


        <br>

        <label for="content">Szöveg </label>
        <input type="text" id="content" name="content">

        <button type="submit" name="send_message" id="send_message">Küldés</button>
    </form>

</main>

<footer>
    <ul>
        <li><a href="./index.php">Főoldal</a></li>
        <li><a href="./recipes.html">Receptek</a></li>
        <li><a href="login.php">Bejelentkezés</a></li>
        <li><a href="register.php">Regisztráció</a></li>

        <li><a href="profile.php">Profil</a></li>
        <li><a href="php/logout.php">Kijelentkezés</a></li>
    </ul>
    <p class="copyright">
        Copyright &copy; 2022 Receptoldal
    </p>
</footer>

</body>

</html>
