<?php 

$id = $_GET['id'];

// menghapus data transaksi laundry
$q1 = "SELECT * FROM `tb_beli` WHERE `id`= '$id'";
$r1 = mysqli_query($conn, $query); 
$beli = mysqli_fetch_assoc($r1);


// $q2 = mysqli_query($conn, "SELECT * FROM tb_beli_detail WHERE beli_id=$id");
// while ($r = mysqli_fetch_assoc($q2)):

// endwhile;
$result = mysqli_query($conn, "DELETE FROM tb_beli WHERE id=$id");


if ($result) {
  echo "
  <script>
    alert('Data Transaksi berhasil dihapus');
    window.location.href = '?page=pembelian';
  </script>
";
}

?>