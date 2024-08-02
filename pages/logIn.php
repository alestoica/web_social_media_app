<?php
include('../includes/db.php');
global $con;
include('../includes/header.php');
?>

<h1>Login</h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data">
    <label for="username">Username</label>
    <input id="username" type="text" name="username" required>
    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    <button type="submit">Login</button>
</form>

<?php
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);

    if (preg_match("/^[a-zA-Z][a-zA-Z0-9-_.]{0,20}$/", $username)) {
        $sql = "SELECT COUNT(*) FROM `users` WHERE `username` = ? AND `password` = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count == 1) {
            $sqlUpdate = "UPDATE `connected_users` SET `username` = ? WHERE `id` = 1";
            $stmtUpdate = $con->prepare($sqlUpdate);
            $stmtUpdate->bind_param("s", $username);

            if ($stmtUpdate->execute()) {
                $stmtUpdate->close();
                header("Location: myPhotos.php");
            } else {
                echo "Error: " . $sqlUpdate . "<br>" . $stmtUpdate->error;
            }
        } else {
            echo "Username or password are wrong!";
        }
    }
}
?>

<?php include('../includes/footer.php'); ?>
