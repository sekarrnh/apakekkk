<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Komentar</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <style>
        /* CSS untuk menyesuaikan tampilan komentar */
        .comment-item {
            border-bottom: 1px solid #ccc;
            margin-bottom: 20px;
            padding-bottom: 20px;
        }

        .comment-item h5 {
            color: #007bff;
            margin-bottom: 5px;
        }

        .comment-item .comment-content {
            margin-bottom: 10px;
        }

        .comment-item .comment-actions {
            margin-top: 10px;
        }

        .comment-item .comment-actions a {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="page-container">
        <!-- Bagian informasi foto -->
        <div class="card post-container">
            <div class="card-body">
                <?php
                include "koneksi.php";
                $fotoid = $_GET['fotoid'];
                $sql = mysqli_query($conn, "SELECT foto.*, user.username FROM foto INNER JOIN user ON foto.userid=user.userid WHERE foto.fotoid='$fotoid'");
                while ($data = mysqli_fetch_array($sql)) {
                ?>
                <!-- Informasi foto -->
                <div class="post-image">
                    <h2 class="post-title"><?= $data['judulfoto'] ?></h2>
                    <img src="gambar/<?= $data['lokasifile'] ?>" alt="<?= $data['judulfoto'] ?>" style="max-width: 300px;">
                </div>
                <p class="post-description"><?= $data['deskripsifoto'] ?></p>
                <p>Tanggal Unggah: <?= $data['tanggalunggah'] ?> Diunggah oleh: <?= $data['username'] ?></p>
                <?php
                }
                ?>
            </div>
        </div>

        <!-- Form untuk mengirim komentar -->
        <div class="card mb-3">
            <div class="card-body">
                <form action="tambah_komentar.php" method="post">
                    <input type="text" name="fotoid" value="<?= $_GET['fotoid'] ?>" hidden>
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="isikomentar" rows="3"
                            placeholder="Tambah komentar"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>

        <!-- Daftar komentar -->
        <div class="card">
            <div class="card-body">
                <?php
                // Mendapatkan fotoid dari parameter URL
                $fotoid = $_GET['fotoid'];

                // Query untuk mengambil komentar
                $sql = mysqli_query($conn, "SELECT komentarfoto.*, user.namalengkap FROM komentarfoto INNER JOIN user ON komentarfoto.userid=user.userid WHERE komentarfoto.fotoid='$fotoid'");
                
                // Array untuk menyimpan komentar
                $comments = array();

                while ($row = mysqli_fetch_array($sql)) {
                    // Menyimpan komentar dalam array
                    $comments[] = $row;
                }

                // Memutar array agar komentar muncul dari bawah
                $comments = array_reverse($comments);

                // Menampilkan komentar
                foreach ($comments as $comment) {
                ?>
                <div class="comment-item">
                    <!-- Informasi komentar -->
                    <h5><?= $comment['namalengkap'] ?></h5>
                    <p class="comment-content"><?= $comment['isikomentar'] ?></p>
                    <div class="comment-actions">
                        <span class="text-muted"><?= $comment['tanggalkomentar'] ?></span>
                        <?php
                            // Periksa apakah pengguna yang sedang masuk adalah pemilik komentar
                            if ($comment['userid'] == $_SESSION['userid']) {
                                echo "<a href='hapus_komentar.php?id=" . $comment['komentarid'] . "&fotoid=" . $comment['fotoid'] . "
                                'class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus komentar?\")'>Hapus</a>";
                            }
                        ?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
