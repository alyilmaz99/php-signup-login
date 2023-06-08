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
   
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css" />
</head>

<body>
    <h1>Profile Page</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td><?php echo $user["id"]; ?></td>
                <td><?php echo $user["name"]; ?></td>
                <td><?php echo $user["email"]; ?></td>
            </tr>

        </tbody>
    </table>
    <h2>Update Profile</h2>
    <form action="update-profile.php" method="post" id="profile-update">
        <input type="text" name="update_name" id="update_name" placeholder="<?php echo $user["name"];?>">
        <input type="text" name="update_email" id="update_email" placeholder="<?php echo $user["email"];?>">
        <input type="submit" value="Post">
    </form>
</body>

</html>