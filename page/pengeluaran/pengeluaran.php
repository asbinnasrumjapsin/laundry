<div class ="page-content-wrapper">
  <div class="container-fluid">

  <div class="row">
      <div class="col-sm-12">
          <div class="page-title-box">
              <div class="btn-group float-right">
                  <ol class="breadcrumb hide-phone p-0 m-0">
                      <li class="breadcrumb-item"><a href="#">Laundry</a></li>
                      <li class="breadcrumb-item active">Data Pembelian</li>
                  </ol>
              </div>
              <h4 class="page-title">Data Pengeluaran</h4>
          </div>
      </div>
  </div>

    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
          <div class="table-responsive">
            <!--
            <h4 class="mt-0 header-title">
              <a href="?page=pembelian&aksi=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Pembelian</a>
            </h4>
            -->
            <table id="datatable" class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nomor PO</th>
                  <th>Tanggal</th>
                  <th>Supplier</th>
                  <th>Keterangan</th>
                  <th>Qty</th>
                  <th>Jumlah Bayar</th>
                </tr>
              </thead>
              <tbody>
              <?php 
              // menampilkan data transaksi laundry
              $query = "SELECT a.*, b.nama as nama_suplier, c.nama as nama_bahan, d.nama as nama_satuan FROM `tb_beli_detail` as a INNER JOIN `tb_supplier` as b ON `b`.`id` = `a`.`id_suplier` LEFT JOIN `tb_bahan_baku` as c ON `a`.`bahan_id` = `c`.`id`
                        LEFT JOIN `tb_satuan` as d ON `c`.`satuan_id` = `d`.`id` WHERE `a`.`status_pengajuan` = 'Selesai' ORDER BY `a`.`no_po` DESC";
              $result = mysqli_query($conn, $query); ?>
              <?php $total = 0;  $i = 1; ?>
              <?php while ($row = mysqli_fetch_assoc($result)) :
                $total +=  $row['harga_suplier'];
              ?>
                <tr>
                  <td><?= $i; ?></td>
                  <td><?= $row['no_po']; ?></td>
                  <td><?= $row['tgl_pengajuan']; ?></td>
                  <td><?= $row['nama_suplier']; ?></td>
                  <td><?= $row['nama_bahan']; ?></td>
                   <td><?= $row['qty']; ?> <?= $row['nama_satuan']; ?></td>
                  <td>Rp. <?= number_format($row['harga_suplier']); ?></td>
                </tr>
                
              <?php $i++; ?>
              <?php endwhile; ?>
                <tr>
                  <td colspan="6"> <b>Total Bayar</b></td>
                  <td ><b>Rp. <?= number_format($total); ?></b></td>
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
