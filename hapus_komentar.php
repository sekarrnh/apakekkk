<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['userid'])) {
    header("location:login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location:index.php");
    exit();
}

$komentar_id = $_GET['id'];
$fotoid = isset($_GET['fotoid']) ? $_GET['fotoid'] : '';

$user_id = $_SESSION['userid'];
$sql_check_owner = "SELECT * FROM komentarfoto WHERE komentarid='$komentar_id' AND userid='$user_id'";
$result_check_owner = mysqli_query($conn, $sql_check_owner);

if (mysqli_num_rows($result_check_owner) == 0) {
    header("location:index.php");
    exit();
}

$sql_delete_comment = "DELETE FROM komentarfoto WHERE komentarid='$komentar_id'";
$result_delete_comment = mysqli_query($conn, $sql_delete_comment);

// Debugging statement for $fotoid
echo "fotoid: $fotoid<br>";

// Debugging statement after deletion query
if ($result_delete_comment) {
    echo "Komentar berhasil dihapus<br>";
    // Adding fotoid back to the URL when redirecting
    header("location:komentar.php?fotoid=$fotoid");
} else {
    echo "Gagal menghapus komentar.";
}
?>