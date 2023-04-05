<div id="sidebar-menu">
  <ul>

    <li class="menu-title"></li>
    
    <li>
      <a href="index.php" class="waves-effect">
        <i class="mdi mdi-airplay"></i><span> Dashboard</span>
      </a>
    </li>
  
  <!-- jika level admin -->
  <?php if($_SESSION['level'] == 'admin') : ?>
    <li>
      <?php 
      // menghitung data user
      $dataUser = mysqli_query($conn, "SELECT * FROM tb_users");
      $jmlDataUser = mysqli_num_rows($dataUser);
      ?>
      <a href="?page=users" class="waves-effect">
        <i class="fa fa-users"></i>
        <span>Data Users<span class="badge badge-pill badge-primary float-right"><?= $jmlDataUser; ?></span></span>
      </a>
    </li>

    <li>
    <?php 
      // menghitung data jenis
      $jenis = mysqli_query($conn, "SELECT * FROM tb_jenis");
      $jmljenis = mysqli_num_rows($jenis);
      ?>
      <a href="?page=jenis" class="waves-effect">
      <i class="fa fa-key"></i>
        <span>Jenis Layanan<span class="badge badge-pill badge-primary float-right"><?= $jmljenis; ?></span></span>
      </a>
    </li>
  <?php endif; ?>
  
    <li>
      <?php 
      // menghitung data laundry
      $laundry = mysqli_query($conn, "SELECT * FROM tb_laundry");
      $jmllaundry = mysqli_num_rows($laundry);
      ?>
      <a href="?page=laundry" class="waves-effect">
        <i class="fa fa-shopping-cart"></i>
        <span>Transaksi Laundry<span class="badge badge-pill badge-primary float-right"><?= $jmllaundry; ?></span></span>
      </a>
    </li>


    <li>
      <?php 
      // menghitung data pegeluaran
      $pengeluaran = mysqli_query($conn, "SELECT * FROM tb_pengeluaran");
      $jmlpengeluaran = mysqli_num_rows($pengeluaran);
      ?>
      <a href="?page=pengeluaran" class="waves-effect">
      <i class="fa fa-money"></i>
        <span>Data Pengeluaran<span class="badge badge-pill badge-primary float-right"><?= $jmlpengeluaran; ?></span></span>
      </a>
    </li>

    <!--
    <li>
      <a href="?page=laporan" class="waves-effect">
        <i class="fa fa-reorder"></i>
        <span>Data Laporan</span>
      </a>
    </li>
    -->

    <li class="has_sub"><a href="javascript:void(0);" class="waves-effect">
        <i class="mdi mdi-layers"></i><span>Bahan Baku
            </span><span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="list-unstyled" style="display: none;">
            <li><a href="?page=bahan_baku">Data Bahan Baku</a></li>
            <li><a href="?page=satuan_unit">Data Satuan Unit</a></li>
        </ul>
    </li>
    
    <li class="has_sub"><a href="javascript:void(0);" class="waves-effect">
        <i class="mdi mdi-layers"></i><span>Pembelian
            </span><span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="list-unstyled" style="display: none;">
            <li><a href="?page=supplier">Data Supplier</a></li>
            <!--
            <li><a href="?page=pembelian">Data Pembelian</a></li>
             -->
        </ul>
    </li>

    <li class="has_sub"><a href="javascript:void(0);" class="waves-effect">
        <i class="mdi mdi-printer"></i><span>Laporan
            </span><span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="list-unstyled" style="display: none;">
            <li><a href="?page=laporan&aksi=transaksi">Laporan Transaksi</a></li>
            <li><a href="?page=laporan&aksi=pembelian">Laporan Pembelian</a></li>
        </ul>
    </li>

    <li>
      <a href="logout.php" class="waves-effect" onclick="return confirm('Apakah anda ingin logout ?');">
        <i class="mdi mdi-logout m-r-5 text-muted"></i>
        <span>Logout</span>
      </a>
    </li>

  </ul>
</div>
