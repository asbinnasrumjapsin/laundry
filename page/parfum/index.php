
<div class ="page-content-wrapper">
  <div class="container-fluid">

  <div class="row">
      <div class="col-sm-12">
          <div class="page-title-box">
              <div class="btn-group float-right">
                  <ol class="breadcrumb hide-phone p-0 m-0">
                      <li class="breadcrumb-item"><a href="#">Laundry</a></li>
                      <li class="breadcrumb-item active">Data Parfum</li>
                  </ol>
              </div>
              <h4 class="page-title">Data Parfum</h4>
          </div>
      </div>
  </div>

    <div class="row">
      <div class="col-12">
        <div class="card m-b-30">
          <div class="card-body">
          <div class="table-responsive">
            <h4 class="mt-0 header-title">
              <a href="?page=satuan_unit&aksi=tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah data</a>
            </h4>
            <table id="datatable" class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Dasar Satuan</th>
                  <th>Operator</th>
                  <th>Nilai Operator</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              <?php 
              // menampilkan data jenis laundry              
              $result = mysqli_query($conn, "SELECT a.*, b.nama as nama_induk  FROM `tb_satuan` as a LEFT JOIN `tb_satuan` as b ON b.id=a.parent_id"); ?>
              <?php $i = 1; ?>
              <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                  <td><?= $i; ?></td>
                  <td><?= $row['nama']; ?></td>
                  <td><?= $row['nama_induk']; ?></td>
                  <td><?= $row['operator']; ?></td>
                  <td><?= (is_decimal($row['operator_val'])) ? $row['operator_val'] : number_format($row['operator_val']); ?></td>
                  <td>
                    <a href="?page=satuan_unit&aksi=ubah&id=<?= $row['id']; ?>" class="btn btn-warning mr-2"><i class="fa fa-tags"></i></a>
                    <a href="?page=satuan_unit&aksi=hapus&id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin untuk menghapus ?');"><i class="fa fa-trash-o"></i></a>
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
