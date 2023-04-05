<?php 

// ambil nilai id dari url
$id = $_GET['id'];
// menampilkan data jenis berdasarkan id
$result = mysqli_query($conn, "SELECT * FROM tb_bahan_baku WHERE id = '$id'");
$row = mysqli_fetch_assoc($result);

  $nama = $row['nama'];
  $kategori = $row['kategori'];
  $satuan_id = $row['satuan_id'];
  $stok = $row['stok'];

// jika ubah tambah ditekan
if (isset($_POST['ubah'])) {
    $nama = htmlentities(strip_tags(trim($_POST["nama"])));
    $kategori = htmlentities(strip_tags(trim($_POST["kategori"])));
    $satuan_id = ($_POST["satuan_id"]) ? htmlentities(strip_tags(trim($_POST["satuan_id"]))) : "NULL";
    $stok = ($_POST["stok"]) ? htmlentities(strip_tags(trim($_POST["stok"]))) : "NULL";
    $pesan_error = "";

    // mengecek jenis laundry
    // jika jenis laundry yang diinputkan tidak sama dengan nama jenis laundry yg lama, maka 
    if ($row['nama'] !== $nama) {
        // menampilkan data jenis laundry sesuai dengan inputan jenis laundry
        $query_jenis = mysqli_query($conn, "SELECT * FROM tb_bahan_baku WHERE nama = '$nama'");
        $result_jenis = mysqli_num_rows($query_jenis);

        // cek apakah jenis laundry ada yang sama
        if ($result_jenis > 0) {
            $pesan_error = "Bahan baku <b>$nama</b> sudah ada <br>";
        }
    }

  // jika tidak terdapat pesan error
  if ($pesan_error == "") {
    $query = mysqli_query($conn, "UPDATE `tb_bahan_baku` SET `nama` = '$nama', `kategori` = '$kategori', `satuan_id` = $satuan_id, `stok`=$stok WHERE `id` = $id");
    if ($query) {
      echo "
      <script>
        alert('Data bahan baku $nama berhasil diubah');
        window.location.href = '?page=bahan_baku';
      </script>
      ";
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
                      <li class="breadcrumb-item active">Tambah Bahan Baku</li>
                  </ol>
              </div>
              <h4 class="page-title">Ubah Bahan Baku</h4>
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

                      <div class="form-group row">
                          <label for="example-text-input" class="col-sm-2 col-form-label">Nama Bahan Baku</label>
                          <div class="col-sm-10">
                              <input class="form-control" type="text" id="example-text-input" name="nama"
                                  placeholder="Masukkan jenis laundry" value="<?= $nama; ?>" required autofocus />
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="example-text-input" class="col-sm-2 col-form-label">Kategori</label>
                          <div class="col-sm-10">
                                <select class="form-control" name="kategori">
                                    <option value="">Pilih</option>
                                    <option value="Detergen Bubuk" <?= ($kategori == 'Detergen Bubuk') ?? 'Selected="Selected"'; ?> >Detergen Bubuk</option>
                                    <option value="Detergen Cair"  <?= ($kategori == 'Detergen Cair') ?? 'Selected="Selected"'; ?> >Detergen Cair</option>
                                    <option value="Parfum"  <?= ($kategori == 'Parfum') ?? 'Selected="Selected"'; ?>>Parfum</option>
                                </select>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="example-text-input" class="col-sm-2 col-form-label">Satuan Unit Stok</label>
                          <div class="col-sm-10">
                              <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;"
                                  name="satuan_id" id="satuan_id">
                                  <option value="">--Pilih Unit Satuan---</option>
                                  <?php 
                                        $query = mysqli_query($conn, "SELECT * FROM tb_satuan");
                                        while ($result = mysqli_fetch_assoc($query)) :
                                        ?>
                                  <option value="<?= $result['id']; ?>" <?= ($satuan_id == $result['id']) ? "selected": ""; ?>><?= $result['nama']; ?></option>
                                  <?php endwhile; ?>
                              </select>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="example-text-input" class="col-sm-2 col-form-label">Stok</label>
                          <div class="col-sm-10">
                              <input class="form-control" type="number" id="example-text-input" name="stok" step="any"
                                  placeholder="Masukkan nilai operator" value="<?= $stok; ?>" />
                          </div>
                      </div>

                      <button type="submit" name="ubah" class="btn btn-primary">Tambah</button>
                      <a href="?page=jenis" class="btn btn-warning">Kembali</a>
                  </div>
              </div>
          </form>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </div>
</div>
<br>
