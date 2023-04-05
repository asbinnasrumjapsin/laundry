<div class ="page-content-wrapper">
  <div class="container-fluid">

  <div class="row">
      <div class="col-sm-12">
          <div class="page-title-box">
              <div class="btn-group float-right">
                  <ol class="breadcrumb hide-phone p-0 m-0">
                      <li class="breadcrumb-item"><a href="#">Laundry</a></li>
                      <li class="breadcrumb-item active">Data Bahan Baku</li>
                  </ol>
              </div>
              <h4 class="page-title">Data Bahan Baku</h4>
          </div>
      </div>
  </div>

    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
          <div class="table-responsive">
            <h4 class="mt-0 header-title">
              <a href="?page=bahan_baku&aksi=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah data</a>
              <a href="page/bahan_baku/report.php" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Laporan Bahan Baku</a>
              <a href="?page=bahan_baku&aksi=pengaturan"  class="btn btn-warning"><i class=""></i> Pengaturan Stok Minimal</a>
              <hr>
              <?php $data_suplier = mysqli_query($conn, "SELECT * FROM tb_supplier ORDER BY id DESC"); ?>
               <?php while ($row = mysqli_fetch_assoc($data_suplier)) : ?>
                
                <?php 
                      $id= $row['id'];
                      $laporan_po = mysqli_query($conn, "SELECT *  FROM tb_beli_detail  WHERE id_suplier = $id  and status_pengajuan = 'Setuju'");
                      $laporan_po = mysqli_num_rows($laporan_po);

                      if($laporan_po > 0){
                ?>
                  
                  <a href="page/bahan_baku/laporan_po.php?id=<?= $row['id']; ?>"  class="btn btn-success"><i class=""></i> Laporan PO <?= $row['nama']; ?></a>
                  <?php } endwhile; ?>
            </h4>
            <table id="datatable" class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Kategori</th>
                  <th>Satuan</th>
                  <th>Stok</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              <?php 
              // menampilkan data jenis laundry              
              $result = mysqli_query($conn, "SELECT a.*, b.nama as satuan_nama FROM `tb_bahan_baku` as a LEFT JOIN `tb_satuan` as b ON b.id=a.satuan_id"); ?>
              <?php $i = 1; ?>
              <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                  <?php if($row['stok'] <=  $row['stok_minimal']){  ?>
                    <td class="text-danger"><?= $i; ?></td>
                    <td class="text-danger"><?= $row['nama']; ?></td>
                    <td class="text-danger"><?= $row['kategori']; ?></td>
                    <td class="text-danger"><?= $row['satuan_nama']; ?></td>
                    <td class="text-danger"><?= (is_decimal($row['stok'])) ? $row['stok'] : number_format($row['stok']); ?></td>
                    <td>
                        <a href="?page=bahan_baku&aksi=hapus&id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin untuk menghapus ?');"><i class="fa fa-trash-o"></i></a>
                      <?php
                        $id = $row['id'];
                        $beli_detail = mysqli_query($conn, "SELECT *  FROM tb_beli_detail  WHERE bahan_id = $id  and status_pengajuan = 'Belum Setuju'");
                        $beli = mysqli_fetch_assoc($beli_detail);
                        $beli_detail_setuju = mysqli_query($conn, "SELECT *  FROM tb_beli_detail  WHERE bahan_id = $id  and status_pengajuan = 'Setuju'");
                        $beli_setuju = mysqli_fetch_assoc($beli_detail_setuju);
                      ?>
                      <?php if($beli_setuju['status_pengajuan'] == "Setuju"){ ?>
                           <?php if($_SESSION['level'] == 'kasir'){ ?>
                         <a href="?page=bahan_baku&aksi=sedang_pengajuan&no_po=<?= $beli_setuju['no_po']; ?>" class="btn  btn-success mr-2">Setuju Pembelian </a>
                      <?php } } else if($beli['status_pengajuan'] == "Belum Setuju"){ ?>
                         <a href="?page=bahan_baku&aksi=sedang_pengajuan&no_po=<?= $beli['no_po']; ?>" class="btn btn-warning mr-2">Sedang Pengajuan Pembelian </a>
                      <?php }else{ ?>
                        <?php if($_SESSION['level'] == 'kasir' ){ ?>
                        <a href="?page=bahan_baku&aksi=stok&id=<?= $row['id']; ?>" class="btn btn-primary mr-2">Pengajuan Pembelian </a>
                      <?php } } ?>
                      <!--
                        <a href="?page=bahan_baku&aksi=ubah&id=<?= $row['id']; ?>" class="btn btn-warning mr-2"><i class="fa fa-tags"></i></a>
                      -->
                    </td>
                   <?php }else{ ?>
                    <td><?= $i; ?></td> 
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['kategori']; ?></td>
                    <td><?= $row['satuan_nama']; ?></td>
                    <td><?= (is_decimal($row['stok'])) ? $row['stok'] : number_format($row['stok']); ?></td>
                    <td>
                     
                      <!--
                      <a href="?page=bahan_baku&aksi=ubah&id=<?= $row['id']; ?>" class="btn btn-warning mr-2"><i class="fa fa-tags"></i></a>
                      -->
                      <a href="?page=bahan_baku&aksi=hapus&id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin untuk menghapus ?');"><i class="fa fa-trash-o"></i></a>
                    </td>
                  <?php } ?>
                 
                 
                </tr>
              <?php $i++; ?>
              <?php endwhile; ?>
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
