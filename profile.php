<?php
include "php/includes.php";
require_once("php/profileSelect.php");


$dataBase = new Database();

$id = $_SESSION["admin"] ?? $_SESSION["userID"];



$dataListTable = $dataBase-> mysqli -> query("SELECT * FROM users WHERE id = $id");

foreach ($dataListTable as $DLT) {
    $userData = new User($DLT["id"],$DLT["username"],$DLT["email"],$DLT["password"],$DLT["birthdate"],$DLT["picture"]);
}

if(isset($_SESSION["errors"])){
    $error = $_SESSION["errors"];
}else{
    $error[] = null;
}

if(isset($_SESSION["profile_pic_error"])){
    $pic_error = $_SESSION["profile_pic_error"];
}else{
    $pic_error[] = null;
}

?>


<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>firstuser</title>
        <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
        <link rel="stylesheet" href="./css/style.css">
        <script src="./js/app.js" defer></script>
    </head>

    <body>
    <?php

    navigationGenerate("profile");

    ?>

        <main>

            <?php
            if (isset($_GET["siker"])) {
                echo "<div class='success'>A módisítás sikeres!</div>";
            }

            if (count($error) > 0 && isset($_SESSION["errors"])) {
                echo "<div class='errors'>";
                foreach ($error as $err) {
                    echo "<p>" . $err . "</p>";
                }
                echo "</div>";
            }

            if (count($pic_error) > 0 && isset($_SESSION["profile_pic_error"])) {
                echo "<div class='errors'>";
                foreach ($pic_error as $pic_err) {
                    echo "<p>" . $pic_err . "</p>";
                }
                echo "</div>";
            }

            unset($_SESSION["errors"]);
            unset($_SESSION["profile_pic_error"]);
            ?>

            <div class="profile-container">
                <h1><?php

                    echo $userData -> getUsername();

                    ?> profilja</h1>
                <div class="profile-informations">


                    <form class="profile-form" action="php/profilePicture.php" method="post" enctype="multipart/form-data">


                        <div class="profile-picture-container">
                            <img class="img-rounded" height="200" src="profilepics/<?php echo $userData -> getPicture() ?>" alt="profile picture">

                            <label for="profile-picture">Feltöltés</label>
                            <input type="file" name="profile-picture" onchange="form.submit()" id="profile-picture">

                        </div>

                    </form>

                    <form class="profile-form" action="php/profileEdit.php" method="POST" autocomplete="off" enctype="multipart/form-data">


                        <label for="username">Felhasználónév (min. 6 karakter):</label>
                        <input type="text" name="username" id="username" maxlength="80" value="<?php echo $userData -> getUsername() ?>" required>

                        <label for="email">E-mail cím:</label>
                        <input type="email" name="email" id="email" value="<?php echo $userData -> getEmail() ?>" required>

                        <label for="password">Aktuális jelszó:</label>
                        <input type="password" name="aPassword" id="password" placeholder="Aktuális jelszó" required>

                        <label for="password">Új jelszó: (opcionális, min. 6 karakter és szám)</label>
                        <input type="password" name="newPassword" id="password" placeholder="Új jelszó" >

                        <label for="birthday">Születési dátum:</label>
                        <input type="date" id="birthday" name="birthday" min="1900-01-01">

                        <input type="submit" name="update" value="Mentés">
                        <input type="submit" name="delete" value="Fiók törlése">

                    </form>
                </div>

                <hr>

                <h2>Kedvenc receptek:</h2>
                <div class="recipe-list-container">
                    <div class="card-container">
                        <a href="./recipes/bolognai-raguval-toltott-langos.html">
                            <img src="./img/bolognai-raguval-toltott-langos.jpg" alt="bolognai-raguval-toltott-langos">
                            <h3 class="recipe-name text-center">Bolognai raguval töltött lángos</h3>
                        </a>
                    </div>

                    <div class="card-container">
                        <a href="./recipes/az-eredeti-carbonara.html">
                            <img src="./img/az-eredeti-carbonara.jpg" alt="carbonara">
                            <h3 class="recipe-name text-center">Az eredeti carbonara</h3>
                        </a>
                    </div>

                    <div class="card-container">
                        <a href="./recipes/tiramisu.html">
                            <img src="./img/tiramisu.jpg" alt="tiramisu.jpg">
                            <h3 class="recipe-name text-center">Tiramisu</h3>
                        </a>
                    </div>
                </div>

                <hr>

                <div class="own-create-container">
                    <h2 class="own-recipes">Saját receptek:</h2>
                    <h4 class="create-recipe-link"><a href="./create-recipe.html">Új recept hozzáadása</a></h4>
                </div>
                <div class="recipe-list-container">
                    <div class="card-container">
                        <a href="./recipes/homemade-duplasajtos-hamburger.html">
                            <img src="./img/homemade-duplasajtos-hamburger.jpg" alt="homemade duplasajtos hamburger">
                            <h3 class="recipe-name text-center">Homemade duplasajtos hamburger</h3>
                        </a>
                    </div>
                    <div class="card-container">
                        <a href="./recipes/grillezett-kenyerlangos.html">
                            <img src="./img/grillezett-kenyerlangos.jpg" alt="grillezett kenyerlangos">
                            <h3 class="recipe-name text-center">Grillezett kenyérlángos</h3>
                        </a>
                    </div>
                </div>
            </div>
        </main>

    <?php footerGenerate(); ?>

    </body>
</html>
