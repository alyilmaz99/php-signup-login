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

if(isset($_POST['update_name']) && isset($_POST['update_email']) &&  !empty($_POST['update_email'])){
    $updateName = $_POST['update_name'];
    $updateEmail = $_POST['update_email'];
    $updateSql = "UPDATE user SET name = '$updateName', email = '$updateEmail' WHERE id = {$_SESSION['user_id']}";
    $updateResult = $mysqli->query($updateSql);
}
header("Location: profile.php");
    exit();
?>