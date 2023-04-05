<?php 
// ambil nilai id dari url
$id = $_GET['no_po'];

 
$data_suplier = mysqli_query($conn, "SELECT * FROM tb_supplier ORDER BY id DESC"); 

$beli_detail = mysqli_query($conn, "SELECT *,  tb_bahan_baku.id as id_bahan_baku,  tb_satuan.nama as satuan_stok, tb_bahan_baku.nama as nama  FROM tb_beli_detail left JOIN  tb_bahan_baku  ON tb_beli_detail.bahan_id = tb_bahan_baku.id LEFT JOIN tb_satuan ON tb_satuan.id=tb_bahan_baku.satuan_id  WHERE tb_beli_detail.no_po = '$id' ");
$beli = mysqli_fetch_assoc($beli_detail);

$nama = $beli['nama'];
$stok_now = $beli['stok'];
$satuan_nama = $beli['satuan_stok'];
$status_pengajuan = $beli['status_pengajuan'];
$id_bahan_baku = $beli['id_bahan_baku'];


// jika tombol ubah ditekan
if (isset($_POST['barang_masuk'])) {
 
    $stok = (int) htmlentities(strip_tags(trim($_POST["barang_datang"])));
    $harga_suplier = (int) htmlentities(strip_tags(trim($_POST["harga_suplier"])));
    $status_pengajuan = "Selesai";
    $pesan_error = "";

  // jika tidak terdapat pesan error
  if ($pesan_error == "") {
    $new_stok = $stok_now + $stok;
    $query = mysqli_query($conn, "UPDATE `tb_bahan_baku` SET `stok` = $new_stok WHERE `id` = $id_bahan_baku");
    
    $query2 = "UPDATE `tb_beli_detail` SET
      `barang_datang` = '$stok',
      `harga_suplier` = '$harga_suplier',
        `status_pengajuan` = '$status_pengajuan'
    WHERE `tb_beli_detail`.`no_po` = '$id'
    ";
    $result = mysqli_query($conn, $query2);

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

                   <h4 class="page-title">Barang Datang :  <?= $nama; ?> </h4>
             
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
                            <label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Pengajuan</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" value="<?= $beli['tgl_pengajuan']?>" disabled="disabled"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Stok Saat Ini</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" value="<?= $stok_now.' '. $satuan_nama; ?>" disabled="disabled"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Pengajuan Stok </label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input class="form-control" type="number" id="example-text-input" name="stok" 
                                    placeholder="Masukkan Stok yang Diajukan" value="<?= $beli['qty']; ?>" />
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><?= $satuan_nama ?></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Suplier</label>
                            <div class="col-sm-10">
                                <select name="id_suplier" id="" class="form-control" >
                                <option value="">--Pilih Suplier--</option>
                                <?php while ($row = mysqli_fetch_assoc($data_suplier)) : ?>
                                    <option value="<?= $row['id']; ?>" <?= $beli['id_suplier'] ==  $row['id'] ? "selected" : null ?>><?= $row['nama']; ?></option>
                                <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Estimasi Harga</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="number" id="example-text-input" name="harga" step="any"
                                placeholder="Masukkan Harga yang Diajukan" value="<?= $beli['harga']; ?>"  />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Status Pengajuan</label>
                            <div class="col-sm-10">
                                <select name="status_pengajuan" class="form-control" id="">
                                  <option value="Setuju">Setuju</option>
                                  <option value="Tidak Setuju">Tidak Setuju</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Alasan</label>
                            <div class="col-sm-10">
                                <textarea name="alasan" id="" class="form-control" required></textarea>
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
          
      <form action="" method="post">
      <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Pengajuan</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" value="<?= $beli['tgl_pengajuan']?>" disabled="disabled"/>
            </div>
        </div>
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
            placeholder="Masukkan Stok yang Diajukan" value="<?= $beli['qty']; ?>" readonly/>
        </div>
      </div>
      <div class="form-group row">
        <label for="example-text-input" class="col-sm-2 col-form-label">Suplier</label>
        <div class="col-sm-10">
            <select name="id_suplier" id="" class="form-control" required disabled >
              <option value="">--Pilih Suplier--</option>
              <?php while ($row = mysqli_fetch_assoc($data_suplier)) : ?>
                <option value="<?= $row['id']; ?>" <?= $beli['id_suplier'] ==  $row['id'] ? "selected" : null ?>><?= $row['nama']; ?></option>
              <?php endwhile; ?>
            </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="example-text-input" class="col-sm-2 col-form-label">Estimasi Harga</label>
        <div class="col-sm-10">
            <input class="form-control" type="number" id="example-text-input" name="harga" step="any"
            placeholder="Masukkan Harga yang Diajukan" value="<?= $beli['harga']; ?>"  readonly/>
        </div>
      </div>
   
      <div class="form-group row">
        <label for="example-text-input" class="col-sm-2 col-form-label">Jumlah Barang Datang</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" id="example-text-input" name="barang_datang" step="any"
            placeholder="Belum Diisi" value="" />
        </div>
      </div>
        <div class="form-group row">
        <label for="example-text-input" class="col-sm-2 col-form-label">Harga Dari Supplier</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" id="example-text-input" name="harga_suplier" step="any"
            placeholder="Belum Diisi" value="" />
        </div>
      </div>
      <div class="text-right">
          <a href="?page=bahan_baku&aksi=sedang_pengajuan&no_po=<?= $id ?>" class="btn btn-warning">Kembali</a>
          <?php if($status_pengajuan == "Setuju"){?>
             <button type="submit" name="barang_masuk" class="btn btn-primary">Simpan</button>
          <?php }  ?>
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


