<?php
require_once 'db.php';
DB::Init();

function redirectError(int $code = 401) {
    echo 'Error: '. $code;
    die();
}

function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        return redirectError(401);
    }

    $sql = "SELECT * FROM user 
            WHERE id = {$_SESSION['user_id']}";
    $result = DB::get()->query($sql);
    $user = $result->fetch_assoc();
    if (!isset($user)) {
        return redirectError(401);
    }

    return $user;
}

function getBasket()
{
    $user = checkLogin();
    $basketSqlCall= "SELECT * FROM basket WHERE user_id = {$user['id']}";
    $basketResult = DB::get()->query($basketSqlCall);
    $basket = $basketResult->fetch_assoc();
    return $basket;
}