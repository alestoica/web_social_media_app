<?php
$con = mysqli_connect("localhost", "root", "", "social_media_app");

if (!$con) {
    die("Connection failed: " . $con->connect_error);
}
