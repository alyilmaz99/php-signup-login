<?php
session_start();
ini_set('display_errors', true);
error_reporting(E_ALL);
require_once 'db.php';
DB::Init();
$db = DB::get();

    $userRequest = "SELECT * FROM user WHERE id = {$_SESSION['user_id']}";
    $userResult = $db->query($userRequest);
    $user = $userResult->fetch_assoc();

    $basketSqlCall = "SELECT * FROM basket WHERE user_id = {$user["id"]}";
    $basketResult = $db->query($basketSqlCall);
    $basket = $basketResult->fetch_assoc();


if (!isset($_POST["delete"]) ) {
    
    $deleteAll = "UPDATE  basket SET total = 0 WHERE user_id = {$user["id"]}";

    $updateDelete = $db->query($deleteAll);
    $stmt = $db-> stmt_init();

    if(!$stmt->prepare($deleteAll)){
        die("SQL error: " . $db->error);
    
    }
    if(!$stmt->execute()){
        die("SQL error: " . $stmt->error . " Error number: " . $db->errno);
    }
    header("Location: index.php");
 
    exit();

} else {
    
    $deleteSelected = "UPDATE basket SET total = total - {$_POST["delete"]} WHERE user_id = {$user["id"]}";

    $updateDelete = $db->query($deleteSelected);
    $stmt = $db -> stmt_init();
    

    if(!$stmt->prepare($deleteSelected)){
        die("SQL error: " . $db->error);
    
    }
    if(!$stmt->execute()){
        die("SQL error: " . $stmt->error . " Error number: " . $db->errno);
    }
    header("Location: index.php");
    
    exit();
    
}
?>