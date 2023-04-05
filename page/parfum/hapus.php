<?php 

// menangkap nilai id dari url
$id = $_GET['id'];
// mengambil data dari tb_jenis berdasarkan id
$query = mysqli_query($conn, "SELECT * FROM tb_satuan WHERE id = $id");
$row = mysqli_fetch_assoc($query);
$nama = $row['nama'];

// menghapus data jenis laundry
$result = mysqli_query($conn, "DELETE FROM tb_satuan WHERE id = $id");

if ($result) {
  echo "
  <script>
    alert('Data satuan $nama berhasil dihapus');
    window.location.href = '?page=satuan_unit';
  </script>
";
}

?>