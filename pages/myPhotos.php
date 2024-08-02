<?php
include('../includes/db.php');
global $con;
include('../includes/header.php');
?>

<h1>My profile</h1>

<?php
$sqlUser = "SELECT `username` FROM `connected_users`";
$resultUser = mysqli_query($con, $sqlUser);
$username = "";

while($row = mysqli_fetch_array($resultUser)) {
    $username = $row["username"];
}

$sqlPhotos = "SELECT * FROM `posts` WHERE `username` = ?";
$stmtPhotos = $con->prepare($sqlPhotos);
$stmtPhotos->bind_param("s", $username);
$stmtPhotos->execute();
$resultPhotos = $stmtPhotos->get_result();

while($row = $resultPhotos->fetch_assoc()) {
    echo "<img src='../images/" . $row["image"] . "'>";
    echo "<p>" . $row["description"] . "</p>";
    echo "<form action='deletePhoto.php' method='POST'>";
    echo "<input type='hidden' name='id' value='" . $row['image'] . "'>";
    echo "<button type='submit'>Delete</button>";
    echo "</form>";
}

$stmtPhotos->close();
?>

<?php include('../includes/footer.php'); ?>
