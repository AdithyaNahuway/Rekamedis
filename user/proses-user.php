<?php

session_start();

if (!isset($_SESSION['ssLoginRM'])) {
  header("location: ../otentikasi/index.php");
  exit();
}

require "../config.php";

if (isset($_POST['simpan'])) {
    // Mengamankan data input
    $username    = trim(htmlspecialchars($_POST['username']));
    $nama        = trim(htmlspecialchars($_POST['fullname']));
    $jabatan     = $_POST['jabatan'];
    $alamat      = trim(htmlspecialchars($_POST['alamat']));
    $gambar      = htmlspecialchars($_FILES['gambar']['name']);
    $password    = trim(htmlspecialchars($_POST['password']));
    $password2   = trim(htmlspecialchars($_POST['password2']));

    // Cek apakah username sudah terpakai
    $cekUsername = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE username = '$username'");
    if (mysqli_num_rows($cekUsername) > 0) {
        echo "<script>
          alert('Username sudah terpakai, user baru gagal di registrasi!'); 
          window.location = 'tambah-user.php';
        </script>";
        return;
    }

    // Cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
        alert('Konfirmasi password tidak sesuai, user baru gagal di registrasi!'); 
        window.location = 'tambah-user.php';
      </script>";
      return;
    }

    $pass = password_hash($password, PASSWORD_DEFAULT);

    // Proses upload gambar
    if ($gambar != null) {
        $url   = 'tambah-user.php';
        $gambar = uploadGbr($url); 
    } else {
        $gambar = 'user.jpg';
    }

    // Insert data ke database
    mysqli_query($koneksi, "INSERT INTO tbl_user (username, fullname, password, jabatan, alamat, gambar) VALUES ('$username', '$nama', '$pass', '$jabatan', '$alamat', '$gambar')");

    echo "<script>
        alert('User baru berhasil di registrasi!'); 
        window.location = 'tambah-user.php';
        </script>";
    return;
}
   
// Hapus user
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus-user') {
    $id = $_GET['id'];
    $gbr = $_GET['gambar'];

    mysqli_query($koneksi, "DELETE FROM tbl_user WHERE userid = $id");
    
    // Cek apakah file ada sebelum menghapus
    if ($gbr != 'user.jpg' && file_exists('../asset/gambar/' . $gbr)) {
        unlink('../asset/gambar/' . $gbr);
    }

    echo "<script>
        alert('User berhasil dihapus!'); 
        window.location = 'index.php';
      </script>";
    return;
}

// Update user
if (isset($_POST['update'])) {
    $id          = $_POST['id'];
    $userLama    = trim(htmlspecialchars($_POST['usernameLama']));
    $username    = trim(htmlspecialchars($_POST['username']));
    $nama        = trim(htmlspecialchars($_POST['fullname']));
    $jabatan     = $_POST['jabatan'];
    $alamat      = trim(htmlspecialchars($_POST['alamat']));
    $gambar      = htmlspecialchars($_FILES['gambar']['name']);
    $gbrLama     = htmlspecialchars($_POST['gbrLama']);
  
    $cekUsername = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE username = '$username'");
    
    if ($username !== $userLama){
        if (mysqli_num_rows($cekUsername) > 0) {
            echo "<script>
              alert('Username sudah terpakai, data user gagal di perbarui!'); 
              window.location = 'index.php';
            </script>";
            return;
        }
    }

    if ($gambar != null) {
        $url   = 'index.php';
        $gbrUser = uploadGbr($url); 
        if ($gbrLama !== 'user.jpg' && file_exists('../asset/gambar/' . $gbrLama)) {
           unlink('../asset/gambar/' . $gbrLama);
        }
    } else {
        $gambar = $gbrLama;
    }

    // Update data di database
    mysqli_query($koneksi, "UPDATE tbl_user SET
                            username    = '$username',
                            fullname    = '$nama',
                            jabatan     = '$jabatan',
                            alamat      = '$alamat',
                            gambar      = '$gambar'
                            WHERE userid = $id");

    echo "<script>
        alert('Data user berhasil di perbarui!'); 
        window.location = 'index.php';
        </script>";
    return;
}

// Ganti password
if (isset($_POST['ganti-password'])) {
    $curPass   = trim(htmlspecialchars($_POST['oldPass']));
    $newPass   = trim(htmlspecialchars($_POST['newPass']));
    $confPass  = trim(htmlspecialchars($_POST['confPass']));

    $userLogin = $_SESSION['ssUserRM'];
    $queryUser = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE username = '$userLogin'");
    $dataUser  = mysqli_fetch_assoc($queryUser);

    if ($newPass !== $confPass) {
        echo "<script>
            alert('Password gagal diperbarui, Konfirmasi password tidak sama!'); 
            window.location = '../otentikasi/password.php';
        </script>";
        return;
    }

    if (!password_verify($curPass, $dataUser['password'])) {
        echo "<script>
            alert('Password gagal diperbarui, Password lama tidak cocok.'); 
            window.location = '../otentikasi/password.php';
        </script>";
        return;
    } else {
        $pass = password_hash($newPass, PASSWORD_DEFAULT);
        mysqli_query($koneksi, "UPDATE tbl_user SET password = '$pass' WHERE username = '$userLogin'");
        
        echo "<script>
            alert('Password berhasil diubah'); 
            window.location = '../otentikasi/password.php';
        </script>";
        return true;
    }
}

?>
