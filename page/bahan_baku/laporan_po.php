<?php

require('../../assets/phpfpdf/fpdf.php');
include '../../include/koneksi.php';
  $id = $_GET['id'];

  $laporan_po = mysqli_query($conn, "SELECT *,   tb_satuan.nama as satuan_stok, tb_bahan_baku.nama as nama  FROM tb_beli_detail left JOIN  tb_bahan_baku  ON tb_beli_detail.bahan_id = tb_bahan_baku.id LEFT JOIN tb_satuan ON tb_satuan.id=tb_bahan_baku.satuan_id  WHERE tb_beli_detail.id_suplier = '$id' and tb_beli_detail.status_pengajuan ='Setuju'");
   
  
  $data_suplier = mysqli_query($conn, "SELECT *  FROM tb_supplier  WHERE id = '$id'");
  $suplier = mysqli_fetch_assoc($data_suplier);


class PDF extends FPDF
{
  function Header(){
    //logo
    // $this->Image('../../assets/images/20logo.png', 90,12,27);
     
     //geser kanan 35 mm
    //  $this->Cell(95);
     //judul
     $this->SetFont('Arial','B',16);
     $this->Cell(00,7,'DUA PULUH LAUNDRY SHOP',0,1,'L');
     
    //  $this->Cell(94);
     $this->SetFont('Arial','i',10  );
     $this->Cell(90,7,'Jl. Tubagus Ismail Dalam No.20, Lebakgede, Kecamatan Coblong, Kota Bandung, Jawa Barat 40132',0,1,'L');
     //garis bawah double
     $this->Cell(280,1,'','B',1,'L');
     $this->Cell(280,1,'','B',0,'L');

     //line break 5mm
     
      //memberikan jarak agar tidak rapat
        $this->Cell(10,7,'',0,1);
        

  }
  function Footer(){
    
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    //page number
    $this->Cell(0,10,'Page'.$this->PageNo().'/{nb} - Laporan PO',0,0,'C');
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
$pdf=new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->SetMargins(10,10);
$pdf->AddPage();

$pdf->SetFont('Arial','B','16');
$pdf->Cell(280,7,'Purchase Order ',0,1,'C');


 //  $this->Cell(94);
     $pdf->SetFont('Arial','',10  );
     $pdf->Cell(90,7,'Supplier : '.$suplier['nama'].'',0,1,'L');
     $pdf->Cell(90,7,'Alamat : '.$suplier['alamat'].'',0,1,'L');
     $pdf->Cell(90,7,'Tanggal : '.date("d/m/Y").'',0,1,'L');
//-------------Select data di database------------------------------
$pdf->Ln(5);
$pdf->SetFont('Arial','B', 10);

$pdf->Cell(15,7,"No",1);
$pdf->Cell(50,7,"No. PO",1);
$pdf->Cell(65,7,"Nama",1);
$pdf->Cell(45,7,"Qty",1);
$pdf->Cell(50,7,"Satuan",1);
$pdf->Cell(50,7,"Jumlah Harga",1);
$pdf->Ln();

$no = 1;
$total = 0;
while($row = mysqli_fetch_assoc($laporan_po)){
    $total += $row['harga'];
 
    $pdf->SetFont('Arial','', 9);
    $pdf->Cell(15,7, $no++ ,1);
    $pdf->Cell(50,7, $row['no_po'],1);
    $pdf->Cell(65,7, $row['nama'],1);
    $pdf->Cell(45,7, $pdf->is_decimal($row['qty']) ? $row['qty'] : number_format($row['qty']) ,1);
    $pdf->Cell(50,7, $row['satuan_stok'],1);
    $pdf->Cell(50,7, 'Rp '.number_format($row['harga']),1);
    $pdf->Ln();
}
  $pdf->SetFont('Arial','B', 10);
  $pdf->Cell(225,7, 'Total Harga',1);
  $pdf->Cell(50,7, 'Rp '.number_format($total),1);
$pdf->Output();

?>


