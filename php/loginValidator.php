<?php
session_start();

require_once('connection.php');

$db = new Database();

if (isset($_POST['login'])){
    $userName = $_POST['username'];
    $pwd = $_POST['password'];
    $res = $db -> login($userName);


    if ($res) {

        if($res -> num_rows == 1){
            //belépett
            $row = $res -> fetch_row();

            if (password_verify($pwd, $row[3]))
            {
                $_SESSION['userID'] = $row[0];
                header("Location: ../index.html");
            }
            else {
                //érvénytelen belépés
                $_SESSION['error'] = 'Helytelen felhasználónév vagy jelszó!';
                echo "Helytelen felhasználónév vagy jelszó";
                echo "<br><a href='../login.php'>
                  <button type='button'>Vissza a bejelentkezéshez</button>
                      </a>";

            }
        }
    }
}
echo "</body>";
?>