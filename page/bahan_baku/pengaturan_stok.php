

<div class ="page-content-wrapper">
  <div class="container-fluid">

 
<?php
// jika ubah tambah ditekan
if (isset($_POST['ubah'])) {
  $stok_minimal = $_POST["stok_minimal"];
  $id = $_POST["id"];

   $pesan_error = "";

  // update data

   $query = "UPDATE `tb_bahan_baku` SET
      `stok_minimal` = '$stok_minimal'
      
      WHERE `tb_bahan_baku`.`id` = $id
      ";
      $result = mysqli_query($conn, $query);
  
  // cek keberhasilan
  if ($result) {
    echo "
    <script>
      alert('Data dengan nama $id berhasil diambil');
      window.location.href = '?page=bahan_baku&aksi=pengaturan';
    </script>
    ";
  // tidak berhasil, maka menampilkan pesan error
  }else{
    $pesan_error = "data gagal diubah";

}
  }else{
  $pesan_error = "data tidak masuk !";
}

?>

  <div class="row">
      <div class="col-sm-12">
          <div class="page-title-box">
              <div class="btn-group float-right">
                  <ol class="breadcrumb hide-phone p-0 m-0">
                      <li class="breadcrumb-item"><a href="#">Laundry</a></li>
                      <li class="breadcrumb-item active">Data Bahan Baku</li>
                  </ol>
              </div>
              <h4 class="page-title">Pengaturan Stok Minimal Bahan Baku <?= $stok_minimal ?></h4>
          </div>
      </div>
  </div>

    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
          <div class="table-responsive">
            <h4 class="mt-0 header-title">
              <a href="?page=bahan_baku" class="btn btn-primary"> Kembali</a>
            </h4>
            <table id="datatable" class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Satuan</th>
                  <th>Stok Minimal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              <?php 
              // menampilkan data jenis laundry              
              $result = mysqli_query($conn, "SELECT a.*, b.nama as satuan_nama FROM `tb_bahan_baku` as a LEFT JOIN `tb_satuan` as b ON b.id=a.satuan_id"); ?>
              <?php $i = 1; ?>
              <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                  <td><?= $i; ?></td>
                  <td><?= $row['nama']; ?></td>
                  <td><?= $row['satuan_nama']; ?></td>
                  <form action="" method="post">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                  <td><input type="text" class="form-control" name="stok_minimal" value="<?= (is_decimal($row['stok_minimal'])) ? $row['stok_minimal'] : number_format($row['stok_minimal']); ?>"></input></td>
                  <td>
                    <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                  </td>
                   </form>
                </tr>
              <?php $i++; ?>
              <?php endwhile; ?>
              </tbody>
            </table>
          </div>
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
    <!-- end page title end breadcrumb -->
  </div>
  <!-- container -->
</div>
