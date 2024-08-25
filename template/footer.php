</div>
</div>
<script src="<?= $main_url ?>asset/dist/js/bootstrap.bundle.min.js"></script>
     
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>

<?php

$bln_ini = date('n');
$thn_ini = date('Y');
$list_data = [];

for ($i = 1; $i <= $bln_ini; $i++) { 
    $rm_yearly = mysqli_query($koneksi, "SELECT * FROM tbl_rekamedis WHERE tgl_rm BETWEEN '$thn_ini-$i-01' AND '$thn_ini-$i-31'");
    $list_data[] = mysqli_num_rows($rm_yearly);
}

?>

<script>
    /* globals Chart:false */

    let blnSkrg = <?= $bln_ini ?>;

    let nmBln = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
     
    let listBln = [];

    for (let i = 0; i < blnSkrg; i++) {
       listBln.push(nmBln[i]);
    }

(() => {
  'use strict'

  // Graphs
  const ctx = document.getElementById('myChart');
  
  const myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: listBln,
      datasets: [{
           data: <?= json_encode($list_data) ?>,
        lineTension: 0,
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        borderWidth: 4,
        pointBackgroundColor: '#007bff'
      }]
    },
    options: {
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          boxPadding: 3
        }
      }
    }
  });
})();

</script>

<script>
    let table = new DataTable('#myTable');
</script>

</body>
</html>
