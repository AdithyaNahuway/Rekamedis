<?php

session_start();

if (!isset($_SESSION['ssLoginRM'])) {
    header("location: ../otentikasi/index.php");
    exit();
}

require "../config.php";

// tambah pasien baru
if (isset($_POST['simpan'])) {
    $nama       = trim(htmlspecialchars($_POST['nama']));
    $tgl_lahir  = $_POST['tgl_lahir'];
    $gender     = $_POST['gender'];
    $telpon     = trim(htmlspecialchars($_POST['telpon']));
    $alamat     = trim(htmlspecialchars($_POST['alamat']));
    $id         = date('ymdhis');

    // Validasi input
    if (empty($nama) || empty($tgl_lahir) || empty($gender) || empty($telpon) || empty($alamat)) {
        echo "<script>
                alert('Semua field harus diisi!');
                window.history.back();
              </script>";
        exit();
    }

    // Prepared statements
    $stmt = $koneksi->prepare("INSERT INTO tbl_pasien (id, nama, tgl_lahir, gender, telpon, alamat) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo "<script>
                alert('Terjadi kesalahan dalam persiapan query.');
                window.history.back();
              </script>";
        exit();
    }
    $stmt->bind_param("ssssss", $id, $nama, $tgl_lahir, $gender, $telpon, $alamat);

    if ($stmt->execute()) {
        echo "<script>
                alert('Pasien baru berhasil di registrasi!');
                window.location = 'tambah-pasien.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal registrasi pasien baru. Silakan coba lagi.');
                window.history.back();
              </script>";
    }

    $stmt->close();
    $koneksi->close();
}

// Hapus user
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus-pasien') {
    $id = $_GET['id'];

    if (mysqli_query($koneksi, "DELETE FROM tbl_pasien WHERE id = '$id'")) {
        echo "<script>
                alert('Pasien berhasil dihapus!');
                window.location = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus pasien. Silakan coba lagi.');
                window.history.back();
              </script>";
    }
}

// update pasien
if (isset($_POST['update'])) {
    $nama       = trim(htmlspecialchars($_POST['nama']));
    $tgl_lahir  = $_POST['tgl_lahir'];
    $gender     = $_POST['gender'];
    $telpon     = trim(htmlspecialchars($_POST['telpon']));
    $alamat     = trim(htmlspecialchars($_POST['alamat']));
    $id         = trim(htmlspecialchars($_POST['id']));

    // Validasi input
    if (empty($nama) || empty($tgl_lahir) || empty($gender) || empty($telpon) || empty($alamat)) {
        echo "<script>
                alert('Semua field harus diisi!');
                window.history.back();
              </script>";
        exit();
    }

    $query = "UPDATE tbl_pasien SET 
              nama      = '$nama', 
              tgl_lahir = '$tgl_lahir',  
              gender    = '$gender', 
              telpon    = '$telpon',
              alamat    = '$alamat'
              WHERE id ='$id'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Data pasien berhasil diperbarui!');
                window.location = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data pasien. Silakan coba lagi.');
                window.history.back();
              </script>";
    }

    $koneksi->close();
}
?>
