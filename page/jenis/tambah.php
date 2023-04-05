<?php 

// jika tombol tambah ditekan
if (isset($_POST['tambah'])) {
  $jenis_laundry = htmlentities(strip_tags(trim($_POST["jenis_laundry"])));
  $lama_proses = htmlentities(strip_tags(trim($_POST["lama_proses"])));
  $tarif = htmlentities(strip_tags(trim($_POST["tarif"])));
  $material = $_POST["material"];
  $pesan_error = "";

  // mengecek apakah ada jenis laundry yg sama
  $query_jenis = mysqli_query($conn, "SELECT * FROM tb_jenis WHERE jenis_laundry = '$jenis_laundry'");
  $result_jenis = mysqli_num_rows($query_jenis);
  if ($result_jenis > 0) {
    $pesan_error .= "Jenis <b>$jenis_laundry</b> sudah ada <br>";
  }

  // jika tidak ada error
  if ($pesan_error == "") {

    $resHead = mysqli_query($conn, "INSERT INTO `tb_jenis` (`jenis_laundry`, `lama_proses`, `tarif`) VALUES ('$jenis_laundry', '$lama_proses', '$tarif')");
    $sql = "";
    if(count($material)){
        foreach($material as $m){

            $last_id = mysqli_insert_id($conn);

            $bahan_id = $m['bahan_baku'];
            $satuan_id = $m['satuan'];
            $nilai = $m['nilai'];

            $sql .= "INSERT INTO `tb_jenis_bahan` (`jenis_id`, `bahan_id`, `satuan_id`, `nilai`) VALUES ($last_id, $bahan_id, $satuan_id, $nilai);";
        }
    }
    // echo $sql;
    $query = mysqli_multi_query($conn, $sql);
    
    if ($query) {
      echo "
      <script>
        alert('Data dengan jenis $jenis_laundry berhasil ditambahkan');
        window.location.href = '?page=jenis';
      </script>
      ";

    // jika ada error
    }else{
      $pesan_error .= "Data gagal disimpan !";
    }
    
  }else{
    $pesan_error .= "Data gagal disimpan !";
  }

}else{
  $pesan_error = "";
  $jenis_laundry = "";
  $lama_proses = "";
  $tarif = "";
  $material = [];
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
                      <li class="breadcrumb-item active">Data Jenis Laundry</li>
                      <li class="breadcrumb-item active">Tambah Jenis Laundry</li>
                  </ol>
              </div>
              <h4 class="page-title">Tambah Jenis Laundry</h4>
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
                <label for="example-text-input" class="col-sm-2 col-form-label">Jenis Layanan Laundry</label>
                <div class="col-sm-10">
                  <input class="form-control"type="text"id="example-text-input" name="jenis_laundry" placeholder="Masukkan jenis laundry" value="<?= $jenis_laundry; ?>" required autofocus/>
                </div>
              </div>

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Lama Proses (hari)</label>
                <div class="col-sm-10">
                  <input class="form-control"type="number" id="example-text-input" name="lama_proses" placeholder="Masukkan lama proses" value="<?= $lama_proses; ?>" required/>
                </div>
              </div>     

              <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">Tarif (Per Kg)</label>
                <div class="col-sm-10">
                  <input class="form-control" type="number" id="example-text-input" name="tarif" placeholder="Masukkan tarif" value="<?= $tarif; ?>" required/>
                </div>
              </div>

              <table class="table table-bordered" id="bahan_baku">
                <thead>
                    <tr>
                        <th>Bahan Baku</th>
                        <th>Satuan</th>
                        <th>Nilai</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="0">
                        <td>
                            <select class="form-control" name="material[0][bahan_baku]">
                                <option value="">Pilih</option>
                                <?php 
                                    $query = mysqli_query($conn, "SELECT * FROM tb_bahan_baku");
                                    while ($result = mysqli_fetch_assoc($query)) :
                                    ?>
                                    <option value="<?= $result['id']; ?>"><?= $result['nama']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" name="material[0][satuan]">
                                <option value="">Pilih</option>
                                <?php 
                                    $query = mysqli_query($conn, "SELECT * FROM tb_satuan");
                                    while ($result = mysqli_fetch_assoc($query)) :
                                    ?>
                                    <option value="<?= $result['id']; ?>"><?= $result['nama']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="material[0][nilai]">
                        </td>
                        <td>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <button type="button" class="btn btn-primary btn-block" onclick="add_row();">
                                Tambah
                            </button>
                        </td>
                    </tr>
                </tfoot>
              </table>

              <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
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
<script>
    function add_row()
    {
        $rowno= ($("#bahan_baku tbody tr").length == 1) ? 0 : 1;
        $rowno=$rowno+1;
        $row = "<tr id='row"+$rowno+"'>";
        $row += `<td>
                <select class="form-control" name="material[${ $rowno }][bahan_baku]">
                    <option value="">Pilih</option>
                    <?php 
                        $query = mysqli_query($conn, "SELECT * FROM tb_bahan_baku");
                        while ($result = mysqli_fetch_assoc($query)) :
                        ?>
                        <option value="<?= $result['id']; ?>"><?= $result['nama']; ?></option>
                    <?php endwhile; ?>
                </select>
            </td>`;
        $row += `<td>
                <select class="form-control" name="material[${ $rowno }][satuan]">
                    <option value="">Pilih</option>
                    <?php 
                        $query = mysqli_query($conn, "SELECT * FROM tb_satuan");
                        while ($result = mysqli_fetch_assoc($query)) :
                        ?>
                        <option value="<?= $result['id']; ?>"><?= $result['nama']; ?></option>
                    <?php endwhile; ?>
                </select>
            </td>`;
        $row += `<td><input type="number" class="form-control" name="material[${ $rowno }][nilai]"></td>`;
        $row += `<td><button type="button" class="btn btn-danger" onclick=delete_row('row${ $rowno }')>Hapus</button></td>`;
        $row += "</tr>"
        $("#bahan_baku tbody tr:last").after($row);
    }
    function delete_row(rowno)
    {
        $('#'+rowno).remove();
    }
</script>