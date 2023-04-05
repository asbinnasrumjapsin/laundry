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
     $this->Cell(190,1,'','B',1,'L');
     $this->Cell(190,1,'','B',0,'L');

     //line break 5mm
     
      //memberikan jarak agar tidak rapat
        $this->Cell(10,7,'',0,1);
        

  }
  function Footer(){
    
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    //page number
    $this->Cell(0,10,'Page'.$this->PageNo().'/{nb} - Laporan Stok Bahan Baku',0,0,'C');
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

    
function is_decimal($n) {
    // Note that floor returns a float 
    return is_numeric($n) && floor($n) != $n;
}
  
}
//instance objek dan memberikan pengaturan halaman pdf
$pdf=new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->SetMargins(10,10);
$pdf->AddPage();

$pdf->SetFont('Arial','B','16');
$pdf->Cell(200,7,'Laporan Stok Bahan Baku',0,1,'C');
$pdf->ln();

//-------------Select data di database------------------------------
$pdf->Ln(5);
$pdf->SetFont('Arial','B', 10);
$pdf->Cell(15);
$pdf->Cell(15,7,"No",1);
$pdf->Cell(50,7,"Nama",1);
$pdf->Cell(50,7,"Satuan",1);
$pdf->Cell(45,7,"Stok",1);
$pdf->Ln();

$query = "SELECT a.*, b.nama as satuan_nama FROM `tb_bahan_baku` as a LEFT JOIN `tb_satuan` as b ON b.id=a.satuan_id";
// $query .= "ORDER BY `a`.`id` DESC";
$result = mysqli_query($conn, $query);
$no = 1;
while($row = mysqli_fetch_assoc($result)){
    $pdf->Cell(15);
    $pdf->SetFont('Arial','', 9);
    $pdf->Cell(15,7, $no++ ,1);
    $pdf->Cell(50,7, $row['nama'],1);
    $pdf->Cell(50,7, $row['satuan_nama'],1);
    $pdf->Cell(45,7,  $pdf->is_decimal($row['stok']) ? $row['stok'] : number_format($row['stok']) ,1);
    $pdf->Ln();
}
$pdf->Output();

?>