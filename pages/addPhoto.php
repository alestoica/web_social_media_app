<?php
include('../includes/db.php');
global $con;
include('../includes/header.php');
?>

<h1>New post</h1>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
    <input type="file" name="image" required>
    <label for="text">Description</label>
    <textarea id="text" cols="40" rows="2" name="description"></textarea>
    <button type="submit" name="upload">Upload</button>
</form>

<?php
if (isset($_POST['upload'])) {
    $image = $_FILES['image']['name'];
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $target = "../images/".basename($image);

    $sql="SELECT `username` FROM `connected_users`";
    $result = mysqli_query($con, $sql);
    $username = "";

    while($row = mysqli_fetch_array($result)) {
        $username = $row["username"];
    }

    $sql = "INSERT INTO posts (username, image, description) VALUES (?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sss", $username, $image, $description);

    if ($stmt->execute() && move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
    } else {
        $msg = "Failed to upload image";
    }

    echo $msg;
    $stmt->close();
}
?>

<?php include('../includes/footer.php'); ?>
