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
                    <?php
                    if($row['status_pengambilan'] != 1 ){
                    if( $row['status_pembayaran'] == 1){ ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ambilLaundry">
                            Ambil
                        </button>
                    <?php } else{ ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ambilLaundry">
                        Ambil & Bayar
                    </button>
                    <?php }} ?>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="row mb-2">
                        <div class="col-4"><b>No Order</b></div>
                        <div class="col-8"><?= $row['id_laundry']; ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><b>Konsumen</b></div>
                        <div class="col-8"><?= $row['konsumen']; ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><b>Alamat</b></div>
                        <div class="col-8"><?= $row['alamat']; ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><b>No Telp</b></div>
                        <div class="col-8"><?= $row['telp']; ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><b>Tanggal Transaksi</b></div>
                        <div class="col-8"><?= DateTime::createFromFormat('Y-m-d H:i:s', $row['tgl_terima'])->format('d-m-Y H:i'); ?> WIB</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><b>Tamggal Selesai</b></div>
                        <div class="col-8"><?= DateTime::createFromFormat('Y-m-d', $row['tgl_selesai'])->format('d-m-Y'); ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><b>Kasir</b></div>
                        <div class="col-8"><?= $row['username']; ?></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row mb-2">
                        <div class="col-4"><b>Total Laundry</b></div>
                        <div class="col-8"><?= $row['jml_kilo']; ?> Kg</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><b>Total Harga</b></div>
                        <div class="col-8">Rp <?= number_format($row['totalbayar']); ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><b>Pembayaran</b></div>
                        <div class="col-8"><?= ($row['status_pembayaran'] == 1) ? '<nav class="badge badge-success">Lunas</nav>' : '<nav class="badge badge-danger">Belum Lunas</nav>'; ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><b>Pengambilan</b></div>
                        <div class="col-8"><?= ($row['status_pengambilan'] == 1) ? '<nav class="badge badge-success">Sudah Diambil</nav>' : '<nav class="badge badge-danger">Belum Diambil</nav>'; ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><b>Catatan</b></div>
                        <div class="col-8"><?= $row['catatan']; ?></div>
                    </div>
                    <?php if($row['status_pengambilan'] != 0 ){ ?>
                    <div class="row mb-2">
                        <div class="col-4"><b>Nama Pengambil</b></div>
                        <div class="col-8"><?= $row['nama_pengambil']; ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4"><b>Tamggal Pengambilan</b></div>
                        <div class="col-8"><?= DateTime::createFromFormat('Y-m-d H:i:s', $row['tgl_pengambilan'])->format('d-m-Y H:i'); ?> WIB</div>
                    </div>
                    <?php } ?>
                </div>
            </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="py-1">No</th>
                  <th class="py-1">Nama</th>
                  <th class="py-1">Jumlah</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                 while ($r = mysqli_fetch_assoc($rincian)) : ?>
                <tr>
                  <td class="py-1"><?= $no++; ?></td>
                  <td class="py-1"><?= $r['nama']; ?></td>
                  <td class="py-1"><?= $r['qty']; ?> Pcs</td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
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
<!-- Modal -->
<div class="modal fade" id="ambilLaundry" tabindex="-1" aria-labelledby="ambilLaundry" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="GET">
                <input type="hidden" name="page" value="laundry">
                <input type="hidden" name="aksi" value="diambil">
                <input type="hidden" name="id" value="<?= $row['id_laundry']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ambil Laundry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="example-text-input">Nama Pengambil</label>
                        <input type="text" name="nama_pengambil" class="form-control" required/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
