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
    $basketSqlCall= "SELECT * FROM basket WHERE user_id = {$user["id"]}";
    $basketResult = $mysqli->query($basketSqlCall);
    $basket = $basketResult->fetch_assoc();
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

    <form action="calculate-quantity.php" method="post" id="quantity">
        <input type="text" name="quantity" id="quantity" placeholder="Quantity?">
        <input type="submit" value="Post">
    </form>
    </p>

    <p>
        Added: <?=htmlspecialchars($basket["counter_number"]) ?>
        <br>
        Total: <?= htmlspecialchars($basket["total"])?>
    </p>
    <p>
        <?php $_SESSION['delete_all'] = true?>
        <a href="delete-total.php">Clear Total</a>
    </p>
    <form action="delete-total.php" method="post" id="delete">
        <input type="text" name="delete" id="delete" placeholder="Delete Number?">
        <input type="submit" value="Post">
        <?php $_SESSION['delete_all'] = false?>
    </form>
    <p>
        <a href=" logout.php"> Logout.</a>
    </p>



    <?php else: ?>
    <p> <a href="login.php"> Login</a> or <a href="signup.html" </a>>
            SignUp
        </a>
    </p>
    <?php endif;?>

</body>

</html>