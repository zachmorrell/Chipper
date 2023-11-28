<?php

// Database connection hosted outside the publicly available directory.
require('../../../config/db_connect.php');
session_start();

// Query for the highest id
$check_db = "SELECT MAX(imageID) AS max_id FROM images";
$result = $db->prepare($check_db);
$result->execute();

$row = $result->fetch(PDO::FETCH_ASSOC);

$uploadedImage = $_POST['image'];
$decodedImage = base64_decode($uploadedImage);
$content_name = $_POST['content_name'];
$new_file_name = $row['max_id'] + 1 . '.png';
$username = $_SESSION['username'];
$is_meme = $_POST['is_meme'];

// Get user id based on username.
$get_user_id = "SELECT userID FROM users WHERE username = :username";
$sql_statement = $db->prepare($get_user_id);
$sql_statement->bindParam(':username', $username);
$sql_statement->execute();
// Fetch the rows into an array
$rows = $sql_statement->fetchAll(PDO::FETCH_ASSOC);
$row_count = count($rows);

if ($row_count == 1) {
    try {
        $user_id = $rows[0]['userID'];
        // Upload to Database and images folder.
        file_put_contents("../../images/user_images/{$new_file_name}", $decodedImage);
        $insert_img_ref = "INSERT INTO images (imageName, img_name, userID, isMeme) VALUES (:imageName, :img_name, :user_id, :isMeme)";
        $sql_statement = $db->prepare($insert_img_ref);
        $sql_statement->bindParam(':imageName', $content_name);
        $sql_statement->bindParam(':img_name', $new_file_name);
        $sql_statement->bindParam(':user_id', $user_id);
        $sql_statement->bindParam(':isMeme', $is_meme);
        $sql_statement->execute();
    } catch(Exception $e) {
        error_log("ERROR: " . $e->getMessage());
    }
}
?>

