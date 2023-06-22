<?php
session_start();
ini_set('display_errors', true);
error_reporting(E_ALL);
require_once 'db.php';
require_once 'global.php';




if (isset($_SESSION['user_id'])) {
    $user = checkLogin();
    $basket = getBasket();
    if(isset($basket['user_id'])){
      $total = $basket['total'];
      $total += $_POST["quantity"];
      $updateTable = "UPDATE basket SET counter_number = {$_POST["quantity"]}, total= {$total}  WHERE user_id = {$user["id"]}";
        $updateResult =DB::get()->query($updateTable);
        $stmt =DB::get()-> stmt_init();
        if ( !$stmt->prepare($updateTable)) {
            die("SQL error: " . DB::get()->error);
        }
        $stmt-> bind_param("ss",$_POST["quantity"], $total);
        if(!$stmt->execute()){
            die("SQL error: " . $stmt->error . " Error number: " . DB::get()->errno);
        }
        header("Location: index.php");
        exit();
    } else {
        
    $sql2 = "INSERT INTO basket(user_id, counter_number, total)
    VALUES (?,?,?)";
    $stmt = DB::get() -> stmt_init();
    if ( !$stmt->prepare($sql2)) {
        die("SQL error: " . DB::get()->error);
    }
    $stmt-> bind_param("sss",$user["id"],$_POST["quantity"], $total);
    if(!$stmt->execute()){
        die("SQL error: " . $stmt->error . " Error number: " . DB::get()->errno);
    }
    header("Location: index.php");
    exit();
    } 
}else{
    header("Location: login.php");
    exit;
}






?>