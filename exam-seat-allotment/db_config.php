<?php
$conn = mysqli_connect("localhost", "root", "", "exam_seating");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>