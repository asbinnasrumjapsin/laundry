<div class ="page-content-wrapper">
  <div class="container-fluid">

  <div class="row">
      <div class="col-sm-12">
          <div class="page-title-box">
              <div class="btn-group float-right">
                  <ol class="breadcrumb hide-phone p-0 m-0">
                      <li class="breadcrumb-item"><a href="#">Laundry</a></li>
                      <li class="breadcrumb-item active">Data Transaksi Laundry</li>
                  </ol>
              </div>
              <h4 class="page-title">Data Transaksi Laundry</h4>
          </div>
      </div>
  </div>

    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
          <div class="table-responsive">
            <h4 class="mt-0 header-title">
              <a href="?page=laundry&aksi=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Transaksi Laundry</a>
            </h4>
            <h4 class="mt-0 header-title">
              
              <!-- menampilkan status yang sudah lunas 
              <a href="?page=laundry&aksi=laundrylunas" class="btn btn-success">Status Lunas</a>
          
              <a href="?page=laundry&aksi=laundrybelumlunas" class="btn btn-danger">Status Belum Lunas</a>
                -->
            </h4>
            <table id="datatable" class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>ID</th>
                  <th>Konsumen</th>
                  <th>Jenis Layanan</th>
                  <th>Tgl. Terima</th>
                  <th>Estimasi Selesai</th>
                  <th>Tgl. pengambilan</th>
                  <th>Nama Pengambil</th>
                  <th>Status</th>
                 
                  <th>Total Bayar</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              <?php 
              // menampilkan data transaksi laundry
              $query = "SELECT * FROM `tb_laundry` INNER JOIN `tb_users` ON `tb_users`.`userid` = `tb_laundry`.`userid` INNER JOIN `tb_jenis` ON `tb_jenis`.`kd_jenis` = `tb_laundry`.`kd_jenis` ORDER BY `tb_laundry`.`id_laundry` DESC";
              $result = mysqli_query($conn, $query); ?>
              <?php $i = 1; ?>
              <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                  <td><?= $i; ?></td>
                  <td><?= $row['id_laundry']; ?></td>
                  <td><?= $row['konsumen']; ?></td>
                  <td><?= $row['jenis_laundry']; ?></td>
                  <td><?= $row['tgl_terima']; ?></td>
                  <td><?= $row['tgl_selesai']; ?></td>
                  <td class="text-center">
                    <?php if($row['tgl_pengambilan']  ==  null){
                       $tgl_diambil ="-";
                    }else{
                      $tgl_diambil = $row['tgl_pengambilan'];
                    } ?>
                    <?= $tgl_diambil ?>
                  </td>
                  <td class="text-center">
                     <?php if($row['nama_pengambil']  ==  null){
                       $nama_pengambil ="-";
                    }else{
                       $nama_pengambil =$row['nama_pengambil'];
                    } ?>
                    <?= $nama_pengambil ?>

                  </td>
                  <!-- jika status 1 berarti lunas, jika 0 belum lunas -->
             
                  <td>

                  <!-- jika status_pengembalian 0 berarti belum diambil -->
                    <?php if($row['status_pengambilan'] == 0) {
                      $tombol_status = "Ambil" ; 
                    ?>
                        <!--
                          <a href="?page=laundry&aksi=diambil&id=<?= $row['id_laundry']; ?>" class="btn btn-warning <?= ($row['status_pembayaran'] == 0) ? 'disabled' : ''; ?>" onclick="return confirm('Apakah anda yakin Baju sudah diambil?');">Belum Diambil</i></a>
                        -->
                        <nav class="badge badge-danger">Proses</nav>
                      
                    <!-- jika 1 sudah diambil -->
                    <?php }elseif($row['status_pengambilan'] == 1){ 
                      $tombol_status = "Detail";
                    ?>
                      <!--
                      <a href="#" class="btn btn-warning disabled">Sudah diambil</i></a>
                    -->
                        <nav class="badge badge-success">Sudah Selesai</nav>
                    <?php } ?>

                  </td>
                  <td>Rp. <?= number_format($row['totalbayar']); ?></td>
                  <td>
                    <a href="?page=laundry&aksi=detail&id=<?= $row['id_laundry']; ?>" class="btn btn-primary mb-2"><i class="fa fa-eye"></i> Detail</a>
                  </td>
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


