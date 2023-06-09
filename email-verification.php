<?php
session_start();
ini_set('display_errors', true);
error_reporting(E_ALL);

require_once('global.php');

$user = checkLogin();

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $verification_email = $_POST['verification_email'];
    $verification_code = $_POST['verification_code'];

    if($verification_code == $user['verification_code'] && $verification_email == $user['email']) {
        $updateSql = "UPDATE user SET email_verified_at = NOW() WHERE id = {$user['id']}";
    $result = $mysqli->query($updateSql);
    $stmt = $mysqli-> stmt_init();
if (!$stmt->prepare($updateSql)) {
    die("SQL error: " . $mysqli->error);
}
        
        if(!$stmt->execute()){
            die("SQL error: " . $stmt->error . " Error number: " . $mysqli->errno);
        }
        
        header("Location: index.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css" />
</head>

<body>
    <h1>Verification Page</h1>
    <form method="post" id="verification">

        <input type="text" name="verification_email" id="verification_email"
            placeholder=<?=htmlspecialchars($user['email'])?>>
        <input type="text" name="verification_code" id="verification_code" placeholder="Verification Code?">
        <input type="submit" name="verify_email" value="Verify Email" </input>
    </form>
</body>

</html>