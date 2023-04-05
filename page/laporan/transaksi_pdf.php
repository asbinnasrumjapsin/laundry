<?php
require('../../assets/phpfpdf/fpdf.php');
include '../../include/koneksi.php';

class PDF extends FPDF
{
  function Header(){
    //logo
    // $this->Image('../../assets/images/20logo.png', 90,12,27);
     
     //geser kanan 35 mm
    //  $this->Cell(95);
     //judul
     $this->SetFont('Arial','B',16);
     $this->Cell(100,7,'DUA PULUH LAUNDRY SHOP',0,1,'L');
     
    //  $this->Cell(94);
     $this->SetFont('Arial','i',10  );
     $this->Cell(90,7,'Jl. Tubagus Ismail Dalam No.20, Lebakgede, Kecamatan Coblong, Kota Bandung, Jawa Barat 40132',0,1,'L');
     //garis bawah double
     $this->Cell(285,1,'','B',1,'L');
     $this->Cell(285,1,'','B',0,'L');

     //line break 5mm
     
      //memberikan jarak agar tidak rapat
        $this->Cell(10,7,'',0,1);
        

  }
  function Footer(){
    
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    //page number
    $this->Cell(0,10,'Page'.$this->PageNo().'/{nb} - Laporan Transaksi Laundry',0,0,'C');
  } 

  
    function formatTanggal($date){
        // menggunakan class Datetime
        $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        return $datetime->format('d-m-Y H:i');
    }

    function formatTglHeader($date){
        // menggunakan class Datetime
        $datetime = DateTime::createFromFormat('Y-m-d', $date);
        return $datetime->format('d F Y');
    }

    function formatTanggal2($date){
        // menggunakan class Datetime
        $datetime = DateTime::createFromFormat('Y-m-d', $date);
        return $datetime->format('d F Y');
    }

    
    function pembayaran($data){
        // menggunakan class Datetime
        if($data == 'paid'){
            return 'Sudah Bayar';
        }elseif($data == 'unpaid'){
            return 'Belum Bayar';
        }else{
            return 'Semua Status';
        }
    }

    function pengambilan($data){
        // menggunakan class Datetime
        if($data == '1'){
            return 'Sudah Diambil';
        }elseif($data == '0'){
            return 'Belum Diambil';
        }else{
            return 'Semua Status';
        }
    }
  
}
//instance objek dan memberikan pengaturan halaman pdf
$pdf=new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->SetMargins(5,10,5);
$pdf->AddPage();

       //Mengambil data dari form tambah staff
$tglawal=mysqli_real_escape_string($conn,$_GET['tgl_awal']);
$tglakhir=mysqli_real_escape_string($conn,$_GET['tgl_akhir']);
$pembayaran=mysqli_real_escape_string($conn,$_GET['pembayaran']);
$pengambilan=mysqli_real_escape_string($conn,$_GET['pengambilan']);

$pdf->SetFont('Arial','B','16');
$pdf->Cell(285,7,'Laporan Transaksi Laundry',0,1,'C');
$pdf->Cell(285,7,'Periode : '. $pdf->formatTglHeader($tglawal) .' s/d '. $pdf->formatTglHeader($tglakhir) ,0,1,'C');
$pdf->ln();

$pdf->SetFont('Arial','',10  );
$pdf->Cell(25,7,'Nama Kasir',0,0);
$pdf->Cell(20);
$pdf->Cell(100,7,': '.$_GET['user'],0,1);
$pdf->Cell(25,7,'Status Pembayaran',0,0);
$pdf->Cell(20);
$pdf->Cell(100,7,': '.$pdf->pembayaran($pembayaran),0,1);
$pdf->Cell(25,7,'Status Pengambilan',0,0);
$pdf->Cell(20);
$pdf->Cell(100,7,': '.$pdf->pengambilan($pengambilan),0,1);

//-------------Select data di database------------------------------
$pdf->Ln(5);
$pdf->SetFont('Arial','B', 10);
$pdf->Cell(25,7,"Nomor",1);
$pdf->Cell(60,7,"Nama Konsumen",1);
$pdf->Cell(50,7,"Layanan",1);
$pdf->Cell(50,7,"Tgl Transaksi",1);
$pdf->Cell(50,7,"Tgl Selesai",1);
$pdf->Cell(50,7,"Jumlah",1);
$pdf->Ln();

$query = "SELECT * FROM `tb_laundry` INNER JOIN `tb_users` ON `tb_users`.`userid` = `tb_laundry`.`userid` INNER JOIN `tb_jenis` ON `tb_jenis`.`kd_jenis` = `tb_laundry`.`kd_jenis` WHERE tb_laundry.tgl_terima BETWEEN '$tglawal' AND '$tglakhir'";
if($pembayaran == 'paid'){
$query .= "AND tb_laundry.status_pembayaran='1'";
}elseif($pembayaran == 'unpaid'){
$query .= "AND tb_laundry.status_pembayaran='0'";
}
if($pengambilan == '1'){
$query .= "AND tb_laundry.status_pengambilan='1'";
}elseif($pengambilan == '0'){
$query .= "AND tb_laundry.status_pengambilan='0'";
}
$query .= "ORDER BY `tb_laundry`.`id_laundry` DESC";
$result = mysqli_query($conn, $query);
// $query = "SELECT * FROM tb_permohonanktp as k JOIN tb_penduduk as p ON k.nik=p.nik WHERE tgl_penyerahanBerkas between '$tglawal' and '$tglakhir'  ORDER BY tanggalLahir ASC";
// $data = mysqli_query($koneksi, $query) or die (mysqli_error($koneksi)) ;

$total = 0;
while($row=mysqli_fetch_array($result)){
  $total += $row['totalbayar'];
    $pdf->SetFont('Arial','', 9);
    $pdf->Cell(25,7, $row['id_laundry'],1);
    $pdf->Cell(60,7, $row['konsumen'],1);
    $pdf->Cell(50,7, $row['jenis_laundry'],1);
    $pdf->Cell(50,7, $pdf->formatTanggal($row['tgl_terima']),1);
    $pdf->Cell(50,7, $pdf->formatTanggal2($row['tgl_selesai']),1);
    $pdf->Cell(50,7, 'Rp '.number_format($row['totalbayar']),1);
    $pdf->Ln();
}


  $pdf->SetFont('Arial','B', 10);
  $pdf->Cell(235,7, 'Total',1);
  $pdf->Cell(50,7, 'Rp '.number_format($total),1);
             


$pdf->Output();

?>