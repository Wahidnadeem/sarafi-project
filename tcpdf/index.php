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


$account_id = base64_decode($_GET['account_id']);
$condition  = VD($_GET['query']);

$TIME_STAMP       = date('Y-m-d h-m-s');
$TIME_STAMP       = str_replace(' ','__',$TIME_STAMP);
$DATE       = date('Y-m-d');
$PDATE      = clean_data(gregorian_to_jalali_date($DATE,'-'));



$view_data = $db->query("SELECT * FROM `account_transaction` WHERE `account_id` = '$account_id' AND deleted = '0' $condition ORDER BY id DESC  ");

$add_br  = '';
$number_loop_count = $view_data->rowCount() % 20;

if($number_loop_count > 11 ){
    $add_br = '<br><br><br><br><br><br><br><br><br><br>';
}

$main_data = '';
$count = 1;
if( $view_data->rowCount() > 0  ) {
    foreach ($view_data as $rows) {

       
       $account_row = select_one('accounts',$rows['account_id']);
       $currency_row = select_one('currencies',$rows['currency_id']);

       if ($rows['type'] == "credit") {
          $type_status = '<span style="color:#00d97e">رسید</span>';
       }elseif($rows['type'] == "debt"){
          $type_status = '<span style="color:#f6465d">برد</span>';
       }

       $main_data .= '

       <tr>
        <td align="right"> ' . $rows['note'] . '  </td>
        <td align="center">'.$rows['date']. '</td>
        <td align="center" > '.$type_status.' </td>
        <td align="center"> '.number_format('%i',$rows['amount']). '</td>
        <td align="center"> ' . $currency_row['name'] . ' </td>
        <td align="center">'. $rows['by_person'] . ' </td>
        <td align="center"> '.$count++.' </td>
    </tr>
       ';
    }
 }else {
    $main_data .= '
    <tr>
    <td colspan="7" class="text-center" style="text-align:center">
    <br>
    کدام اطلاعاتی وجود ندارد 
    <br><br>
    </td>
    </tr>
    ';
 }
 $totla_amount = '';

 foreach ($MIAN_CURRENCIES as $key => $value) {

    $credit = $db->query("SELECT SUM(amount) as amount FROM `account_transaction` WHERE deleted = 0 
    AND `type` = 'credit' AND `account_id` = '$account_id' AND `currency_id` = $key $condition ")->fetch()['amount'] + 0 ;

    $debt = $db->query("SELECT SUM(amount) as amount FROM `account_transaction` WHERE deleted = 0 AND `type` = 'debt' AND `account_id` = '$account_id' AND `currency_id` = $key $condition")->fetch()['amount'] + 0 ;

            $master_blance_amount = $credit - $debt;
            if ($master_blance_amount < 0) {
             $master_blance = '<span class = "send_money" dir = "ltr">'.$master_blance_amount.'</span>';
            }elseif($master_blance_amount >=0){
              $master_blance = '<span class = "default">'.$master_blance_amount.'</span>';
            }

            $totla_amount .= '
               <tr>
                  <td align="center"> '.$master_blance.' </td>
                  <td align="center"> <span class="'.$CURRENCY_ICON[$key].'">  '.$debt.' </span> </td>
                  <td align="center"> <span class="'.$CURRENCY_ICON[$key].'">  '.$credit.' </span> </td>
                  <td align="center"> <span class="'.$CURRENCY_ICON[$key].'"> '.$MIAN_CURRENCIES[$key].' </span> </td>
               </tr>
            ';
         }

    



 $account_row  = select_one('accounts',$account_id);


$html = '
    <div style ="text-align:right;position:relative;top:30px; font-size:16px  " >   گزارش انتقالات و معاملات پولی </div>
    <div style ="text-align:right;position:relative;top:30px; font-size:16px  " >   دارنده حساب :'.$account_row['first_name'].' '.$account_row['last_name'].'   </div>
    <div style ="text-align:right;position:relative;top:30px; font-size:16px  " > شماره حساب  : '.$account_row['account_code'].  '</div>
    <div style ="text-align:right;position:relative;top:30px; font-size:16px  " >تاریخ گزارش  : '.$PDATE.' </div>
    <br>

<table border="1"  cellpadding="5">
    <tr>
        <th align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="150">توضیحات</th>
        <th align="center" style="font-weight:600;background-color:#95ccec;color:#000" width="110">تاریخ</th>
        <th align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="50">نوعیت</th>
        <th align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="100">مقدار</th>
        <th align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="70">واحد پول</th>
        <th align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="133">توسط</th>
        <th align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="40" >شماره</th>
    </tr>
    '.$main_data.'
   
</table>
<br><br><br>'.$add_br.'
<h4 align="right">
 مجموع کل
</h4>
<table border="1"  cellpadding="4">
     <tr>
        <th align="center" width="164">موجودی فعلی</th>
        <th align="center" width="164">برد</th>
        <th align="center" width="164">رسید</th>
        <th align="center" width="164">واحد پول</th>
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