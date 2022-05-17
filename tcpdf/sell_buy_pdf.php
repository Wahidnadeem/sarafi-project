<?php


require_once "../lib/db.php";

require_once('tcpdf/tcpdf.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);




// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN , "گزارش "));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$font_brabds = TCPDF_FONTS::addTTFfont('../view/assist/css/webfonts/Vazir-Regular.ttf');
$pdf->SetFont($font_brabds, '', 12 , '' , false);

$pdf->SetHeaderData(    PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH,"" );

$pdf->AddPage();

$main_data = '

    <tr>
        <td align="center">برای تست است</td>
        <td align="center">1400-10-06</td>
        <td align="center" style="color:red"> فروش</td>
        <td align="center">    12</td>
        <td align="center">یورو - 2,532</td>
        <td align="center">کلدار - 211</td>
        <td align="center">1</td>
    </tr>
    <tr>
        <td align="center">برای تست است</td>
        <td align="center">1400-10-06</td>
        <td align="center" style="color:green"> خرید</td>
        <td align="center">    12</td>
        <td align="center">یورو - 2,532</td>
        <td align="center">کلدار - 211</td>
        <td align="center">1</td>
    </tr>

';

$totla_amount='
     <tr>
        <td align="center">10000000</td>
        <td align="center">10000000</td>
        <td align="center">10000000</td>
        <td align="center">10000000</td>
        <td align="center">10000000</td>
        <td align="center">10000000</td>
    </tr>
';

$html = '
    <div style ="text-align:right;position:relative;top:30px; font-size:16px  " >   گزارش  خرید و فروش </div>
    <div style ="text-align:right;position:relative;top:30px; font-size:16px  " >   دارنده حساب :   محمد</div>
    <div style ="text-align:right;position:relative;top:30px; font-size:16px  " > شماره حساب  : 123333 </div>
    <div style ="text-align:right;position:relative;top:30px; font-size:16px  " >تاریخ گزارش  :  1400/12/2</div>
    <br>

<table border="1"  cellpadding="5">
    <tr>
        <th align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="150">توضیحات</th>
        <th align="center" style="font-weight:600;background-color:#95ccec;color:#000" width="100">تاریخ</th>
        <th align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="50"> نوعیت</th>
        <th align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="50">    نرخ</th>
        <th align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="133">به پول</th>
        <th align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="133">از پول</th>
        <th align="left" style="font-weight:600;background-color:#95ccec;color:#000"  width="40" >شماره</th>
    </tr>
    '.$main_data.'
   
</table>
<br><br><br>'.$add_br.'
<h4 align="right">
 مجموع  خرید و فروش
</h4>
<table border="1"  cellpadding="4">
    <tr>
        <th align="center">مجموعه  به دالر</th>
        <th align="center">مجموعه یورو</th>
        <th align="center">مجموعه کلدار</th>
        <th align="center">مجموعه تومان</th>
        <th align="center"> مجموعه دالر</th>
        <th align="center">مجموعه افغانی</th>
    </tr>
    
    '.$totla_amount.'
   
</table>



';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->lastPage();


//Close and output PDF document
$string = $account_id.' - '.$TIME_STAMP;
$pdf->Output($string.'.pdf', 'I');

//============================================================+
// END OF FILE