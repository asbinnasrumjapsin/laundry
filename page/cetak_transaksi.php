<?php
  include "../include/koneksi.php";

  // mengambil data id dari url
  $id_laundry = $_GET['id'];

  // menampilkan data transaksi
  $query = "SELECT * FROM `tb_laundry` INNER JOIN `tb_users` ON `tb_users`.`userid` = `tb_laundry`.`userid` INNER JOIN `tb_jenis` ON `tb_jenis`.`kd_jenis` = `tb_laundry`.`kd_jenis` WHERE `tb_laundry`.`id_laundry` = '$id_laundry'";
  $result = mysqli_query($conn, $query); 
  $row = mysqli_fetch_assoc($result);
  $rincian = mysqli_query($conn, "SELECT * FROM tb_laundry_detail WHERE id_laundry='$id_laundry'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice <?= $row['id_laundry']; ?></title>
  <link href="../assets/plugins/morris/morris.css" rel="stylesheet">
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/icons.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/style.css" rel="stylesheet" type="text/css">
</head>

<!-- ketika halaman onload, maka auto print -->
<body onload="window.print()">
    <div style="padding:20px;">
        <h2 style="color:#87CEEB;">20 Laundry Shop</h2>
        <table width='100%'>
            <tr>
                <td>
                    Jl. Tubagus Ismail Dalam No.20, Lebakgede, Kecamatan Coblong, Kota Bandung, Jawa Barat 40132 <br>
                    No. Hp / WA : 082-117-865-320 <br>
                    Email : 20 laundryshop@gmail.com <br>
                    Jam Operasional : Senin – Minggu : 08.00 – 21.30 wib
                </td>
                <td align="right">
                    <p style="text-align: right;"> <b>Tanggal : </b> <?= date('Y-m-d H:i:s');; ?></p>
                </td>
            </tr>
        </table>
        <hr style="border:0; border-top: 5px double #8c8c8c;">
        <table width='100%'>
            <tr>
                <td>
                    <table>
                        <tr>
                            <th align="left">No. Order</th>
                            <td>:</td>
                            <td><?= $row['id_laundry']; ?></td>
                        </tr>
                        <tr>
                            <th align="left">Nama Konsumen</th>
                            <td>:</td>
                            <td><?= $row['konsumen']; ?></td>
                        </tr>
                        <tr>
                            <th align="left">Alamat</th>
                            <td>:</td>
                            <td><?= $row['alamat']; ?></td>
                        </tr>
                        <tr>
                            <th align="left">No. Telp</th>
                            <td>:</td>
                            <td><?= $row['telp']; ?></td>
                        </tr>
                        <tr>
                            <th align="left">Tanggal Terima</th>
                            <td>:</td>
                            <td><?= DateTime::createFromFormat('Y-m-d H:i:s', $row['tgl_terima'])->format('d-m-Y H:i'); ?> WIB</td>
                        </tr>
                        <tr>
                            <th align="left">Tanggal Selesai</th>
                            <td>:</td>
                            <td><?= DateTime::createFromFormat('Y-m-d', $row['tgl_selesai'])->format('d-m-Y'); ?></td>
                        </tr>
                        <tr>
                            <th align="left">Kasir</th>
                            <td>:</td>
                            <td><?= $row['username']; ?></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <th align="left">Jumlah Laundry (kg)</th>
                            <td>:</td>
                            <td><?= $row['jml_kilo']; ?> Kg</td>
                        </tr>
                        <tr>
                            <th align="left">Total Harga</th>
                            <td>:</td>
                            <td>Rp <?= number_format($row['totalbayar']); ?></td>
                        </tr>
                        <tr>
                            <th align="left">Catatan Laundry</th>
                            <td>:</td>
                            <td><?= $row['catatan']; ?></td>
                        </tr>
                        <tr>
                            <th align="left">Status Pembayaran</th>
                            <td>:</td>
                            <td><?= ($row['status_pembayaran'] == 1) ? '<nav class="badge badge-success">Lunas</nav>' : '<nav class="badge badge-danger">Belum Lunas</nav>'; ?>
                            </td>
                        </tr>
                        <tr>
                            <th align="left">Status Pengambilan</th>
                            <td>:</td>
                            <td><?= ($row['status_pengambilan'] == 1) ? '<nav class="badge badge-success">Sudah Diambil</nav>' : '<nav class="badge badge-danger">Belum Diambil</nav>'; ?>
                            </td>
                        </tr>
                        <?php if($row['status_pengambilan'] == 1){ ?>
                        <tr>
                            <th align="left">Tanggal Pengambilan</th>
                            <td>:</td>
                            <td><?= DateTime::createFromFormat('Y-m-d H:i:s', $row['tgl_pengambilan'])->format('d-m-Y H:i'); ?> WIB</td>
                        </tr>
                        <tr>
                            <th align="left">Nama Pengambil</th>
                            <td>:</td>
                            <td><?= $row['nama_pengambil']; ?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <!-- data transaksi -->
        <table width='100%' cellpadding='5' cellspacing='0' border="1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Layanan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php
            $no = 1;
                while ($r = mysqli_fetch_assoc($rincian)) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $r['nama']; ?></td>
                    <td><?= $r['qty']; ?> Pcs</td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Keterangan :</h3>
        <p>
            <ol>
                <li>Pengambilan cucian harus membawa nota</li>
                <li>Cucian luntur bukan tanggung jawab kami</li>
                <li>Hitung dan periksa sebelum pergi</li>
                <li>Cucian yang rusak/mengkerut karena sifat kain tidak dapat kami ganti</li>
                <li>Cucian yang tidak diambil lebih dari 1 bulan bukan tanggung jawab kami</li>
            </ol>
        </p>
    </div>
</body>

<script src="../assets/plugins/datatables/vfs_fonts.js"></script>

</html>