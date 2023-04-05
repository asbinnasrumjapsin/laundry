<?php
  $id = $_GET['id'];
  // menampilkan data transaksi (join 4 tabel)
  $query = "SELECT * FROM `tb_beli` INNER JOIN `tb_supplier` ON `tb_supplier`.`id` = `tb_beli`.`supplier_id` WHERE `tb_beli`.`id` = '$id'";
  
  $result = mysqli_query($conn, $query); 
  $beli = mysqli_fetch_assoc($result);
?>

<div class ="page-content-wrapper">
<div class="container-fluid">

  <div class="row">
      <div class="col-sm-12">
          <div class="page-title-box">
              <div class="btn-group float-right">
                  <ol class="breadcrumb hide-phone p-0 m-0">
                      <li class="breadcrumb-item"><a href="#">Laundry</a></li>
                      <li class="breadcrumb-item active">Detail Pembelian</li>
                  </ol>
              </div>
              <h4 class="page-title">Detail Pembelian</h4>
          </div>
      </div>
  </div>

    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
          <table class="table table-bordered">
            <tr>
              <th>No. Pembelian</th>
              <td><?= $beli['nomor']; ?></td>
            </tr>
            <tr>
              <th>Tgl. Pembelian</th>
              <td><?= $beli['tgl']; ?></td>
            </tr>
            <tr>
              <th>Supplier</th>
              <td><?= $beli['nama']; ?></td>
            </tr>
            <tr>
              <th>Alamat</th>
              <td><?= $beli['alamat']; ?></td>
            </tr>
           
            </tr>
            <tr>
              <th>No. Telp</th>
              <td><?= $beli['telp']; ?></td>
            </tr>
          </table>

          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Bahan Baku</th>
                  <th>Jumlah</th>
                  <th>Unit Satuan</th>
                  <th>Harga Satuan</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                    <?php 
                    // menampilkan data transaksi laundry
                    $query = "SELECT a.*, b.nama as material_nama, c.nama as material_satuan  FROM `tb_beli_detail` as a INNER JOIN `tb_bahan_baku` as b ON `b`.`id` = `a`.`bahan_id`
                    INNER JOIN `tb_satuan` as c ON `c`.`id` = `b`.`satuan_id`
                    WHERE a.beli_id=$id
                    ORDER BY `a`.`id` DESC";
                    $result = mysqli_query($conn, $query); ?>
                    <?php $i = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= "1"; ?></td>
                            <td><?= $row['material_nama']; ?></td>
                            <td><?= $row['qty']; ?></td>
                            <td><?= $row['material_satuan']; ?></td>
                            <td><?= $row['harga']; ?> Kg</td>
                            <td>Rp. <?= number_format($row['sub_total']); ?></td>
                        </tr>
                    <?php $i++; ?>
                    <?php endwhile; ?>

              </tbody>
              <tbody>
                <tr>
                  <th colspan="5" style="text-align: center;">TOTAL PEMBELIAN</th>
                  <th>Rp. <?= number_format($beli['total']); ?></th>
                </tr>
              </tbody>
            </table>
          </div>
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
    <!-- end page title end breadcrumb -->
  </div>
  <!-- container -->
</div>
