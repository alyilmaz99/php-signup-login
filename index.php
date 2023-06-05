<?php
session_start();
ini_set('display_errors', true);
error_reporting(E_ALL);


if (isset($_SESSION['user_id'])) {
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM user 
            WHERE id = {$_SESSION['user_id']}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Index Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css" />
</head>

<body>
    <h1>Index Page</h1>

    <?php if(isset($user)):?>
    <p>
        You are in. <?=htmlspecialchars($user["name"]) ?>
    </p>
    <p> <a href="logout.php"> Logout.</a> </p>
    <?php else: ?>
    <p> <a href="login.php"> Login</a> or <a href="signup.html" </a>>
            SignUp
        </a>
    </p>
    <?php endif;?>

</body>

</html>