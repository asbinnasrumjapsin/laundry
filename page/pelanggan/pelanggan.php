<div class ="page-content-wrapper">
  <div class="container-fluid">

  <div class="row">
      <div class="col-sm-12">
          <div class="page-title-box">
              <div class="btn-group float-right">
                  <ol class="breadcrumb hide-phone p-0 m-0">
                      <li class="breadcrumb-item"><a href="#">Laundry</a></li>
                      <li class="breadcrumb-item active">Data Konsumen</li>
                  </ol>
              </div>
              <h4 class="page-title">Data Konsumen</h4>
          </div>
      </div>
  </div>

    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
          <div class="table-responsive">
            <h4 class="mt-0 header-title">
              <a href="?page=pelanggan&aksi=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah data</a>
            </h4>
            <table id="datatable" class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama Konsumen</th>
                  <th>Alamat</th>
                  <th>No. Telp</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              <?php 
              // menampilkan data pelanggan              
              $result = mysqli_query($conn, "SELECT * FROM tb_pelanggan ORDER BY pelangganid DESC"); 
              ?>

              <?php $i = 1; ?>
              <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                  <td><?= $i; ?></td>
                  <td><?= $row['pelanggannama']; ?></td>
                  <td><?= $row['pelangganalamat']; ?></td>
                  <td><?= $row['pelanggantelp']; ?></td>
                  <td>
                    <a href="?page=pelanggan&aksi=ubah&id=<?= $row['pelangganid']; ?>" class="btn btn-warning"><i class="fa fa-tags"></i></a>
                    <a href="?page=pelanggan&aksi=hapus&id=<?= $row['pelangganid']; ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin untuk menghapus ?');"><i class="fa fa-trash-o"></i></a>
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

