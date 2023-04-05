<?php

// jika tombol tambah ditekan
if (isset($_POST['tambah'])) {

  
    $q = mysqli_query($conn, "SELECT RIGHT(id_laundry,4) AS kd_max FROM tb_laundry");
    $jml = mysqli_num_rows($q);
    $kd = "";
    if ($jml <> 0) {
      while ($result = mysqli_fetch_assoc($q)) {
        $tmp = ((int)$result['kd_max']) + 1;
        $kd = sprintf("%04s", $tmp);
      }
    } else {
      $kd = "0001";
    }
    $id_laundry = 'LD-' . $kd;
          
    $idlaundry = $id_laundry;
  // $pelangganid = htmlentities(strip_tags(trim($_POST["pelangganid"])));
  
  $konsumen = htmlentities(strip_tags(trim($_POST["konsumen"])));
  $telp = htmlentities(strip_tags(trim($_POST["telp"])));
  $alamat = htmlentities(strip_tags(trim($_POST["alamat"])));
  $userid = htmlentities(strip_tags(trim($_POST["userid"])));
  $jenis = htmlentities(strip_tags(trim($_POST["id_jenis"])));
  $tarif = htmlentities(strip_tags(trim($_POST["tarif"])));
  $tgl_selesai = htmlentities(strip_tags(trim($_POST["tgl_selesai"])));
  $jml_kilo = htmlentities(strip_tags(trim($_POST["jml_kilo"])));
  $totalbayar = htmlentities(strip_tags(trim($_POST["totalbayar"])));
  $catatan = htmlentities(strip_tags(trim($_POST["catatan"])));
  $status = htmlentities(strip_tags(trim($_POST["status"]))); // status pembayaran
  $parfum_id = $_POST["parfum_id"];
  $status_pengambilan = 0;
  $tgl_terima = date('Y-m-d H:i');
  $ket_laporan = 1;
  $pesan_error = "";
  $rincian = $_POST["rincian"];
//   print_r($rincian);

  // input ke tb transaksi
  $query = "INSERT INTO `tb_laundry` (`id_laundry`, `konsumen`,`telp`, `alamat`,`userid`, `kd_jenis`, `tgl_terima`, `tgl_selesai`, `jml_kilo`, `catatan`, `totalbayar`, `status_pembayaran`,`status_pengambilan`, `parfum_id`) VALUES ('$idlaundry', '$konsumen', '$telp', '$alamat', '$userid', '$jenis', '$tgl_terima', '$tgl_selesai', '$jml_kilo', '$catatan', '$totalbayar', '$status','$status_pengambilan','$parfum_id');";
  $jbbQuery = mysqli_query($conn, "SELECT * FROM `tb_jenis_bahan` a LEFT JOIN `tb_satuan` as b ON b.id=a.satuan_id LEFT JOIN `tb_bahan_baku` as c ON c.id=a.bahan_id WHERE jenis_id=$jenis");

 
  while($row = mysqli_fetch_assoc($jbbQuery)):
    $bahan_id = $row['bahan_id'];
    $operator = $row['operator'];
    $operator_val = $row['operator_val'];
    $used_mat = $row['nilai'] * $jml_kilo;

    $bbQuery = mysqli_query($conn, "SELECT * FROM tb_bahan_baku WHERE id=$bahan_id");
    $bb = mysqli_fetch_assoc($bbQuery);
    $error = false;
    if($operator){
        if($operator == '/'){
            $dipake = $used_mat / $operator_val;
        }else{
            $dipake = $used_mat * $operator_val;
        }
    }else{
        $dipake = $used_mat;
    }

    if($bb['stok'] > $dipake){
        $stok = $bb['stok'] - $dipake;
        if($bb['kategori'] == 'Parfum'){
            $query .="UPDATE `tb_bahan_baku` SET `stok`=$stok WHERE `id`=$parfum_id;";
        }else{
            $query .="UPDATE `tb_bahan_baku` SET `stok`=$stok WHERE `id`=$bahan_id;";
        }
        $error = false;
    }else{
        $error = true;
        break;
    }
  endwhile;

    if($error){
        $pesan_error .= "Stok Bahan Baku Kurang!";
    }else{
        
        if ($status == 1) {
            $query .= "INSERT INTO `tb_laporan` (`id_laporan`, `tgl_laporan`, `ket_laporan`, `catatan`, `id_laundry`, `pemasukan`) VALUES ('', '$tgl_terima', '$ket_laporan', '$catatan', '$idlaundry', '$totalbayar');";
        }
        $result = mysqli_multi_query($conn, $query);
        if ($result) {
            echo "
            <script>
                window.location.href = '?page=laundry&aksi=tambah/detail&idlaundry=$idlaundry';
            </script>
            ";
        }else{
            $pesan_error .= "Data gagal disimpan !";
        }
    }

}else{
  $pesan_error = "";
  $konsumen = "";
  $telp = "";
  $alamat = "";
  $jenis = "";
  $tarif = "";
  $tgl_selesai = "";
  $jml_kilo = "";
  $totalbayar = "";
  $catatan = "";
  $status = "";
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
                      <li class="breadcrumb-item active">Data Transaksi Laundry</li>
                      <li class="breadcrumb-item active">Tambah</li>
                  </ol>
              </div>
              <h4 class="page-title">Tambah Transaksi Laundry</h4>
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
                        <input type="hidden" name="userid" value=<?= $_SESSION['userid']; ?>>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="example-text-input">Nama Konsumen</label>
                                    <input type="text" name="konsumen" class="form-control" value="<?= $konsumen; ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="example-text-input">No Telp</label>
                                    <input type="text" name="telp" class="form-control" value="<?= $telp; ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="example-text-input">Alamat</label>
                                    <input type="text" name="alamat" class="form-control" value="<?= $alamat; ?>" />
                                </div>
                                

                                <div class="form-group">
                                    <label for="example-text-input">Jenis Laundry</label>
                                    <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;"
                                        name="id_jenis" id="id_jenis" onchange="jenis();">
                                        <option>--Pilih jenis---</option>
                                        <?php 
                                            $query = mysqli_query($conn, "SELECT * FROM tb_jenis");
                                            while ($result = mysqli_fetch_assoc($query)) :
                                            if ($result['kd_jenis'] == $jenis) { ?>
                                        <option value="<?= $result['kd_jenis']; ?>" selected><?= $result['jenis_laundry']; ?>
                                        </option>
                                        <?php }else{ ?>
                                        <option value="<?= $result['kd_jenis']; ?>"><?= $result['jenis_laundry']; ?></option>
                                        <?php } ?>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="example-text-input">Tarif</label>
                                    <input class="form-control" type="text" id="tarif" name="tarif" value="<?= $tarif; ?>" required readonly />
                                </div>
                                
                            </div>

                            <div class="col-6">
                                
                                <div class="form-group">
                                    <label for="example-text-input">Tgl. Selesai</label>
                                    <input class="form-control" type="text" id="tgl_selesai" name="tgl_selesai"
                                        value="<?= $tgl_selesai; ?>" required readonly />
                                </div>

                                <div class="form-group">
                                    <label for="example-number-input">Jumlah (Kg)</label>
                                    <input class="form-control" type="number" id="jml_kilo" name="jml_kilo"
                                        value="<?= $jml_kilo; ?>" onkeyup="sum();" required />
                                </div>

                                <div class="form-group">
                                    <label for="example-number-input">Total Bayar</label>
                                    <input class="form-control" type="number" value="<?= $totalbayar; ?>" id="totalbayar"
                                        name="totalbayar" readonly required />
                                </div>

                                <div class="form-group">
                                    <label for="example-text-input">Status</label>
                                    <select name="status" class="select2 form-control">
                                        <?php if($status == 1) { ?>
                                        <option value=1 selected>Lunas</option>
                                        <option value=0>Belum lunas</option>
                                        <?php }elseif($status == 2) { ?>
                                        <option value=1>Lunas</option>
                                        <option value=0 selected>Belum lunas</option>
                                        <?php }else{ ?>
                                        <option value=0>Belum lunas</option>
                                        <option value=1>Lunas</option>
                                        <?php } ?>
                                    </select>
                                </div>

                                
                                <div class="form-group">
                                    <label for="parfum_id">Jenis Parfum</label>
                                    <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;"
                                        name="parfum_id" id="parfum_id" onchange="jenis();">
                                        <option>--Pilih jenis---</option>
                                        <?php 
                                            $query = mysqli_query($conn, "SELECT * FROM tb_bahan_baku WHERE kategori='Parfum'");
                                            while ($result = mysqli_fetch_assoc($query)) : ?>
                                            <option value="<?= $result['id']; ?>" selected><?= $result['nama']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="example-text-input">Catatan</label>
                            <textarea class="form-control" id="example-text-input" name="catatan" rows="2"
                                placeholder="Masukkan catatan"><?= $catatan; ?></textarea>
                        </div>


                      <div class="text-right">
                          <a href="?page=pelanggan" class="btn btn-warning">Kembali</a>
                          <button href="?page=laundry&aksi=tambah/detail" name="tambah" class="btn btn-primary tambah">Lanjutkan</butoon>
                      </div>
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
                    <select class="form-control" name="rincian[${ $rowno }][nama]">
                        <option value="">Pilih</option>
                        <option value="Kemeja">Kemeja</option>
                        <option value="T-Shirt / Kaos">T-Shirt / Kaos</option>
                        <option value="Celana Panjang">Celana Panjang</option>
                        <option value="Celana Pendek">Celana Pendek</option>
                        <option value="Pajamas/Piyama">Pajamas/Piyama</option>
                        <option value="Bra/BH">Bra/BH</option>
                        <option value="Kerudung">Kerudung</option>
                        <option value="JAS">JAS</option>
                        <option value="Setelan Jas">Setelan Jas</option>
                        <option value="Jaket">Jaket</option>
                        <option value="Sepatu">Sepatu</option>
                        <option value="Bed Cover">Bed Cover</option>
                        <option value="Seprai">Seprai</option>
                        <option value="Selimut">Selimut</option>
                        <option value="Karpet">Karpet</option>
                        <option value="Duve">Duve</option>
                        <option value="Handuk">Handuk</option>
                        <option value="Sarung Bantal">Sarung Bantal</option>
                    </select>
            </td>`;
        $row += `<td>
                 <div class="input-group input-group-sm mb-3">
                    <input type="text" class="form-control" aria-label="Small"  name="rincian[${ $rowno }][qty]" aria-describedby="inputGroup-sizing-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Pcs</span>
                    </div>
                </div> 
        `;
        $row += `<td><button type="button" class="btn btn-danger" onclick=delete_row('row${ $rowno }')>Hapus</button></td>`;
        $row += "</tr>"
        $("#bahan_baku tbody tr:last").after($row);
    }
    function delete_row(rowno)
    {
        $('#'+rowno).remove();
    }
  // menghitung total bayar
  function sum(){
    var jmlKilo = document.getElementById('jml_kilo').value;
    var tarif = document.getElementById('tarif').value;

    // jml kilo * tarif
    var total = parseInt(jmlKilo)*tarif;

    // memeriksa apakan parameter numerik
    if(!isNaN(total)){
      document.getElementById('totalbayar').value = total;
    }else{
      document.getElementById('totalbayar').value = '';
    }
  }

  function jenis(){
    // mengambil data dari id=id_jenis
    var id = $("#id_jenis").val();

    $.ajax({
      // mengirim data idjenis ke file autofill.php
      url: "page/laundry/autofill.php",
      data: 'idjenis='+id,
      success: function (data){
        var json = data,
        obj = JSON.parse(json);
        // jika sukses mengirim balik
        if (obj.sukses) {
          // auto mengisi data pada id = tarif
          $('#tarif').val(obj.sukses.tarif);
          // auto mengisi data pada id = tgl_selesai
          $('#tgl_selesai').val(obj.sukses.tgl_selesai);
          $('#jml_kilo').val('');
          $('#totalbayar').val('');
        }else if(obj.gagal){
          $('#tarif').val('');
          $('#tgl_selesai').val('');
          $('#jml_kilo').val('');
          $('#totalbayar').val('');
        }
      }
    })
  }
        
</script>