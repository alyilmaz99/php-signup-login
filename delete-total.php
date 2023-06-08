<?php
session_start();
ini_set('display_errors', true);
error_reporting(E_ALL);

$mysqli = require __DIR__ . "/database.php";
    $userRequest = "SELECT * FROM user WHERE id = {$_SESSION['user_id']}";
    $userResult = $mysqli->query($userRequest);
    $user = $userResult->fetch_assoc();

    $basketSqlCall = "SELECT * FROM basket WHERE user_id = {$user["id"]}";
    $basketResult = $mysqli->query($basketSqlCall);
    $basket = $basketResult->fetch_assoc();


if ($_SESSION['delete_all']) {

    
    $deleteAll = "UPDATE  basket SET total = 0 WHERE user_id = {$user["id"]}";

    $updateDelete = $mysqli->query($deleteAll);
    $stmt = $mysqli-> stmt_init();

    if(!$stmt->prepare($deleteAll)){
        die("SQL error: " . $mysqli->error);
    
    }
    if(!$stmt->execute()){
        die("SQL error: " . $stmt->error . " Error number: " . $mysqli->errno);
    }
    header("Location: index.php");
    $_SESSION['delete_all'] = false;
    exit();

} else {

    $deleteSelected = "UPDATE basket SET total = total - {$_POST["delete"]} WHERE user_id = {$user["id"]}";

    $updateDelete = $mysqli->query($deleteSelected);
    $stmt = $mysqli-> stmt_init();
    

    if(!$stmt->prepare($deleteSelected)){
        die("SQL error: " . $mysqli->error);
    
    }
    if(!$stmt->execute()){
        die("SQL error: " . $stmt->error . " Error number: " . $mysqli->errno);
    }
    header("Location: index.php");
    $_SESSION['delete_all'] = false;
    exit();
    
}
?>