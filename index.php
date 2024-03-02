<?php
include "koneksi.php";
session_start();
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Galeri</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }
    </style>
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
                    <?php if (!$userid) { ?>
                        <a class="nav-link" href="login.php">Login</a>
                        <a class="nav-link" href="register.php">Register</a>
                    <?php } else { ?>
                        <a class="nav-link" href="home.php">Home</a>
                        <a class="nav-link" href="album.php">Album</a>
                        <a class="nav-link" href="foto.php">Foto</a>
                        <a class="nav-link" href="logout.php">Logout</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        <div class="row">
            <?php
            $sql = mysqli_query($conn, "SELECT * from foto INNER JOIN user ON foto.userid=user.userid INNER JOIN album ON foto.albumid=album.albumid");
            while ($data = mysqli_fetch_array($sql)) {
            ?>
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid'] ?>">
                            <img src="gambar/<?= $data['lokasifile'] ?>" class="card-img-top" title="<?php echo $data['judulfoto'] ?>" style="height: 18rem;" alt="">
                        </a>
                        <div class="card-footer text-center">
                            <?php
                            $fotoid = $data['fotoid'];
                            $ceksuka = mysqli_query($conn, "select * from likefoto where fotoid='$fotoid' and userid='$userid'");
                            if (mysqli_num_rows($ceksuka) == 1) { ?>
                                <a href="like.php?fotoid=<?= $data['fotoid'] ?>" name="batalsuka"><i class="fas fa-heart"></i></a>
                            <?php } else { ?>
                                <a href="like.php?fotoid=<?= $data['fotoid'] ?>" name="suka"><i class="far fa-heart"></i></a>
                            <?php }
                            $like = mysqli_query($conn, "select * from likefoto where fotoid='$fotoid'");
                            echo mysqli_num_rows($like) . ' Suka';
                            ?>
                            <a href="komentar.php?fotoid=<?php echo $data['fotoid']; ?>"><i class="far fa-comment"></i></a>
                            <?php
                            $fotoid = $data['fotoid'];
                            $jmlkomentar = mysqli_query($conn, "SELECT COUNT(*) AS total FROM komentarfoto WHERE fotoid='$fotoid'");
                            $jmlkomentar_data = mysqli_fetch_assoc($jmlkomentar);
                            echo $jmlkomentar_data['total'] . ' Komentar';
                            ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
        <p>sekarmiraa</p>
    </footer>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
