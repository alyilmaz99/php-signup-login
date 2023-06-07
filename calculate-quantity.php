<?php
session_start();
ini_set('display_errors', true);
error_reporting(E_ALL);

$total = 0;
$mysqli = require __DIR__ . "/database.php";
$sql = "INSERT INTO basket(user_id, counter_number, total)
        VALUES (?,?,?)";

$stmt = $mysqli-> stmt_init();

if ( !$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}
$stmt-> bind_param("sss", $_SESSION['user'],$_POST["quantity"], $total);


if(!$stmt->execute()){
    die("SQL error: " . $stmt->error . " Error number: " . $mysqli->errno);
}

exit();
?>