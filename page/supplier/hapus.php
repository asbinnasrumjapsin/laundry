<?php

// ambil data &id= dari url
$id = $_GET['id'];

// mengambil data dari tb_supplier berdasarkan id
$query = mysqli_query($conn, "SELECT * FROM tb_supplier WHERE id = $id");
$row = mysqli_fetch_assoc($query);
$username = $row['nama'];

// menghapus data pelanggan
$result = mysqli_query($conn, "DELETE FROM tb_supplier WHERE id = $id");

if ($result) {
  echo "
  <script>
    alert('Data dengan nama $username berhasil dihapus');
    window.location.href = '?page=supplier';
  </script>
";
}

?>