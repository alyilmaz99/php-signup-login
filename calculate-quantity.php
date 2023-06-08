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
    
    if(isset($basket['user_id'])){
      $total = $basket['total'];
      $total += $_POST["quantity"];
      $updateTable = "UPDATE basket SET counter_number = {$_POST["quantity"]}, total= {$total}  WHERE user_id = {$user["id"]}";
        $updateResult = $mysqli->query($updateTable);
        $stmt = $mysqli-> stmt_init();
        if ( !$stmt->prepare($updateTable)) {
            die("SQL error: " . $mysqli->error);
        }
       
        $stmt-> bind_param("ss",$_POST["quantity"], $total);
        
        if(!$stmt->execute()){
            die("SQL error: " . $stmt->error . " Error number: " . $mysqli->errno);
        }
        header("Location: index.php");
        exit();
    } else {
        
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
    header("Location: index.php");
    exit();
    } 
}else{
    header("Location: login.php");
    exit;
}






?>