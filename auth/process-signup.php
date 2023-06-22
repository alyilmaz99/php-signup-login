<?php
ini_set('display_errors', true);
error_reporting(E_ALL);



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'db.php';
require 'vendor/autoload.php';

DB::Init();

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

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'okethis99@gmail.com';
    $mail->Password = 'jdeyxqggmybwxkwq';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->setFrom('okethis@gmail.com', 'Mailer');
    $mail->addAddress($_POST["email"], $_POST["name"]);
    $mail->isHTML(true);
    $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
    $mail->Subject = "Email verification";
    $mail->Body = '<p>Verification code: <b style="font-size: 30px;">' . $verification_code . '</b>
    </p>
    <a href="http://localhost/phplearn/php-signup-login/email-verification.php"> Link</a>
    ';
    $mail->send();

    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (name,email,password_hash,verification_code,email_verified_at)
        VALUES (?,?,?,?,null)";

    $stmt = DB::get()->stmt_init();

    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("ssss", $_POST["name"], $_POST["email"], $password_hash, $verification_code);

    if (!$stmt->execute()) {
        if (DB::get()->errno === 1062) {
            echo "Same email already exists";
        } else {
            die("SQL error: " . $stmt->error . " Error number: " . DB::get()->errno);
        }
    } else {

        header("Location: login.php");
        exit;
    }
} catch (Exception $e ){
    echo 'error :' . '{$mail->ErrorInfo}';

}