<?php
include('../includes/db.php');
global $con;
include('../includes/header.php');
?>

<h1>Feed</h1>

<div class='content'>
    <?php
    $sql = "SELECT `username` FROM `connected_users`";
    $result = mysqli_query($con, $sql);
    $username = "";

    while($row = mysqli_fetch_array($result)) {
        $username = $row["username"];
    }

    $sqlImages = "SELECT * FROM `posts` WHERE `username` != ?";
    $stmt = $con->prepare($sqlImages);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()) {
        echo "<h2>User: " . $row["username"] . "</h2>";
        echo "<img src='../images/" . $row["image"] . "'>";
        echo "<p>" . $row["description"] . "</p>";
        echo "<hr><br>";
    }

    $stmt->close();
    ?>
</div>

<?php include('../includes/footer.php'); ?>
