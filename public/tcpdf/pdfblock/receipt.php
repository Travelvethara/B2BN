<?php
require_once('tcpdf_include.php');
// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF('P', 'mm', 'A4', FALSE, 'ISO-8859-1', false, true);
$pdf_footer_html = '<span>&nbsp;&nbsp;&nbsp;Booked and Payable by: sghashja asjhasdhds</span>';
class MYPDF extends TCPDF {
	public function Footer() {
		$this->SetY(-15);
		$this->SetFont('times', 'BI', 12); // Set font
		global $pdf_footer_html;
		// Page number
		$this->writeHTML($pdf_footer_html, true, false, false, false, '');
	}
}
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
// set header and footer fonts
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
require_once(dirname(__FILE__).'/lang/eng.php');
$pdf->setLanguageArray($l);
}
$pdf->SetMargins(0, 0, 0, true);
$pdf->SetFont('times', '', 10);
//$pdf->setCellHeightRatio(0.8);
$pdf->AddPage();

	$pdf_html = '
<table>
   <h3 style="text-align: center">PAYMENT VOUCHER</h3>
   <h4 style="text-align: center">CARIBBEANGOLFCLASSIC2017</h4>
  <tr style="line-height: 30px">
    <td >VOUCHER ID :</td>
    <td>DATE :</td>
  </tr>
  <tr style="line-height: 30px">
    <td>PAYEE :</td>
    <td>TO :</td>
  </tr>
</table>
	
	
<table style="text-align: center">
  <tr style="background-color: #666666;color: #fff;line-height: 30px;">
    <th style="border-bottom: 1px solid #b0b0b0;border-left: 1px solid #b0b0b0">S.No</th>
    <th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">PRODUCT DETAIL</th>
    <th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">QUANTITY</th>
    <th style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0">PRICE</th>
  </tr>
  <tr style="line-height: 30px;">
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0;border-left: 1px solid #b0b0b0">1</td>
    <td style="border-bottom: 1px solid #b0b0b0;font-size: 10px;border-right: 1px solid #b0b0b0">GOLFER DOUBLE OCCUPANCY</td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"></td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"></td>
  </tr>
  <tr style="line-height: 30px;">
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0;border-left: 1px solid #b0b0b0"></td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"> </td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"></td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"></td>
  </tr>
  <tr style="line-height: 30px;">
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0;border-left: 1px solid #b0b0b0"></td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"> </td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"></td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"></td>
  </tr>
  <tr style="line-height: 30px;">
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0;border-left: 1px solid #b0b0b0"></td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"></td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"></td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"></td>
  </tr>
  <tr style="line-height: 30px;">
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0;border-left: 1px solid #b0b0b0"> </td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"> </td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"></td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"></td>
    
  </tr>
  <tr style="line-height: 30px;">
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0;border-left: 1px solid #b0b0b0"></td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"> </td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"></td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"></td>
   
  </tr>
   <tr style="line-height: 30px;">
    <td ></td>
    <td style="border-right: 1px solid #b0b0b0">SUBTOTAL</td>
    <td style="border-bottom: 1px solid #b0b0b0;"></td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"></td>
   
  </tr>
   <tr style="line-height: 30px;">
    <td ></td>
    <td style="border-right: 1px solid #b0b0b0;"> TAXES</td>
    <td style="border-bottom: 1px solid #b0b0b0;"></td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"></td>
   
  </tr>
  <tr style="line-height: 30px;">
    <td ></td>
    <td style="border-right: 1px solid #b0b0b0"> GRAND TOTAL</td>
    <td style="border-bottom: 1px solid #b0b0b0;"></td>
    <td style="border-bottom: 1px solid #b0b0b0;border-right: 1px solid #b0b0b0"></td>
   
  </tr>
  <h2 style="font-size: 12px;line-height: 50px"> 
 THANKYOU FOR BOOKING WITH CARIBBEANGOLFCLASSIC2017</h2>
</table>

';

$pdf->writeHTMLCell(0, 0, '', '', $pdf_html, '0', 1, 0, true, 'L', true);
//Close and output PDF document
$pdf->Output($_SERVER['DOCUMENT_ROOT'].'/SANTHOSH/php/tcpdf-master/examples/receipt.pdf', 'F');