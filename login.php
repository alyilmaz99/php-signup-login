<?php
$is_valid = false;
ini_set('display_errors', true);
error_reporting(E_ALL);

$counter_number = 0;
$total = 0;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM user 
            WHERE email = '%s'", $mysqli->real_escape_string( $_POST["email"]));
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST["password"], $user["password_hash"])) {
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $user["id"];
           
        }
    }
    $is_valid = true;

    $basketSqlCall= "SELECT * FROM basket WHERE user_id = {$user["id"]}";
    $basketResult = $mysqli->query($basketSqlCall);
    $basket = $basketResult->fetch_assoc();

    if(!isset($basket['user_id'])){
        $sql2 = "INSERT INTO basket(user_id, counter_number, total)
        VALUES (?,?,?)";
        $sql2Result = $mysqli->query($sql2);
        $stmt = $mysqli-> stmt_init();

        if ( !$stmt->prepare($sql2)) {
            die("SQL error: " . $mysqli->error);
        }
        $stmt-> bind_param("sss",$user["id"],$counter_number, $total);
        
        
        if(!$stmt->execute()){
            die("SQL error: " . $stmt->error . " Error number: " . $mysqli->errno);
        }
    }
    header("Location: index.php");
            exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css" />
</head>

<body>
    <h1>Login</h1>
    <?php if($is_valid) : ?>
    <b>Invalid Login</b>
    <?php endif;?>


    <form method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST["email"] ?? "")?>">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <button>Log in</button>
    </form>
</body>

</html>