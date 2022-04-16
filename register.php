<?php
    session_start();
    require_once('php/connection.php');
    require_once('php/includes.php');

    if (isset($_SESSION['userID'])){
        header("Location: ./profile.php");
    }

    $errors = [];
    if (isset($_POST["register"])){
        $db = new Database();
        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);
        $passwordConfirm = trim($_POST["password-check"]);
        $bdate = trim($_POST["birthdate"]);

        if ($username === "" || $email === "" || $password === "" ||
            $passwordConfirm === "" || $bdate === "") {
            $errors[] = "Minden kötelezően kitöltendő mezőt ki kell tölteni!";
        }

        $sqlselect = "SELECT * FROM users WHERE username = '$username'";
        $resSelect = $db->mysqli->query($sqlselect);
        $row = $resSelect->fetch_all();
        if(!empty($row)) {
            $errors[] = "A felhasználónév már foglalt!";
        }

        if (!preg_match("/[A-Za-z]/", $password) || !preg_match("/[0-9]/", $password)) {
            $errors[] = "A jelszónak tartalmaznia kell betűt és számjegyet is!";
        }

        if (!preg_match("/[0-9a-z.-]+@([0-9a-z-]+\.)+[a-z]{2,4}/", $email)) {
            $errors[] = "A megadott e-mail cím formátuma nem megfelelő!";
        }

        if ($password !== $passwordConfirm) {
            $errors[] = "A két jelszó nem egyezik!";
        }

        $sqlselect = "SELECT * FROM users WHERE email = '$email'";
        $resSelect = $db->mysqli->query($sqlselect);
        $row = $resSelect->fetch_all();
        if(!empty($row)) {
            $errors[] = "Az email cím már foglalt!";
        }

        if (count($errors) === 0) {
            $hash = password_hash($pwd, PASSWORD_DEFAULT);
            $db->insertUsersToDB($user,$email,$hash,$bdate);
            header("Location: ./login.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Regisztráció</title>
        <link rel="icon" type="image/x-icon" href="./img/favicon.ico">
        <link rel="stylesheet" href="./css/style.css">
        <script src="./js/app.js" defer></script>
    </head>

    <body>
        <?php navigationGenerate("register"); ?>

        <main>
            <div class="form-container">
                <?php
                    if (count($errors) > 0) {
                        echo "<div class='errors'>";
                        foreach ($errors as $error) {
                            echo "<p>" . $error . "</p>";
                        }
                        echo "</div>";
                    }
                ?>
                <h1>Regisztráció</h1>
                <form class="default-form register-form" action="register.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <label class="required-label" for="username">Felhasználónév:</label>
                    <input type="text" name="username" id="username" maxlength="80" placeholder="Felhasználónév" <?php if (isset($username)) { echo "value='$username'"; }?> required>

                    <label class="required-label" for="email">E-mail cím:</label>
                    <input type="email" name="email" id="email" placeholder="email@email.com" <?php if (isset($email)) { echo "value='$email'"; }?> required>

                    <label class="required-label" for="password">Jelszó:</label>
                    <input type="password" name="password" id="password" placeholder="Jelszó" required>

                    <label class="required-label" for="password-check">Jelszó megerősítése:</label>
                    <input type="password" name="password-check" id="password-check" placeholder="Jelszó megerősítése" required>

                    <label for="birthdate">Születési dátum:</label>
                    <input type="date" id="birthdate" name="birthdate" min="1900-01-01" <?php if (isset($birthdate)) { echo "value='$birthdate'"; }?>>

                    <label for="profile-picture">Profilkép:</label>
                    <input type="file" name="profile-picture" id="profile-picture">

                    <div class="form-btn-container">
                        <input type="submit" name="register" value="Regisztráció">
                        <input type="reset" name="reset" value="Reset">
                    </div>
                    <p class="required-footnote"><small> kötelező</small></p>
                </form>
            </div>
        </main>

        <?php footerGenerate();?>
    </body>
</html>
