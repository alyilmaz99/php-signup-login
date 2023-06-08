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

    $total = 0;
    $sql2 = "INSERT INTO basket(user_id, counter_number, total)
        VALUES (?,?,?)";
    $stmt = $mysqli-> stmt_init();

if ( !$stmt->prepare($sql2)) {
    die("SQL error: " . $mysqli->error);
}
$stmt-> bind_param("sss",$user["id"],$_POST["quantity"], $total);


if(!$stmt->execute()){
    die("SQL error: " . $stmt->error . " Error number: " . $mysqli->errno);
}

exit();

}else{
    header("Location: login.php");
    
    exit;
}





?>