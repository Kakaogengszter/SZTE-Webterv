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

    if (empty($recipe)) {
        header("Location: ./recipes.php");
    }

    $ingredients = explode("\;",  $recipe[7]);
    $instructions = explode("\;",  $recipe[8]);
    
    $userid= $recipe[1];
    $uploaderSqlSelect = "SELECT * FROM users WHERE id = '$userid'";
    $uploaderSelect = $db->mysqli->query($uploaderSqlSelect);
    $uploaderData = $uploaderSelect->fetch_all()[0];

    // comment
    $recipeID= $recipe[0];
    $recipeCommentSqlSelect = "SELECT * FROM comments WHERE recipe_id = '$recipeID'";
    $recipeCommentSelect = $db->mysqli->query($recipeCommentSqlSelect);
    $recipeComments = $recipeCommentSelect->fetch_all();

    $errors = [];
    if (isset($_POST["comment"])) {
        if (!isset($_SESSION["userID"])) {
            $errors[] = "Csak bejelentkezett felhasználó szólhat hozzá!";
        } else {
            $comment = trim($_POST["recipe-comment"]);
            if ($comment === "") {
                $errors[] = "Hozzászólás nem lehet üres!";
            }

            if (count($errors) == 0) {
                $db->insertCommentToDB($_SESSION["userID"],$recipeID,$comment);
                header("Location: ./recipe.php?name=" . $_GET["name"]);
            }
        }
    }

    //remove
    if (isset($_POST["commentRemove"])) {
        $commentId = $_POST["comment-id"];
        $db->deleteComment($commentId);
        header("Location: ./recipe.php?name=" . $_GET["name"]);
    }


    // [0]=id, [1]=user_id, [2]=name, [3]=image_name, [4]=video_url, [5]=portion, [6]=time, [7]=ingredients, [8]=instructions, [9]=upload_date, [10]=slug
    // [0]=id, [1]=username, [2]=email, [3]=password, [4]=birthdate, [5]=picture
?>
<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $recipe[2]; ?></title>
        <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
        <link rel="stylesheet" href="./css/style.css">
        <script src="./js/app.js" defer></script>
    </head>

    <body>
        <?php navigationGenerate("recipe"); ?>

        <main>
            <div class="grid-container">
                <div id='save-recipe'>
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 384 512'><path d='M384 48V512l-192-112L0 512V48C0 21.5 21.5 0 48 0h288C362.5 0 384 21.5 384 48z'/></svg>
                </div>
                <?php
                    echo
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
                <h2>Hozzászólások</h2>
                <?php
                    if (count($recipeComments) == 0) {
                        echo
                        "<div class='comment'>" .
                            "<p>Még nem érkezett hozzászólás</p>" .
                        "</div>";
                    } else {
                        foreach ($recipeComments as $comment) {
                            $commentUserId= $comment[1];
                            $userCommentSqlSelect = "SELECT username FROM users WHERE id = '$commentUserId'";
                            $userCommentSelect = $db->mysqli->query($userCommentSqlSelect);
                            $userNameComment = $userCommentSelect->fetch_all()[0];

                            echo
                            "<div class='comment'>" .
                                "<h3 class='comment-user'><a href='./profile.php?name=" . $userNameComment[0] . "'>" . $userNameComment[0] . "</a></h3>" .
                                "<p>" . $comment[3] . "</p>";
                                if ($_SESSION["userID"] == $comment[1]) {
                                    echo 
                                    "<form class='recipe-delete-comment'  autocomplete='off' action='recipe.php?name=" . $_GET['name'] . "' method='POST'>" .
                                        "<input type='hidden' name='comment-id' value='" . $comment[0] ."'>" .
                                        "<input class='cursor-pointer' type='submit' name='commentRemove' value='Törlés'>" .
                                    "</form>";
                                }
                            echo 
                            "</div>";
                        }
                    }
                ?>

                <form class="recipe-new-comment"  autocomplete="off" action="recipe.php?name=<?php echo $_GET["name"]?>" method="POST">
                    <?php
                        if (count($errors) > 0) {
                            echo "<div class='errors-comment'>";
                            foreach ($errors as $error) {
                                echo "<p>" . $error . "</p>";
                            }
                            echo "</div>";
                        }
                    ?>
                    <label for="recipe-comment"><h3>Új hozzászólás:</h3></label>
                    <textarea class="recipe-comment-text" id="recipe-comment" name="recipe-comment"></textarea>
                    <input class="recipe-add-comment cursor-pointer" type="submit" name="comment" value="Hozzászólás">
                </form>
            </div>
        </main>

        <?php footerGenerate(); ?>
    </body>
</html>
