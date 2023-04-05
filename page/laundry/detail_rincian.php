<?php

// jika tombol tambah ditekan

$id_laundry =$_GET['idlaundry'];


  // menampilkan data transaksi
  $query = "SELECT * FROM `tb_laundry` INNER JOIN `tb_users` ON `tb_users`.`userid` = `tb_laundry`.`userid` INNER JOIN `tb_jenis` ON `tb_jenis`.`kd_jenis` = `tb_laundry`.`kd_jenis` WHERE `tb_laundry`.`id_laundry` = '$id_laundry'";
  $result = mysqli_query($conn, $query); 
  $row = mysqli_fetch_assoc($result);
  $rincian = mysqli_query($conn, "SELECT * FROM tb_laundry_detail WHERE id_laundry='$id_laundry'");

if (isset($_POST['tambah'])) {


  // $pelangganid = htmlentities(strip_tags(trim($_POST["pelangganid"])));
  

  $rincian = $_POST["rincian"];
 // print_r($rincian);

 
  if(count($rincian)){
        foreach($rincian as $m){

            $nama_layanan = $m['nama'];
            $qty = $m['qty'];

            $query = "INSERT INTO `tb_laundry_detail` (`id_laundry`, `nama`, `qty`) VALUES ('$id_laundry', '$nama_layanan', '$qty');";
             $result = mysqli_multi_query($conn, $query);
        }
    }
    

        
       
  
            echo "
            <script>
                alert('Transaksi $idlaundry berhasil ditambahkan');
                window.location.href = '?page=laundry';
            </script>
            ";
     
         
        
    }



?>

<div class="page-content-wrapper">
      <div class="col-md-12 m-t-10">    
                		
        <div class="card">
                			
            <div class="card-body">      
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <p> <b>No. Order :</b><?= $row['id_laundry']; ?> <br>
                                <b> Nama Konsumen : </b> <?= $row['konsumen']; ?> <br>
                                <b> Alamat : </b> <?= $row['alamat']; ?> <br>
                                <b> No. Telp : </b> <?= $row['telp']; ?><br>
                                <b> Tanggal Terima : </b> <?= DateTime::createFromFormat('Y-m-d H:i:s', $row['tgl_terima'])->format('d-m-Y H:i'); ?> WIB<br>
                                <b> Tanggal Selesai : </b> <?= DateTime::createFromFormat('Y-m-d', $row['tgl_selesai'])->format('d-m-Y'); ?> WIB<br>
                                <b> Kasir : </b> <?= $row['username']; ?><br>
                            </p>
                        </div>

                         <div class="col-md-6">
                            <p> <b>Jumlah Laundry (kg) :</b> <?= $row['jml_kilo']; ?> Kg <br>
                                <b> Total Harga : </b> Rp <?= number_format($row['totalbayar']); ?><br>
                                <b> Catatan Laundry: </b> <?= $row['catatan']; ?> <br>
                                <b> Status Pembayaran : </b> <?= ($row['status_pembayaran'] == 1) ? 'Lunas' : 'Belum Lunas'; ?><br>
                               
                            </p>
                        </div>
                    </div>
					
				</div>
            </div>    
									
		</div>  
    </div>
    
    <!-- end row -->
  </div>
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
              <h4 class="page-title">Rincian Laundry</h4>
          </div>
      </div>
  </div>

  
  <div class="row">

  
  
 
      <div class="col-12">

 

          <form action="" method="post">
              <div class="card m-b-100">
                  <div class="card-body">
                        <input type="hidden" name="userid" value=<?= $_SESSION['userid']; ?>>
                   
                
                        <table class="table table-bordered" id="bahan_baku">
                            <thead>
                                <tr>
                                    <th>Nama Layanan</th>
                                    <th>Jumlah</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="0">
                                    <td>
                                        <select class="form-control" name="rincian[0][nama]">
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
                                    </td>
                                    <td>
                                    <div class="input-group input-group-sm mb-3">
                                        <input type="text" class="form-control" aria-label="Small" name="rincian[0][qty]" aria-describedby="inputGroup-sizing-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Pcs</span>
                                        </div>
                                    </div>   
                                    </td>
                                    <td></td>
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

                      <div class="text-right">
                         
                          <button type="submit" name="tambah" class="btn btn-primary tambah"
                              onclick="return confirm('Apakah data yang anda masukkan sudah benar ?');">Simpan</button>
                      </div>
                  </div>
              </div>
          </form>
      </div>
   
      <!-- end col -->



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