<?php

session_start();

if (!isset($_SESSION['ssLoginRM'])) {
  header("location: ../otentikasi/index.php");
  exit();
}

require "../config.php";

$title = "Tambah Data - Rekam Medis";

require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";

// fungsi penomoran otomatis
// RM-OO1-080824

$today = date('dmy');
$queryNo = mysqli_query($koneksi, "SELECT max(no_rm) as maxno FROM 
tbl_rekamedis WHERE right(no_rm, 6) = '$today'");
$dataNo = mysqli_fetch_assoc($queryNo);
$noRM   = $dataNo['maxno'];

$noUrut  = (int) substr($noRM, 3, 3);

$noUrut++;

$noRM = 'RM-' . sprintf("%03s", $noUrut) . '-' . date('dmy');

if (isset($_GET['msg'])) {
  $msg = $_GET['msg'];
}else{
   $msg = '';
}

$alert = "";
if ($msg == 'added') {
   $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
 <strong><i class="bi bi-bag-check-fill aligh-top"></i>  Tambah data rekam medis berhasil..</strong>
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}


?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 min-vh-100">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Data Perekaman</h1>
    <a href="<?= $main_url ?>rekamedis" class="text-decoration-none">
      <i class="bi bi-arrow-left-square align-top"></i> Kembali
    </a>
  </div>

  <form action="proses-data.php" method="post">
    <div class="row">
      <?php if ($msg !== '') {
        echo $alert;
      }?>
      <div class="col-lg-6 pe-4">
        <div class="form-group mb-3">
          <label for="no" class="form-label">No Rekam Medis</label>
          <input type="text" name="no_rm" class="form-control" id="no_rm" value="<?=$noRM ?>"
          readonly>
        </div>  
        <div class="form-group mb-3">
          <label for="tgl" class="form-label">No Perekaman </label>
          <input type="date" name="tgl" class="form-control" id="tgl" 
          value="<?= date('Y-m-d') ?>">
        </div>  
        <div class="form-group mb-3">
          <label for="pasien" class="form-label">Pasien </label>
          <div class="input-group mb-3">
          <input type="text" class="form-control" id="pasien_id" name="id" placeholder="ID Pasien" readonly>
          <button class="btn btn-outline-secondary" type="button"
           id="cari" data-bs-toggle="modal" data-bs-target="#modalPasien">
           <i class="bi bi-search align-top"></i>
          </button>
          </div>
           <input type="text" id="namaPasien" class="form-control border-0 border-bottom mb-3"
           placeholder="nama pasien" readonly>
           <textarea name="" id="alamatPasien" class="form-control border-0 order-bottom"
           placeholder="alamat-pasien" rows="1" readonly></textarea>
        </div>  
        <div class="form-group mb-3">
          <label for="keluhan" class="form-label">Keluhan</label>
          <textarea name="keluhan" id="keluhan" class="form-control"
          placeholder="keluhan pasien tentang penyakitnya"></textarea>
          </div>     
        </div>
         <div class="col-lg-6 border-start ps-4">
         <div class="form-group mb-3">
          <label for="dokter" class="form-label">Dokter</label>
          <select name="dokter" id="dokter" class="form-select">
            <option value="">-- Pilih Dokter --</option>
            <?php
            $queryDokter = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE jabatan = 3");
            while ($data = mysqli_fetch_assoc($queryDokter)) { ?>
               <option value="<?= $data['userid'] ?>"> <?= $data['fullname'] ?></option>
            <?php }?>
             </select>
          </div>  
          <div class="form-group mb-3">
                <label for="diagnosa" class="form-label">Diagnosa</label>
                <textarea name="diagnosa" id="diagnosa" class="form-control"
                placeholder="hasil diagnosa dokter"></textarea>
          </div>     
          <div class="form-group mb-3">
                <label for="obat" class="form-label">Obat (Pisahkan dengan koma)</label>
                <input type="text" name="obat" class="form-control" id="tokenfield"/>
          </div>  

          <button type="reset" class="btn btn-outline-danger btn-sm">
          <i class="bi bi-x-lg align-top"></i> Reset
          </button>
          <button type="submit" name="simpan" class="btn btn-outline-primary btn-sm">
          <i class="bi bi-save align-top"></i> Simpan</button>
         </div>
      </div>
  </form>

  <!-- Modal -->
<div class="modal fade" id="modalPasien" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <h3>Cari Pasien</h3>
        <table class="table table-responsive table-hover" id="myTable">
           <thead>
            <tr>
                <th>No</th>
                <th>ID Pasien</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Pilih</th>
            </tr>
           </thead>
           <tbody>
            <?php   
            $no = 1;
            $queryPasien = mysqli_query($koneksi, "SELECT * FROM tbl_pasien");
            while ($pasien = mysqli_fetch_assoc($queryPasien)) { ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $pasien['id'] ?></td>
                    <td><?= $pasien['nama'] ?></td>
                    <td><?= $pasien['alamat'] ?></td>
                    <td>
                        <button type="button" title="pilih pasien" id="cekPasien" data-id="<?= $pasien['id'] ?>"
                        data-namapasien="<?= $pasien['nama'] ?>" data-address="<?= $pasien['alamat'] ?>" class="btn btn-sm btn-outline-primary cekPasien">
                        <i class="bi bi-check-lg align-top"></i></button>
                    </td>
                </tr>
                <?php } ?>
           </tbody>
        </table>
      </div>   
    </div>
  </div>
</div>
</main>


<!-- tokenfield js -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>

<script>
    $(document).ready(function () {
      $(document).on('click' , '.cekPasien', function () {
        let pasienID = $(this).data('id');
        let pasienName = $(this).data('namapasien');
        let pasienAddress = $(this).data('address');
        $('#pasien_id'). val(pasienID);
        $('#namaPasien'). val(pasienName);
        $('#alamatPasien'). val(pasienAddress);

        $('#modalPasien').modal('hide');
      })

        <?php 
         $queryObat = mysqli_query($koneksi, "SELECT * FROM tbl_obat");
         while ($data = mysqli_fetch_assoc($queryObat)) {
            $nmObat[] = $data['nama'];
         }
        ?>
        $('#tokenfield').tokenfield({
            autocomplete: {
            source: [<?php echo '"' . implode('", "', $nmObat) . '"' ?>],
            delay: 100
        },
    showAutocompleteOnFocus: true
    })

    })
</script>

<?php

require "../template/footer.php";

?>
