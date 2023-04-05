<?php 

// menangkap page dan aksi dari url
$page = $_GET['page'];
$aksi = $_GET['aksi'];

// page/halaman home / dashboard
if ($page == "") {
  include "home.php";
}

// page pelanggan
if ($page == "pelanggan") {
  // halaman pelanggan
  if ($aksi == "") {
    include "page/pelanggan/pelanggan.php";
  }
  // tambah data pelanggan
  if ($aksi == "tambah") {
    include "page/pelanggan/tambah.php";
  }
  // hapus data pelanggan
  if ($aksi == "hapus") {
    include "page/pelanggan/hapus.php";
  }
  // ubah data pelanggan
  if ($aksi == "ubah") {
    include "page/pelanggan/ubah.php";
  }
  // upload foto pelanggan
  if ($aksi == "foto") {
    include "page/pelanggan/uploadfoto.php";
  }
}


// jika levelnya admin maka dapat megakses halaman ini
// halaman ini hanya bisa diakses admin
if ($_SESSION['level'] == 'admin') {
  // page users
  if ($page == "users") {
    // halaman users
    if ($aksi == "") {
      include "page/users/users.php";
    }
    // tambah users
    if ($aksi == "tambah") {
      include "page/users/tambah.php";
    }
    // hapus users
    if ($aksi == "hapus") {
      include "page/users/hapus.php";
    }
    // ubah users
    if ($aksi == "ubah") {
      include "page/users/ubah.php";
    }
    // upload foto users
    if ($aksi == "foto") {
      include "page/users/uploadfoto.php";
    }
  }

  // page jenis
  if ($page == "jenis") {
    // menampilkan halaman jenis
    if ($aksi == "") {
      include "page/jenis/jenis.php";
    }
    // tambah 
    if ($aksi == "tambah") {
      include "page/jenis/tambah.php";
    }
    if ($aksi == "hapus") {
      include "page/jenis/hapus.php";
    }
    if ($aksi == "ubah") {
      include "page/jenis/ubah.php";
    }
  }
} // sampai sini


// page transaksi laundry
if ($page == "laundry") {
  // menampilkan halaman laundry
  if ($aksi == "") {
    include "page/laundry/laundry.php";
  }
  // menampilkan data yg sudah lunas
  if ($aksi == "laundrylunas") {
    include "page/laundry/laundrylunas.php";
  }
  // menampilkan data yang belum lunas
  if ($aksi == "laundrybelumlunas") {
    include "page/laundry/laundrybelumlunas.php";
  }
  // tambah transaksi
  if ($aksi == "tambah") {
    include "page/laundry/tambah.php";
  }

  // detail_transaksi transaksi
  if ($aksi == "tambah/detail") {
    include "page/laundry/detail_tambah.php";
  }

  // detail rincian
  if ($aksi == "tambah/detail_rincian") {
    include "page/laundry/detail_rincian.php";
  }
  // hapus transaksi
  if ($aksi == "hapus") {
    include "page/laundry/hapus.php";
  }
  // melunasi transaksi
  if ($aksi == "lunasi") {
    include "page/laundry/lunasi.php";
  }
  // menampilkan detail dari transaksi
  if ($aksi == "detail") {
    include "page/detail_transaksi.php";
  }
  // baju diambil
  if ($aksi == "diambil") {
    include "page/laundry/diambil.php";
  }
}

// page pengeluaran
if ($page == "pengeluaran") {
  if ($aksi == "") {
    include "page/pengeluaran/pengeluaran.php";
  }
  if ($aksi == "tambah") {
    include "page/pengeluaran/tambah.php";
  }
  if ($aksi == "hapus") {
    include "page/pengeluaran/hapus.php";
  }
  if ($aksi == "ubah") {
    include "page/pengeluaran/ubah.php";
  }
  if ($aksi == "detail") {
    include "page/detail_pengeluaran.php";
  }
}

// page laporan
if ($page == "laporan") {
  if ($aksi == "") {
    include "page/laporan/laporan.php";
  }
  if ($aksi == "pembelian") {
    include "page/laporan/pembelian.php";
  }
  if ($aksi == "transaksi") {
    include "page/laporan/transaksi.php";
  }
  // if ($aksi == "detail") {
  //   include "page/detail_transaksi.php";
  // }
}

// halaman profile
if ($page == "profile") {
  // menampilkan halaman profile
  if ($aksi == "") {
    include "page/profile.php";
  }
  // ubah foto profile
  if ($aksi == "ubahfoto") {
    include "page/uploadfotoprofile.php";
  }
}


// halaman bahan baku
if ($page == "bahan_baku") {
    // menampilkan halaman profile
    if ($aksi == "") {
        include "page/bahan_baku/index.php";
    }else if($aksi == "tambah"){
        include "page/bahan_baku/tambah.php";
    }else if($aksi == "ubah"){
        include "page/bahan_baku/ubah.php";
    }else if($aksi == "hapus"){
        include "page/bahan_baku/hapus.php";
    }else if($aksi == "stok"){
      include "page/bahan_baku/stok.php";
    }else if($aksi == "report"){
      include "page/bahan_baku/report.php";
    }else if($aksi == "pengaturan"){
      include "page/bahan_baku/pengaturan_stok.php";
    }else if($aksi == "sedang_pengajuan"){
      include "page/bahan_baku/sedang_pengajuan.php";
    }else if($aksi == "barang_datang"){
      include "page/bahan_baku/barang_datang.php";
    }
}

// halaman satuan unit
if ($page == "satuan_unit") {
    // menampilkan halaman profile
    if ($aksi == "") {
        include "page/satuan_unit/index.php";
    }else if($aksi == "tambah"){
        include "page/satuan_unit/tambah.php";
    }else if($aksi == "ubah"){
        include "page/satuan_unit/ubah.php";
    }else if($aksi == "hapus"){
        include "page/satuan_unit/hapus.php";
    }
}


if ($page == "supplier") {
    // halaman pelanggan
    if ($aksi == "") {
      include "page/supplier/index.php";
    }
    // tambah data pelanggan
    if ($aksi == "tambah") {
      include "page/supplier/tambah.php";
    }
    // hapus data pelanggan
    if ($aksi == "hapus") {
      include "page/supplier/hapus.php";
    }
    // ubah data pelanggan
    if ($aksi == "ubah") {
      include "page/supplier/ubah.php";
    }
  }

  
if ($page == "pembelian") {
    // halaman pelanggan
    if ($aksi == "") {
      include "page/pembelian/index.php";
    }
    // tambah data pelanggan
    if ($aksi == "tambah") {
      include "page/pembelian/tambah.php";
    }
    // hapus data pelanggan
    if ($aksi == "detail") {
      include "page/pembelian/detail.php";
    }
    // hapus data pelanggan
    if ($aksi == "hapus") {
      include "page/pembelian/hapus.php";
    }
    // ubah data pelanggan
    if ($aksi == "ubah") {
      include "page/pembelian/ubah.php";
    }
  }
  

function is_decimal($n) {
    // Note that floor returns a float 
    return is_numeric($n) && floor($n) != $n;
}

?>