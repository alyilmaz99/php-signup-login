<?php
session_start();
ini_set('display_errors', true);
error_reporting(E_ALL);
require_once 'db.php';
require_once 'global.php';

DB::Init();

if (isset($_SESSION['user_id']) ) {
    
    if( !isset($user)){
        $user = checkLogin();
    }
    
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $verification_email = $_POST['verification_email'];
    $verification_code = $_POST['verification_code'];
    if($verification_code == $user['verification_code'] && $verification_email == $user['email']) {
        $updateSql = "UPDATE user SET email_verified_at = NOW() WHERE id = {$user['id']}";
    $result = DB::get() ->query($updateSql);
    $stmt = DB::get()-> stmt_init();
if (!$stmt->prepare($updateSql)) {
    die("SQL error: " . DB::get()->error);
}
        if(!$stmt->execute()){
            die("SQL error: " . $stmt->error . " Error number: " . DB::get()->errno);
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