<?php

// jika tombol tambah ditekan

function d($data){
    if(is_null($data)){
        $str = "<i>NULL</i>";
    }elseif($data == ""){
        $str = "<i>Empty</i>";
    }elseif(is_array($data)){
        if(count($data) == 0){
            $str = "<i>Empty array.</i>";
        }else{
            $str = "<table style=\"border-bottom:0px solid #000;\" cellpadding=\"0\" cellspacing=\"0\">";
            foreach ($data as $key => $value) {
                $str .= "<tr><td style=\"background-color:#008B8B; color:#FFF;border:1px solid #000;\">" . $key . "</td><td style=\"border:1px solid #000;\">" . d($value) . "</td></tr>";
            }
            $str .= "</table>";
        }
    }elseif(is_resource($data)){
        while($arr = mysql_fetch_array($data)){
            $data_array[] = $arr;
        }
        $str = d($data_array);
    }elseif(is_object($data)){
        $str = d(get_object_vars($data));
    }elseif(is_bool($data)){
        $str = "<i>" . ($data ? "True" : "False") . "</i>";
    }else{
        $str = $data;
        $str = preg_replace("/\n/", "<br>\n", $str);
    }
    return $str;
}

function dnl($data){
    echo d($data) . "<br>\n";
}

function dd($data){
    echo dnl($data);
    exit;
}

function ddt($message = ""){
    echo "[" . date("Y/m/d H:i:s") . "]" . $message . "<br>\n";
}

$q = mysqli_query($conn, "SELECT MAX(RIGHT(nomor,4)) AS kd_max FROM tb_beli");
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


if (isset($_POST['tambah'])) {

    $supplier_id = htmlentities(strip_tags(trim($_POST["supplier_id"])));
    $tgl = htmlentities(strip_tags(trim($_POST["tanggal"])));
    $total = htmlentities(strip_tags(trim($_POST["grand_total"])));
    $line = $_POST["line"];
    $pesan_error = "";
    // input ke tb transaksi
    $sql1 = "INSERT INTO `tb_beli`(`nomor`, `supplier_id`, `tgl`, `total`) VALUES ('$nomor',$supplier_id,'$tgl',$total)";
    $query = mysqli_query($conn, $sql1);
    $id_pembelian = mysqli_insert_id($conn);
    $sql = "";
    if(count($line)){
        foreach($line as $m){
            
            $bahan_id = $m['bahan_baku'];
            $qty = $m['qty'];
            $harga = $m['harga'];
            $subtotal = $m['subtotal'];

            $sql .= "INSERT INTO `tb_beli_detail`(`beli_id`, `bahan_id`, `qty`, `harga`, `sub_total`) VALUES ($id_pembelian, $bahan_id,$qty,$harga,$subtotal);";

            $sql .="UPDATE `tb_bahan_baku` SET stok=stok+$qty WHERE `id`=$bahan_id;";
        }
    }
    $sql .= "INSERT INTO `tb_laporan` (`tgl_laporan`, `ket_laporan`, `catatan`, `id_pembelian`, `pengeluaran`) VALUES ('$tgl', 2, 'Pembelian Bahan baku', $id_pembelian, $total)";
    $result = mysqli_multi_query($conn, $sql);

    if ($result) {
        echo "
        <script>
            alert('Pembelian $nomor berhasil ditambahkan');
            window.location.href = '?page=pembelian';
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
                      <li class="breadcrumb-item active">Data Pembelian</li>
                      <li class="breadcrumb-item active">Tambah</li>
                  </ol>
              </div>
              <h4 class="page-title">Tambah Pembelian</h4>
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
                <input type="hidden" name="id" value="<?= $id_pembelian; ?>">
                <input type="hidden" name="userid" value=<?= $_SESSION['userid']; ?>>
                <div class="card m-b-100">
                    <div class="card-body">
                    
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Nomor</label>
                            <div class="col-sm-10">
                                <input type="text" name="nomor" class="form-control" value="<?= $nomor; ?>" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Supplier</label>
                            <div class="col-sm-10">
                                <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;"
                                    name="supplier_id" id="supplier_id">
                                    <option>--Pilih Supplier---</option>
                                    <?php 
                                        $query = mysqli_query($conn, "SELECT * FROM tb_supplier");
                                        while ($result = mysqli_fetch_assoc($query)) :
                                        if ($result['id'] == $jenis) { ?>
                                        <option value="<?= $result['id']; ?>" selected><?= $result['nama']; ?></option>
                                    <?php }else{ ?>
                                        <option value="<?= $result['id']; ?>"><?= $result['nama']; ?></option>
                                        <?php } ?>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Pembelian</label>
                            <div class="col-sm-10">
                            <input class="form-control" type="date" id="example-text-input" name="tanggal" value="<?= $tanggal; ?>" required autofocus/>
                            </div>
                        </div>

                        
                        <table class="table table-bordered" id="bahan_baku">
                            <thead>
                                <tr>
                                    <th width="40%">Bahan Baku</th>
                                    <th width="10%">Jumlah</th>
                                    <th width="15%">Harga</th>
                                    <th>Subtotal</th>
                                    <th width="10%">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="row0" class="bb">
                                    <td>
                                        <select class="form-control" name="line[0][bahan_baku]">
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
                                        <input type="number" class="form-control qty" name="line[0][qty]" value="0">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control harga" name="line[0][harga]" value="0">
                                    </td>
                                    <td>
                                        <input class="form-control subtotal" type="number" value="0" name="line[0][subtotal]" readonly required/>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <button type="button" class="btn btn-primary btn-block" onclick="add_row();">
                                            Tambah
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        GRAND TOTAL
                                    </td>
                                    <td colspan="2">
                                        <input class="form-control" id="GrandTotal" type="number" value="0" name="grand_total" readonly required/>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        <button type="submit" name="tambah" class="btn btn-primary tambah"
                            onclick="return confirm('Apakah data yang anda masukkan sudah benar ?');">Simpan</button>
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

<script>
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

    function add_row()
    {
        $rowno= $("#bahan_baku tbody tr").length -1;
        $rowno= $rowno+1;
        console.log($rowno);
        $row = "<tr id='row"+$rowno+"' class='bb'>";
        $row += `<td>
                <select class="form-control" name="line[${ $rowno }][bahan_baku]">
                    <option value="">Pilih</option>
                    <?php 
                        $query = mysqli_query($conn, "SELECT * FROM tb_bahan_baku");
                        while ($result = mysqli_fetch_assoc($query)) :
                        ?>
                        <option value="<?= $result['id']; ?>"><?= $result['nama']; ?></option>
                    <?php endwhile; ?>
                </select>
            </td>`;
        $row += `<td><input type="number" class="form-control qty" name="line[${ $rowno }][qty]" value="0"></td>`;
        $row += `<td><input type="number" class="form-control harga" name="line[${ $rowno }][harga]" value="0"></td>`;
        $row += `<td><input type="number" class="form-control subtotal" name="line[${ $rowno }][subtotal]" readonly></td>`;
        $row += `<td><button type="button" class="btn btn-danger" onclick=delete_row('row${ $rowno }')>Hapus</button></td>`;
        $row += "</tr>"
        $("#bahan_baku tbody tr:last").after($row);
    }
    function delete_row(rowno)
    {
        $('#'+rowno).remove();
    }

    function CalculateGrandTotal() {
        var grandTotal = 0;
        $('#bahan_baku tbody tr').each(function () {
            grandTotal += parseFloat($(this).find('.subtotal').val());
            $('#GrandTotal').val(grandTotal);
        });
    }
        
    $(document).on('change', '#bahan_baku tbody tr :input', function () {
        var $row = $(this).closest('tr'),
            qty = + $row.find('.qty').val(),
            price = +$row.find('.harga').val(),
            optamount = 0;

            sub_total = (qty * price + optamount);
            $row.find('.subtotal').val(sub_total);
            CalculateGrandTotal();
    });
</script>