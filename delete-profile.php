 <?php 


session_start();

$mysqli = require __DIR__ . "/database.php";
$delete = "DELETE FROM user WHERE id = {$_SESSION['user_id']}";
$mysqli->query($delete);


session_destroy();
header("Location: index.php");
exit;

?>