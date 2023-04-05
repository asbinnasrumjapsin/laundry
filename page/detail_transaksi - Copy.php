<?php
  $id = $_GET['id'];
  // menampilkan data transaksi (join 4 tabel)
  
  $result = mysqli_query($conn, "SELECT * FROM `tb_laundry` INNER JOIN `tb_users` ON `tb_users`.`userid` = `tb_laundry`.`userid` INNER JOIN `tb_jenis` ON `tb_jenis`.`kd_jenis` = `tb_laundry`.`kd_jenis` WHERE `tb_laundry`.`id_laundry` = '$id'"); 
  $row = mysqli_fetch_assoc($result);

  $rincian = mysqli_query($conn, "SELECT * FROM tb_laundry_detail WHERE id_laundry='$id'");

  //ubah transaksasi menjadi diambil/ lunas
  // menamgkap data dari form
  if (isset($_POST['ubah'])) {
  $nama_pengambil = $_POST["nama_pengambil"];
  $status_pengambilan = "1";
  $tgl_pengambilan =  date("Y-m-d");
  $status_pembayaran = "1";
 
  $pesan_error = "";

  // update data

   $query = "UPDATE `tb_laundry` SET
      `nama_pengambil` = '$nama_pengambil',
      `tgl_pengambilan` = '$tgl_pengambilan',
      `status_pembayaran` = '$status_pembayaran',
      `status_pengambilan` = '$status_pengambilan'
      
      WHERE `tb_laundry`.`id_laundry` = '$id'
      ";
      $result = mysqli_query($conn, $query);

  
  // cek keberhasilan
  if ($result) {
    echo "
    <script>
      alert('Data dengan nama $id berhasil diambil');
      window.location.href = '?page=laundry';
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



<div class ="page-content-wrapper">
<div class="container-fluid">

  <div class="row">
  <div class="col-sm-12">
          <div class="page-title-box">
              <div class="btn-group float-right">
                  <ol class="breadcrumb hide-phone p-0 m-0">
                      <li class="breadcrumb-item"><a href="#">Laundry</a></li>
                      <li class="breadcrumb-item active">Detail Transaksi Laundry</li>
                  </ol>
              </div>
              <h4 class="page-title">Detail Transaksi Laundry</h4>
          </div>
      </div>
  </div>

    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="my-auto">
                    <b>Tanggal : </b> <?= date('Y-m-d'); ?></div>
                </div>
                <div class="col-6 text-right">
                    <a href="page/cetak_transaksi.php?id=<?= $row['id_laundry']; ?>" class="btn btn-success" target="_blank"><i class="fa fa-download"> Cetak</i></a>
                    <?php if($row['status_pembayaran'] == 1) { ?>
                        <a href="?page=laundry&aksi=hapus&id=<?= $row['id_laundry']; ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin untuk menghapus ?');">
                        <i class="fa fa-trash-o"></i> Hapus</a>
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-6"><b>No Order</b></div>
                        <div class="col-6"><?= $row['id_laundry']; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-6"><b>Konsumen</b></div>
                        <div class="col-6"><?= $row['konsumen']; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-6"><b>Alamat</b></div>
                        <div class="col-6"><?= $row['alamat']; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-6"><b>Tanggal Transaksi</b></div>
                        <div class="col-6"><?= $row['tgl_terima']; ?></div>
                    </div>
                </div>
                <div class="col-6">

                </div>
            </div>
          <table class="table table-bordered mt-1">
            <tr>
              <th>No. Order</th>
              <td><?= $row['id_laundry']; ?></td>
            </tr>
            <tr>
              <th>Konsumen</th>
              <td><?= $row['konsumen']; ?></td>
            </tr>
            <tr>
              <th>Alamat</th>
              <td><?= $row['alamat']; ?></td>
            </tr>
           
            </tr>
            <tr>
              <th>No. Telp</th>
              <td><?= $row['telp']; ?></td>
            </tr>
            <tr>
              <th>Tanggal Transaksi</th>
              <td><?= $row['tgl_terima']; ?></td>
            </tr>
            <tr>
              <th>Tanggal Selesai</th>
              <td><?= $row['tgl_selesai']; ?></td>
            </tr>
            <tr>
              <th>Catatan Laundry</th>
              <td><?= $row['catatan']; ?></td>
            </tr>
            <tr>
              <th>Status Pembayaran</th>
              <td><?= ($row['status_pembayaran'] == 1) ? '<nav class="badge badge-success">Lunas</nav>' : '<nav class="badge badge-danger">Belum Lunas</nav>'; ?></td>
            </tr>
            <tr>
              <th>Status Pengambilan Baju</th>
              <td><?= ($row['status_pengambilan'] == 1) ? '<nav class="badge badge-success">Sudah Diambil</nav>' : '<nav class="badge badge-danger">Belum Diambil</nav>'; ?></td>
            </tr>
            <tr>
              <th>Kasir</th>
              <td><?= $row['username']; ?></td>
            </tr>
            <form action="" method="post">
            <tr>
              <th>Nama Pengambil</th>
              <td>
                <?php if($row['status_pengambilan'] != 1 ){ ?>
                <textarea name="nama_pengambil" id="" class="form-control"><?= $row['konsumen'] ?></textarea>
                <?php }else{ ?>
                  <?= $row['nama_pengambil'] ?>
                <?php } ?>
              </td>
            </tr>
          </table>

          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Jumlah</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($r = mysqli_fetch_assoc($rincian)) : ?>
                <tr>
                  <td><?= "1"; ?></td>
                  <td><?= $r['nama']; ?></td>
                  <td><?= $r['qty']; ?></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
          <div class="text-right">
            <!--
            <a href="page/cetak_transaksi.php?id=<?= $row['id_laundry']; ?>" class="btn btn-primary" target="_blank">Cetak Invoice</a>
            -->
            <?php
            if($row['status_pengambilan'] != 1 ){
            if( $row['status_pembayaran'] == 1){ ?>
              <button type="submit" name="ubah" class="btn btn-primary">Sudah Diambil</button>
            <?php } else{ ?>
              <button type="submit" name="ubah" class="btn btn-primary">Sudah Diambil & Lunas</button>
            <?php }} ?>
          </div>
          </form>
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
