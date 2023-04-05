<?php 
// ambil nilai id dari url
$id = $_GET['id'];
// menampilkan data jenis berdasarkan id
$result = mysqli_query($conn, "SELECT tb_bahan_baku.* , tb_satuan.nama as satuan_stok FROM tb_bahan_baku LEFT JOIN tb_satuan ON tb_satuan.id=tb_bahan_baku.satuan_id WHERE tb_bahan_baku.id = '$id'");
$row = mysqli_fetch_assoc($result);
 
$data_suplier = mysqli_query($conn, "SELECT * FROM tb_supplier ORDER BY id DESC"); 

$beli_detail = mysqli_query($conn, "SELECT *  FROM tb_beli_detail  WHERE bahan_id = '$id' ORDER BY no_po DESC LIMIT 1");
$beli = mysqli_fetch_assoc($beli_detail);

$nama = $row['nama'];
$stok_now = $row['stok'];
$satuan_nama = $row['satuan_stok'];
$status_pengajuan = $beli['status_pengajuan'];
$last_harga = $beli['harga_suplier'];

// jika tombol ubah ditekan
if (isset($_POST['ubah'])) {
  $stok = (int) htmlentities(strip_tags(trim($_POST["stok"])));
  $pesan_error = "";

  // jika tidak terdapat pesan error
  if ($pesan_error == "") {
    $new_stok = $stok_now + $stok;
    $query = mysqli_query($conn, "UPDATE `tb_bahan_baku` SET `stok` = $new_stok WHERE `id` = $id");
    if ($query) {
      echo "
      <script>
        alert('Stok $nama berhasil ditambah');
        window.location.href = '?page=bahan_baku';
      </script>";
    }else{
      // jika gagal disimpan
      $pesan_error .= "Data gagal disimpan !";
    }
// jika ada error
}else{
  $pesan_error .= "Data gagal disimpan !";
}

}else{
  $pesan_error = "";
}

// kode no purchase order
$q = mysqli_query($conn, "SELECT MAX(RIGHT(no_po,4)) AS kd_max FROM tb_beli_detail");
$jml = mysqli_num_rows($q);
$kd = "";
if ($jml > 0) {
while ($result = mysqli_fetch_assoc($q)) {
    $tmp = ((int)$result['kd_max']) + 1;
    $kd = sprintf("%04s", $tmp);
}
} else {
$kd = "0001";
}
$nomor = 'PBN-' . $kd;

//pengajuan
if (isset($_POST['pengajuan_stok'])) {
  $id_suplier = htmlentities(strip_tags(trim($_POST["id_suplier"])));
  $bahan_id = $id;
  $qty = htmlentities(strip_tags(trim($_POST["qty"])));
  $harga = htmlentities(strip_tags(trim($_POST["harga"])));
  $status_pengajuan = "Belum Setuju";
  $tgl_pengajuan = date("Y-m-d H:i");
  $pesan_error = "";
  // input ke tb transaksi
  $sql = "INSERT INTO `tb_beli_detail`(`no_po`, `id_suplier`,`tgl_pengajuan`, `bahan_id`, `qty`, `harga`, `status_pengajuan`, `alasan`) VALUES ('$nomor','$id_suplier','$tgl_pengajuan','$bahan_id','$qty', '$harga','$status_pengajuan', '')";
  $result = mysqli_query($conn, $sql);
  
  if ($result) {
      echo "
      <script>
          alert('Pembelian $nomor berhasil ditambahkan');
          window.location.href = '?page=bahan_baku';
      </script>
      ";
  }else{
      $pesan_error .= "Data gagal disimpan !";
  }

}else{
  $pesan_error = "";
  $supplier_id = "";
  $tgl = "";
  $total = 0;
}

?>

<div class="page-content-wrapper">
  <div class="container-fluid">

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group float-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li class="breadcrumb-item"><a href="index.php">Laundry</a></li>
                        <li class="breadcrumb-item active">Data Bahan Baku</li>
                        <li class="breadcrumb-item active">Tambah Stok Bahan Baku</li>
                    </ol>
                </div>
                <h4 class="page-title">Pengajuan Stok  <?= $nama; ?>  <?= $status_pengajuan; ?> </h4>
            </div>
        </div>
    </div>

    <div class="row">
      <div class="col-12">

        <!-- menampilkan notifikasi pesan error jika ada -->
        <?php if ($pesan_error !== "") : ?>
          <div class="alert alert-danger" role="alert">
            <?= $pesan_error; ?>
          </div>
        <?php endif; ?>

            <form action="" method="post">
                <div class="card m-b-100">
                    <div class="card-body">
                    <?php if($_SESSION['level'] == 'admin' ) : ?>  
                    <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Stok Saat Ini</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" value="<?= $stok_now.' '. $satuan_nama; ?>" disabled="disabled"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Pengajuan Stok</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="number" id="example-text-input" name="stok" step="any"
                                placeholder="Masukkan Stok yang Diajukan" value="<?= $stok; ?>" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Status Pengajuan</label>
                            <div class="col-sm-10">
                                <select name="pengajuan_stok" class="form-control" id="">
                                  <option value="Setuju">Setuju</option>
                                  <option value="Tidak Setuju">Tidak Setuju</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Alasan</label>
                            <div class="col-sm-10">
                                <textarea name="" id="" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="text-right">
                          <a href="?page=bahan_baku" class="btn btn-warning">Kembali</a>
                          <button type="submit" name="ubah" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
      <?php endif; ?>

      <?php if($_SESSION['level'] == 'kasir' ) : ?>  
      

      <div class="form-group row">
          <label for="example-text-input" class="col-sm-2 col-form-label">Stok Saat Ini </label>
          <div class="col-sm-10">
              <input class="form-control" type="text" value="<?= $stok_now.' '. $satuan_nama; ?>" disabled="disabled"/>
          </div>
      </div>
      <div class="form-group row">
        <label for="example-text-input" class="col-sm-2 col-form-label">Pengajuan Stok</label>
        <div class="col-sm-10">
            <input class="form-control" type="number" id="example-text-input" name="qty" step="any"
            placeholder="Masukkan Stok yang Diajukan" value="<?= $stok; ?>" />
        </div>
      </div>
      <div class="form-group row">
        <label for="example-text-input" class="col-sm-2 col-form-label">Suplier</label>
        <div class="col-sm-10">
            <select name="id_suplier" id="" class="form-control">
              <option value="">--Pilih Suplier--</option>
              <?php while ($row = mysqli_fetch_assoc($data_suplier)) : ?>
                <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
              <?php endwhile; ?>
            </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="example-text-input" class="col-sm-2 col-form-label">Estimasi Harga</label>
        <div class="col-sm-10">
            <input class="form-control" type="number" id="example-text-input" name="harga" step="any" value="<?= $last_harga; ?>" placeholder="Masukkan Harga yang Diajukan" />
        </div>
      </div>
      <div class="text-right">
          <a href="?page=bahan_baku" class="btn btn-warning">Kembali</a>
          <button type="submit" name="pengajuan_stok" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
    </form>
  </div>
  <?php endif; ?>
  <!-- end col -->
 
  <!-- end row -->
  </div>
</div>
<br>


