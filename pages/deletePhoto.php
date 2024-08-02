<?php
include('../includes/db.php');
global $con;

$image = $_POST["id"];

$stmt = $con->prepare("DELETE FROM `posts` WHERE `image` = ?");

if ($stmt) {
    $stmt->bind_param("s", $image);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: myPhotos.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Error preparing statement: " . $con->error;
}

mysqli_close($con);
