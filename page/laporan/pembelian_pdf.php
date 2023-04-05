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
     $this->Cell(270,1,'','B',1,'L');
     $this->Cell(270,1,'','B',0,'L');

     //line break 5mm
     
      //memberikan jarak agar tidak rapat
        $this->Cell(10,7,'',0,1);
        

  }
  function Footer(){
    
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    //page number
    $this->Cell(0,10,'Page'.$this->PageNo().'/{nb} - Laporan Pembelian',0,0,'C');
  } 

  
    function formatTanggal($date){
        // menggunakan class Datetime
        $datetime = DateTime::createFromFormat('Y-m-d', $date);
        return $datetime->format('d-m-Y');
    }

    function formatTanggal2($date){
        // menggunakan class Datetime
        $datetime = DateTime::createFromFormat('Y-m-d', $date);
        return $datetime->format('d F Y');
    }
  
}
//instance objek dan memberikan pengaturan halaman pdf
$pdf=new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->SetMargins(10,10);
$pdf->AddPage();

       //Mengambil data dari form tambah staff
$tglawal=mysqli_real_escape_string($conn,$_GET['tgl_awal']);
$tglakhir=mysqli_real_escape_string($conn,$_GET['tgl_akhir']);

$pdf->SetFont('Arial','B','16');
$pdf->Cell(270,7,'Laporan Pembelian',0,1,'C');
// $pdf->Cell(270,7, ,0,1,'C');
$pdf->Cell(270,7,'Periode : '. $pdf->formatTanggal($tglawal) .' s/d '. $pdf->formatTanggal($tglakhir) ,0,1,'C');
$pdf->ln();


$pdf->SetFont('Arial','','10');
$pdf->Cell(25,7,'Nama Kasir',0,0);
$pdf->Cell(30,7,': '.$_GET['user'],0,1);
//-------------Select data di database------------------------------
$pdf->Ln(5);
$pdf->SetFont('Arial','B', 10);
$pdf->Cell(25,7,"No. PO",1);
$pdf->Cell(30,7,"Tanggal",1);
$pdf->Cell(80,7,"Supplier",1);
$pdf->Cell(60,7,"Keterangan",1);
$pdf->Cell(25,7,"Qty",1);
$pdf->Cell(50,7,"Jumlah Bayar",1);
$pdf->Ln();

$query = "SELECT a.*, b.nama as nama_suplier, c.nama as nama_bahan, d.nama as nama_satuan FROM `tb_beli_detail` as a INNER JOIN `tb_supplier` as b ON `b`.`id` = `a`.`id_suplier` LEFT JOIN `tb_bahan_baku` as c ON `a`.`bahan_id` = `c`.`id`
                        LEFT JOIN `tb_satuan` as d ON `c`.`satuan_id` = `d`.`id` WHERE  `a`.`tgl_pengajuan` BETWEEN '$tglawal' AND '$tglakhir' ";
// $query .= "ORDER BY `a`.`id` DESC";
$result = mysqli_query($conn, $query);

$total = 0;
while($row=mysqli_fetch_array($result)){
  $total += $row['harga_suplier'];
    $pdf->SetFont('Arial','', 9);
    $pdf->Cell(25,7, $row['no_po'],1);
    $pdf->Cell(30,7, $row['tgl_pengajuan'],1);
    $pdf->Cell(80,7, $row['nama_suplier'],1);
    $pdf->Cell(60,7, $row['nama_bahan'],1);
    $pdf->Cell(25,7, $row['qty'].' '.$row['nama_satuan'],1);
    $pdf->Cell(50,7, 'Rp '.number_format($row['harga_suplier']),1);
    $pdf->Ln();
}

  $pdf->SetFont('Arial','B', 10);
  $pdf->Cell(220,7, 'Total',1);
  $pdf->Cell(50,7, 'Rp '.number_format($total),1);
$pdf->Output();

?>