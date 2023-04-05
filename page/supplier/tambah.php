<?php 

// jika tambah ditekan
if (isset($_POST['tambah'])) {
  // ambil data dari form
  $nama = htmlentities(strip_tags(trim($_POST["nama_supplier"])));
  $alamat = htmlentities(strip_tags(trim($_POST["alamat_supplier"])));
  $telp = htmlentities(strip_tags(trim($_POST["telp_supplier"])));
  $pesan_error = "";

  // input data ke db
  $query = mysqli_query($conn, "INSERT INTO `tb_supplier` (`nama`, `alamat`, `telp`) VALUES ('$nama', '$alamat', '$telp')");
  
  // dicek
  if ($query) {
    echo "
      <script>
        alert('Data dengan Nama $nama berhasil ditambahkan');
        window.location.href = '?page=supplier';
      </script>
    ";
  }else{
    $pesan_error .= "Data gagal disimpan !";
  }

}else{
  $pesan_error = "";
  $nama = "";
  $alamat = "";
  $telp = "";
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
                      <li class="breadcrumb-item active">Data Supplier</li>
                      <li class="breadcrumb-item active">Tambah Supplier</li>
                  </ol>
              </div>
              <h4 class="page-title">Tambah Supplier</h4>
          </div>
      </div>
  </div>

  <div class="row">
      <div class="col-12">

      <?php if ($pesan_error !== "") : ?>
        <div class="alert alert-danger" role="alert">
          <?= $pesan_error; ?>
        </div>
      <?php endif; ?>

          <form action="" method="post">
          <div class="card m-b-100">
            <div class="card-body">

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                  <input class="form-control"type="text"id="example-text-input" name="nama_supplier" placeholder="Masukkan nama supplier" value="<?= $nama; ?>" required autofocus/>
                </div>
              </div>
           

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                  <textarea class="form-control" id="example-text-input" name="alamat_supplier" cols="20" rows="5" placeholder="Masukkan alamat" required><?= $alamat; ?></textarea>
                </div>
              </div>

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Telp</label>
                <div class="col-sm-10">
                  <input class="form-control" type="number"id="example-text-input" name="telp_supplier" placeholder="Masukkan No.Telp" value="<?= $usertelp; ?>" required/>
                </div>
              </div>

              <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
              <a href="?page=pelanggan" class="btn btn-warning">Kembali</a>
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
