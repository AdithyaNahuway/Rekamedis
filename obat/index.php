<?php

session_start();

if (!isset($_SESSION['ssLoginRM'])) {
  header("location: ../otentikasi/index.php");
  exit();
}

require "../config.php";

$title = "Obat - Rekam Medis";

require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";


$msg = isset($_GET['msg']) ? $_GET['msg'] : '';

$alert = "";
if ($msg == 'deleted') {
  $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong><i class="bi bi-bag-check-fill align-top"></i> Hapus data obat berhasil.</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
} elseif ($msg == 'updated') {
  $alert = '<div class="alert alert-success alert-dismissible fade show updated" role="alert">
    <strong><i class="bi bi-bag-check-fill align-top"></i> Edit data obat berhasil.</strong>
  </div>';
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 min-vh-100">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Obat</h1>
  </div>
  <?php 
  if ($msg !== '') {
    echo $alert;
  } 
  ?>

  <a href="<?= $main_url ?>obat/tambah-obat.php" class="btn btn-outline-secondary btn-sm mb-3" title="Tambah Obat Baru"><i class="bi bi-plus-lg align-top"></i> Obat Baru</a>

  <table class="table table-responsive table-hover" id="myTable">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Obat</th>
        <th>Kegunaan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $queryObat = mysqli_query($koneksi, "SELECT * FROM tbl_obat");
        while ($obat = mysqli_fetch_assoc($queryObat)) { ?>
          <tr>
            <td><?= htmlspecialchars($no++); ?></td>
            <td><?= htmlspecialchars($obat['nama']); ?></td>
            <td><?= htmlspecialchars($obat['kegunaan']); ?></td>
            <td class= col-2>
              <a href="edit-obat.php?id=<?= htmlspecialchars($obat['id']); ?>" class="btn btn-sm btn-outline-warning" title="Edit Obat"><i class="bi bi-pen align-top"></i></a>
              <a href="proses-obat.php?id=<?= htmlspecialchars($obat['id']); ?>&aksi=hapus-obat" onclick="return confirm('Anda yakin mau menghapus obat ini?')" class="btn btn-sm btn-outline-danger" title="Hapus Obat"><i class="bi bi-trash align-top"></i></a> 
            </td>
          </tr>
        <?php }?>
    </tbody>
  </table>
</main>

<script>
  window.setTimeout(function() {
    $('.updated').fadeOut();
  }, 5000);
</script>

<?php

require "../template/footer.php";

?>
