<?php 

// ambil id dari url
$id = $_GET['id'];
$nama = $_GET['nama_pengambil'];
$status_pengambilan = "1";
$tgl_pengambilan =  date("Y-m-d H:i");
$status_pembayaran = "1";

// ubah status pengambilan baju
$query = "UPDATE `tb_laundry` SET
   `nama_pengambil` = '$nama',
   `tgl_pengambilan` = '$tgl_pengambilan',
   `status_pembayaran` = '$status_pembayaran',
   `status_pengambilan` = '$status_pengambilan'
   
   WHERE `tb_laundry`.`id_laundry` = '$id'
   ";
   $result = mysqli_query($conn, $query);

if ($result) {
  echo "
  <script>
    alert('Baju milik ID transaksi $id telah diambil');
    window.location.href = '?page=laundry&aksi=detail&id=$id';
  </script>
";
}
?>