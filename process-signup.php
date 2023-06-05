<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

if (empty($_POST["name"])) {
    die("Name is required");
}

if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL )) 
{
    die("Email is not valid");
}

if(strlen($_POST["password"]) < 6) 
{
    die("Password must be at least 6 characters long");
}
if ( !preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}
if ( !preg_match("/[0-9]/i", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Password does not match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (name,email,password_hash)
        VALUES (?,?,?)";

$stmt = $mysqli-> stmt_init();

if ( !$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt-> bind_param("sss", $_POST["name"], $_POST["email"], $password_hash);

if (!$stmt->execute()) {
    if ($mysqli->errno === 1062) {
        echo "Same email already exists";
    } else {
        die("SQL error: " . $stmt->error . " Error number: " . $mysqli->errno);
    }  
} else {
    header("Location: signup-succes.html");
    exit;
}