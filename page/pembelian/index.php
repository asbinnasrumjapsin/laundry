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
              <h4 class="page-title">Laporan Pembelian</h4>
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
                  <th>Tgl Pembelian</th>
                  <th>Jumlah</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              <?php 
              // menampilkan data transaksi laundry
              $query = "SELECT a.*, b.nama as nama_suplier, c.nama as nama_bahan FROM `tb_beli_detail` as a INNER JOIN `tb_supplier` as b ON `b`.`id` = `a`.`id_suplier` LEFT JOIN `tb_bahan_baku` as c ON `a`.`bahan_id` = `c`.`id` WHERE `a`.`status_pengajuan` = 'Selesai' ORDER BY `a`.`no_po` DESC";
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
                  <td>Rp. <?= number_format($row['harga_suplier']); ?></td>
                  <td>
                      <a href="?page=pembelian&aksi=detail&id=<?= $row['id']; ?>" class="btn btn-primary mb-2"><i class="fa fa-eye"></i> Detail</a>
                      <!--
                      <a href="?page=pembelian&aksi=hapus&id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin untuk menghapus ?');"><i class="fa fa-trash-o"></i> Hapus</a>
                      -->
                    </td>
                </tr>
                
              <?php $i++; ?>
              <?php endwhile; ?>
                <tr>
                  <td colspan="5"> <b>Total Bayar</b></td>
                  <td colspan="2"><b>Rp. <?= number_format($total); ?></b></td>
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
