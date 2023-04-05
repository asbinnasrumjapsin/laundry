<?php 

    $query = mysqli_query($conn, "SELECT * FROM tb_users WHERE userid = '$id'");
    $user = mysqli_fetch_assoc($query);
?>
<div class="page-content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Laundry</a></li>
                            <li class="breadcrumb-item"><a href="#">Data Laporan</a></li>
                            <li class="breadcrumb-item active">Transaksi</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Laporan Transaksi Laundry</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <!-- melakukan cari data berdasar tanggal -->
                        <form action="page/laporan/transaksi_pdf.php" method="GET" target="_blank">
                            <input type="hidden" name="user" value="<?= $user['username']; ?>">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Awal</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control bg-light border-0 small ml-3 mr-3" name="tgl_awal" id="tanggalawal" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Tanggal Akhir</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control bg-light border-0 small ml-3 mr-3" name="tgl_akhir" id="tanggalawal" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Status Pembayaran</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="pembayaran">
                                        <option value="all">Semua Status</option>
                                        <option value="paid">Lunas</option>
                                        <option value="unpaid">Belum Bayar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Status Pengambilan</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="pengambilan">
                                        <option value="all">Semua Status</option>
                                        <option value="1">Sudah Diambil</option>
                                        <option value="0">Belum Diambil</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Cetak Lap.Transaksi
                            </button>
                        </form>
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
