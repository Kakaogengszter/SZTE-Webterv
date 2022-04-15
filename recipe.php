<?php
    session_start();
    require_once('php/connection.php');
    require_once('php/includes.php');

    if (!isset($_GET['name'])) {
        header("Location: ./recipes.php");
    }

    $recipename = $_GET['name'];

    
    $db = new Database();

    $sqlselect = "SELECT * FROM recipes WHERE slug = '$recipename'";
    $resSelect = $db->mysqli->query($sqlselect);
    $recipe = $resSelect->fetch_all()[0];

    $_SESSION["recipe_id"] = $recipe[0];
    $_SESSION["recipe_name"] = $recipename;

    if (empty($recipe)) {
        header("Location: ./recipes.php");
    }

    $ingredients = explode("\;",  $recipe[7]);
    $instructions = explode("\;",  $recipe[8]);
    
    $userid= $recipe[1];
    $uploaderSqlSelect = "SELECT * FROM users WHERE id = '$userid'";
    $uploaderSelect = $db->mysqli->query($uploaderSqlSelect);
    $uploaderData = $uploaderSelect->fetch_all()[0];

    if(isset($_SESSION["comment_error"])){
        $error = $_SESSION["comment_error"];
    }else{
        $error[] = null;
    }


    // [0]=id, [1]=user_id, [2]=name, [3]=image_name, [4]=video_url, [5]=portion, [6]=time, [7]=ingredients, [8]=instructions, [9]=upload_date, [10]=slug
    // [0]=id, [1]=username, [2]=email, [3]=password, [4]=birthdate, [5]=picture

    $comments = $db ->get_comments($recipe[0]);

    if(isset($_SESSION["ban_error"])){
        $ban_error = $_SESSION["ban_error"];
    }else{
        $ban_error[] = null;
    }



?>
<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Az eredeti carbonara</title>
        <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
        <link rel="stylesheet" href="./css/style.css">
        <script src="./js/app.js" defer></script>
    </head>

    <body>
        <?php
            navigationGenerate("recipe");
        ?>


        <main>
            <div class="grid-container">
                <?php
                    echo
                    "<div id='save-recipe'>" .
                        "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 384 512'><path d='M384 48V512l-192-112L0 512V48C0 21.5 21.5 0 48 0h288C362.5 0 384 21.5 384 48z'/></svg>" .
                    "</div>" .
                    "<h1 class='receptneve'>" . $recipe[2]. "</h1>" .
                    "<div class='feltolto text-center'>" .
                        "<div class='rating'>" .
                            "<span>(10)</span>" .
                            "<input type='radio' name='star'/><span class='star'></span>" .
                            "<input type='radio' name='star'/><span class='star'></span>" .
                            "<input type='radio' name='star'/><span class='star'></span>" .
                            "<input type='radio' name='star'/><span class='star'></span>" .
                            "<input type='radio' name='star'/><span class='star'></span>" .
                        "</div>" .
                        "<a href='./profile.php?name=" . $uploaderData[1] . "'>" .
                            "<img class='img-rounded' height='50' width='50' src='./profilePics/" . $uploaderData[5] . "' alt='" . $uploaderData[1] . " profil képe'>" .
                            "<p>" . $uploaderData[1] ."</p>" .
                        "</a>" .
                        "<p>Feltöltés ideje: " . $recipe[9] ."</p>" .
                    "</div>" .

                    "<div class='adatok text-center'>" . 
                        "<p>Adag: " . $recipe[5] . " fő</p>" . 
                        "<p>Idő: " . $recipe[6] . " perc</p>" . 
                    "</div>" . 

                    "<div class='hozzavalok'>" . 
                        "<h2 class='text-center'>Hozzávalók:</h2>" . 
                        "<ul>";
                            foreach ($ingredients as $ingredient) {
                                echo "<li>" . $ingredient . "</li>";
                            }
                        echo 
                        "</ul>" . 
                    "</div>" . 

                    "<div class='elkeszites'>" . 
                        "<h2 class='text-center'>Elkészítés:</h2>";

                        foreach ($instructions as $instruction) {
                            echo "<p>" . $instruction .  "</p>";
                        }
                        echo
                    "</div>" . 

                    "<div class='media text-center'>" . 
                        "<iframe src='" . $recipe[4] . "'></iframe>" . 
                        "<img src='./img/" . $recipe[3]  . "' alt='" . $recipe[2] . "'>" . 
                    "</div>";
            ?>
            </div>



            <div class="comment-container">
                <?php
                if (count($error) > 0 && isset($_SESSION["comment_error"])) {
                    echo "<div class='errors' id='left-errors'>";

                    echo $error[0];

                    echo "</div>";
                }

                unset($_SESSION["comment_error"]);
                ?>
                <h2>Hozzászólások</h2>

                <?php

                    echo " <div class='comment'>"
                ?>

                <?php

                foreach ($comments as $comms){

                        $username = $comms -> getUsername();
                        $comment = $comms -> getComment();
                        $comment_id =$comms -> getCommentID();
                        $user_id = $comms -> getUsernameID();

                    echo "<h3 class='comment-user'><a href='profile.php'>$username</a></h3>
                            <p class='comment-msg'>$comment</p>
                            <form action='php/deleteComment.php' method='post'>
                            <input type='text' name='comment_id' value='$comment_id' hidden>"
                            ?>

                        <?php
                            if(isset($_SESSION["userID"]) && $_SESSION["userID"] == $user_id){

                                echo"
                                <button type='submit' name='delete_comment' class='delete_comment'>Törlés</button>";
                            }else if(isset($_SESSION["admin"])){
                                echo"
                                <button type='submit' name='delete_comment' class='delete_comment'>Törlés</button>";
                            }

                            echo"</form>";
                            }
                            ?>

                </div>

                     <form class="recipe-new-comment" action="php/addCommentValidator.php" method="POST">
                         <label for="recipe-comment">Új hozzászólás:</label>
                         <textarea id="recipe-comment" name="recipe-comment"></textarea>
                         <input class="recipe-add-comment cursor-pointer" type="submit" name="comment" value="Hozzászólás">
                     </form>






        </main>


        <?php footerGenerate();?>

    </body>
</html>
