<?php
require 'fpdf/fpdf.php';
$db=new PDO("mysql:host=localhost;dbname=agritecturewesys",'root','');
class mypdf extends FPDF
{
    function header(){
        $this->Image('logo.jpg',10,6);
        $this->SetFont('Arial','B','14');
        $this->Cell(276,5,'AGRIMARKET SYSTEM',0,0,'C');
        $this->Ln();
        $this->SetFont('Times','',12);
        $this->Cell(276,10,'Sales report',0,0,'C');
        $this->Ln();
    }
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','',8);
        $this->Cell(276,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    function headerTable()
    {
        $this->SetFont('Times','B',12);
        $this->Cell(20,10,'ID',1,0,'C');
        $this->Cell(40,10,'Order date',1,0,'C');
        $this->Cell(40,10,'Order Status',1,0,'C');
        $this->Cell(60,10,'Payment Method',1,0,'C');
        $this->Cell(36,10,'Product ID',1,0,'C');
        $this->Cell(30,10,'Quantity',1,0,'C');
        $this->Cell(50,10,'User ID',1,0,'C');
        $this->Ln();
    }
    function viewTable($db)
    {
        $this->SetFont('Times','',12);
        $stmt=$db->query('select *from orders');
        while($data=$stmt->fetch(PDO::FETCH_OBJ))
        {
            $this->Cell(20,10,$data->id,1,0,'C');
            $this->Cell(40,10,$data->orderDate,1,0,'L');
            $this->Cell(40,10,$data->orderStatus,1,0,'L');
            $this->Cell(60,10,$data->paymentMethod,1,0,'L');
            $this->Cell(36,10,$data->productId,1,0,'L');
            $this->Cell(30,10,$data->quantity,1,0,'L');
            $this->Cell(50,10,$data->userId,1,0,'L');
            $this->Ln();
        }
    }
}
$pdf=new mypdf();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);
$pdf->headerTable();
$pdf->viewTable($db);
$pdf->Output();