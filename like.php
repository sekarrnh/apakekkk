<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['userid'])) {
    // Jika pengguna belum login, arahkan ke halaman login
    header("location:login.php");
} else {
    $fotoid = $_GET['fotoid'];
    $userid = $_SESSION['userid'];
    
    // Cek apakah pengguna sudah pernah like foto ini atau belum
    $ceksuka = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");

    if (mysqli_num_rows($ceksuka) == 1) {
        // Jika pengguna sudah like, hapus like tersebut
        while ($row = mysqli_fetch_array($ceksuka)) {
            $likeid = $row['likeid'];
            mysqli_query($conn, "DELETE FROM likefoto WHERE likeid='$likeid'");
        }
    } else {
        // Jika pengguna belum like, tambahkan like
        $tanggallike = date("Y-m-d");
        mysqli_query($conn, "INSERT INTO likefoto VALUES('', '$fotoid', '$userid', '$tanggallike')");
    }

    // Setelah proses like selesai, arahkan kembali pengguna ke halaman home
    header("location:home.php");
}
?>
