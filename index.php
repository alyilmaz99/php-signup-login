<?php
session_start();
ini_set('display_errors', true);
error_reporting(E_ALL);
require_once 'db.php';
require_once 'global.php';

DB::Init();


if (isset($_SESSION['user_id']) ) {
    if( isset($user)){
        header("Location: index.php");
        exit();
    } else {
        $mysqli = DB::get();
        $user = checkLogin();
        $basket = getBasket();
        $_SESSION['delete_all'] = true;
    }
    
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

        <a href="delete-total.php">Clear Total</a>
    </p>
    <form action="delete-total.php" method="post" id="delete">

        <input type="text" name="delete" id="delete" placeholder="Delete Number?">
        <input type="submit" value="Post">

    </form>
    <p>
        <a href=" profile.php"> Profile</a>
    </p>

    <?php if ($user['email_verified_at'] == null):?>
    <p> Please verify your email address.
        <a href='auth/email-verification.php?email=<?=htmlspecialchars($user['email'])?>'> GO</a>
    </p>

    <?php else:?>
    <p> Your email address is verified. </p>
    <?php endif;?>
    <p>
        <a href=" auth/logout.php"> Logout.</a>
    </p>

    <?php else: ?>
    <p> <a href="auth/login.php"> Login</a> or <a href="signup.html" </a>>
            SignUp
        </a>
    </p>
    <?php endif;?>

</body>

</html>