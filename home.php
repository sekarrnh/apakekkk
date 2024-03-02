<?php
include "koneksi.php";
session_start();
$userid = $_SESSION['userid'];
if (!isset($_SESSION['userid'])) {
    header("location:login.php");
}
?>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Landing</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">Website Gallery Foto</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto">
                <?php
                if (!isset($_SESSION['userid'])) {
                ?>
                    <a href="register.php" class="btn btn-primary m-1">Register</a>
                    <a href="login.php" class="btn btn-primary m-1">Login</a>
                <?php
                } else {
                ?>
                    <a href="home.php" class="nav-link">Home</a>
                    <a href="album.php" class="nav-link">Album</a>
                    <a href="foto.php" class="nav-link">Foto</a>
                    <a href="logout.php" class="nav-link">Logout</a>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</nav>

    <div class="container mt-3">
        Album:
        <?php
        $album = mysqli_query($conn, "select * from album where userid='$userid'");
        while ($row = mysqli_fetch_array($album)) { ?>
            <a href="home.php?albumid=<?php echo $row['albumid'] ?>" class="btn btn-outline-primary"><?php echo $row['namaalbum'] ?></a>
        <?php } ?>
        <div class="row">
            <?php
            if (isset($_GET['albumid'])) {
                $albumid = $_GET['albumid'];
                $query = mysqli_query($conn, "select * from foto where userid='$userid' and albumid='$albumid'");
                while ($data = mysqli_fetch_array($query)) { ?>
                    <div class="col-md-3 mt-2">
                        <div class="card">
                            <img src="gambar/<?= $data['lokasifile'] ?>" class="card-img-top" title="" style="height: 18rem;" alt="">
                            <div class="card-footer text-center">
                                <?php
                                $fotoid = $data['fotoid'];
                                $ceksuka = mysqli_query($conn, "select * from likefoto where fotoid='$fotoid' and userid='$userid'");
                                if (mysqli_num_rows($ceksuka) == 1) { ?>
                                    <a href="like.php?fotoid=<?= $data['fotoid'] ?>" name="batalsuka"><i class="fa fa-heart"></i></a>
                                <?php } else { ?>
                                    <a href="like.php?fotoid=<?= $data['fotoid'] ?>" name="suka"><i class="fa-regular fa-heart"></i></a>
                                <?php }
                                $like = mysqli_query($conn, "select * from likefoto where fotoid='$fotoid'");
                                echo mysqli_num_rows($like) . ' Suka';
                                ?>
                                <a href="komentar.php?fotoid=<?= $data['fotoid'] ?>"><i class="fa-regular fa-comment"></i></a>
                                <?php
                                 $jmlkomentar = mysqli_query($conn, "SELECT COUNT(*) AS total FROM komentarfoto WHERE fotoid='$fotoid'");
                                 $jmlkomentar_data = mysqli_fetch_assoc($jmlkomentar);
                                 echo $jmlkomentar_data['total'] . ' Komentar';
                                 ?>
                            </div>
                        </div>
                        <br>
                    </div>
                <?php }
            } else {
                $sql = mysqli_query($conn, "select * from foto where userid='$userid'");
                while ($data = mysqli_fetch_array($sql)) {
                ?>
                    <div class="col-md-3 mt-2">
                        <div class="card">
                            <img src="gambar/<?= $data['lokasifile'] ?>" class="card-img-top" title="" style="height: 18rem;" alt="">
                            <div class="card-footer text-center">
                                <?php
                                $fotoid = $data['fotoid'];
                                $ceksuka = mysqli_query($conn, "select * from likefoto where fotoid='$fotoid' and userid='$userid'");
                                if (mysqli_num_rows($ceksuka) == 1) { ?>
                                    <a href="like.php?fotoid=<?= $data['fotoid'] ?>" name="batalsuka"><i class="fa fa-heart"></i></a>
                                <?php } else { ?>
                                    <a href="like.php?fotoid=<?= $data['fotoid'] ?>" name="suka"><i class="fa-regular fa-heart"></i></a>
                                <?php }
                                $like = mysqli_query($conn, "select * from likefoto where fotoid='$fotoid'");
                                echo mysqli_num_rows($like) . ' Suka';
                                ?>
                                <a href="komentar.php?fotoid=<?= $data['fotoid'] ?>"><i class="fa-regular fa-comment"></i></a>
                                <?php
                                 $jmlkomentar = mysqli_query($conn, "SELECT COUNT(*) AS total FROM komentarfoto WHERE fotoid='$fotoid'");
                                 $jmlkomentar_data = mysqli_fetch_assoc($jmlkomentar);
                                 echo $jmlkomentar_data['total'] . ' Komentar';
                                 ?>
                            </div>
                        </div>
                        <br>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>


    <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
        <p>sekarmiraa</p>
    </footer>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>