<?php
class AuthController {
    public function login() {
        $user = checkLogin();

        if(isset($_POST['update_name']) && isset($_POST['update_email']) &&  !empty($_POST['update_email'])){
            $updateName = $_POST['update_name'];
            $updateEmail = $_POST['update_email'];
            $updateSql = "UPDATE user SET name = '$updateName', email = '$updateEmail' WHERE id = {$_SESSION['user_id']}";
            $updateResult = $mysqli->query($updateSql);
        }
    
        jsonResponse([
            'status' => true,
            'message' => 'Giriş yapıldı.'
        ])
    }


}