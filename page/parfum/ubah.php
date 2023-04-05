<?php 

// ambil nilai id dari url
$id = $_GET['id'];
// menampilkan data jenis berdasarkan id
$result = mysqli_query($conn, "SELECT * FROM tb_satuan WHERE id = '$id'");
$row = mysqli_fetch_assoc($result);

  $nama = $row['nama'];
  $operator = $row['operator'];
  $operator_val = $row['operator_val'];
  $parent_id = $row['parent_id'];

// jika tombol ubah ditekan
if (isset($_POST['ubah'])) {
    $nama = htmlentities(strip_tags(trim($_POST["nama"])));
    $operator = ($_POST["operator"]) ? htmlentities(strip_tags(trim($_POST["operator"]))) : "NULL";
    $operator_val = ($_POST["operator_val"]) ? htmlentities(strip_tags(trim($_POST["operator_val"]))) : "NULL";
    $parent_id = ($_POST["parent_id"]) ? htmlentities(strip_tags(trim($_POST["parent_id"]))) : "NULL";
    $pesan_error = "";

    // mengecek jenis laundry
    // jika jenis laundry yang diinputkan tidak sama dengan nama jenis laundry yg lama, maka 
    if ($row['nama'] !== $nama) {
        // menampilkan data jenis laundry sesuai dengan inputan jenis laundry
        $query_jenis = mysqli_query($conn, "SELECT * FROM tb_satuan WHERE nama = '$nama'");
        $result_jenis = mysqli_num_rows($query_jenis);

        // cek apakah jenis laundry ada yang sama
        if ($result_jenis > 0) {
            $pesan_error = "Satuan Unit <b>$nama</b> sudah ada <br>";
        }
    }

  // jika tidak terdapat pesan error
  if ($pesan_error == "") {
    $query = mysqli_query($conn, "UPDATE `tb_satuan` SET `nama` = '$nama', `operator` = '$operator', `operator_val` = $operator_val, `parent_id` = $parent_id WHERE `id` = $id");
    if ($query) {
      echo "
      <script>
        alert('Data satuan $nama berhasil diubah');
        window.location.href = '?page=satuan_unit';
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
                      <li class="breadcrumb-item active">Data Satuan Unit</li>
                      <li class="breadcrumb-item active">Tambah Satuan Unit</li>
                  </ol>
              </div>
              <h4 class="page-title">Tambah Satuan Unit</h4>
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
                          <label for="example-text-input" class="col-sm-2 col-form-label">Nama</label>
                          <div class="col-sm-10">
                              <input class="form-control" type="text" id="example-text-input" name="nama"
                                  placeholder="Masukkan nama satuan" value="<?= $nama; ?>" required autofocus />
                          </div>
                      </div>
                      

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Dasar Satuan</label>
                            <div class="col-sm-10">
                                <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="parent_id" id="parent_id">
                                    <option value="">--Pilih Dasar Satuan---</option>
                                    <?php 
                                        $query = mysqli_query($conn, "SELECT * FROM tb_satuan");
                                        while ($result = mysqli_fetch_assoc($query)) :
                                        ?>
                                        <option value="<?= $result['id']; ?>" <?= ($parent_id == $result['id']) ? "selected": ""; ?> ><?= $result['nama']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                      <div class="form-group row">
                          <label for="example-text-input" class="col-sm-2 col-form-label">Operator</label>
                          <div class="col-sm-10">
                              <select name="operator" class="select2 form-control">
                                <option value="">-- Pilih Operator ---</option>
                                  <option value="*" <?= ($operator == "*") ? "selected": ""; ?>>Kali (*)</option>
                                  <option value="/" <?= ($operator == "/") ? "selected": ""; ?>>Bagi (/)</option>
                              </select>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="example-text-input" class="col-sm-2 col-form-label">Nilai Operator</label>
                          <div class="col-sm-10">
                              <input class="form-control" type="number" id="example-text-input" name="operator_val" step="any"
                                  placeholder="Masukkan nilai operator" value="<?= $operator_val; ?>" />
                          </div>
                      </div>

                      <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                      <a href="?page=satuan_unit" class="btn btn-warning">Kembali</a>
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
