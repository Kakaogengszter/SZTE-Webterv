<?php
    session_start();
    require_once('php/connection.php');
    require_once('php/includes.php');
    $db = new Database();
    $sqlselect = "SELECT * FROM recipes";
    $resSelect = $db->mysqli->query($sqlselect);
    $recipes = $resSelect->fetch_all();
    
    // [0]=id, [1]=username, [2]=email, [3]=password, [4]=birthdate, [5]=picture
    // [0]=id, [1]=user_id, [2]=name, [3]=image_name, [4]=video_url, [5]=portion, [6]=time, [7]=ingredients, [8]=instructions, [9]=upload_date
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Receptek</title>
        <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
        <link rel="stylesheet" href="./css/style.css">
        <script src="./js/app.js" defer></script>
    </head>

    <body>
        <?php navigationGenerate("recipes"); ?>

        <main>
            <h1 id="page-title" class="text-center">Receptek</h1>
            <div class="recipes-container">

                <?php 
                    foreach ($recipes as $recipe) {
                        $userid= $recipe[1];
                        $uploaderSqlSelect = "SELECT * FROM users WHERE id = $userid";
                        $uploaderSelect = $db->mysqli->query($uploaderSqlSelect);
                        $uploaderData = $uploaderSelect->fetch_all()[0];
                        
                        echo 
                        "<div class='card-container'>" .
                            "<img src='./img/". $recipe[3] ."' alt='" . explode(".", $recipe[3])[0] ."'>" .
                            "<h3 class='recipe-name text-center'><a href='./recipe.php?name=". slugify($recipe[2]) . "'>" . $recipe[2] . "</a></h3>" .
                            "<div class='recipe-details'>" .
                                "<div>" .
                                    "<p>Adag: " . $recipe[5] ." adag</p>" .
                                    "<p>Összesen: ". $recipe[6] . " perc</p>" .
                                "</div>" .
                            "</div>" .
                            "<div class='recipe-uploader'>" .
                                "<a href='./profile.php?name=" . $uploaderData[1] . "'>" .
                                    "<img class='img-rounded' height='35' width='35' src='./profilePics/". $uploaderData[5] ."' alt='". $uploaderData[1] ." profil képe'>" .
                                    "<p>". $uploaderData[1] ."</p>" .
                                "</a>" .
                            "</div>" .
                        "</div>";
                    }
                ?>
            </div>
        </main>

        <?php footerGenerate();?>
    </body>
</html>
