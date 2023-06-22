<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

require_once 'db.php';
DB::Init();

session_start();

$mysqli = DB::get();

$delete = "DELETE FROM user WHERE id = {$_SESSION['user_id']}";
$mysqli->query($delete);

session_destroy();
header("Location: index.php");
exit;
?>