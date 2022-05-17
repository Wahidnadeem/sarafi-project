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


$condition  = VD($_GET['query']);

$TIME_STAMP       = date('Y-m-d h-m-s');
$TIME_STAMP       = str_replace(' ','__',$TIME_STAMP);
$DATE       = date('Y-m-d');
$PDATE      = clean_data(gregorian_to_jalali_date($DATE,'-'));



 $view_data = $db->query("SELECT * FROM `accounts` WHERE `deleted` = '0' $condition ORDER BY id DESC ");
$add_br  = '';
$number_loop_count = $view_data->rowCount() % 20;

if($number_loop_count > 11 ){
    $add_br = '<br><br><br><br><br><br><br><br><br><br>';
}

$main_data = '';
$count = 1;
if($view_data->rowCount() > 0  ){                          
                                            
    foreach ($view_data as $key => $row) {

        $array_temp     = [1=> 0,2=>0,3=>0,4=>0,5=>0];
        $total_balance_doller  = 0;
        $account_id = $row['id'];


        $account_balance_data = $db->query("SELECT amount, currency_id FROM `account_balance` WHERE `account_id`='$account_id' $currency_condition  ");
     
        foreach ($account_balance_data as $key => $account_balance_row) {
           $array_temp[$account_balance_row['currency_id']] = $account_balance_row['amount'];                                
        }

        foreach ($array_temp as $key => $array_temp_row) {
            
            if($array_temp_row == 0 )
                continue;

            $currency_id = $key;
            
            $currency_rate  = $db->query("SELECT `sell_price` , `amount_transaction` FROM `currency_rate` WHERE currency_from_id = '2' AND currency_to_id = '$currency_id'  ");
            $currency_rate_value    = 1;
            $amount_transaction     = 1;
            
            if($currency_rate->rowCount() > 0 ){
                
                $currency_rate_row      = $currency_rate->fetch();
                $currency_rate_value    = ($currency_rate_row['sell_price'] == 0 ) ? 1 : $currency_rate_row['sell_price'] ;
                $amount_transaction     = ($currency_rate_row['amount_transaction'] == 0) ? 1 : $currency_rate_row['amount_transaction'];
                
            } 

            if($currency_id == 2){
                $temp = $array_temp_row;
            }else {
                $temp = $array_temp_row / ( $currency_rate_value * $amount_transaction );                
            }

            $total_balance_doller += $temp;
        }


        
        echo '
            <tr> 
                <td> '.($count++).'</td>
                <td> '.$row['account_code'].' </td>
                <td> '.$row['first_name'].' </td>
                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[1].' </span> </td>
                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[2].' </span> </td>
                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[3].' </span> </td>
                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[4].' </span> </td>
                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[5].' </span> </td>
                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" >  '.$total_balance_doller.'</span> </td>
            </tr>

        ';
    }

}
 else {
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

         $array_temp     = [1=> 0,2=>0,3=>0,4=>0,5=>0];
         $temp           = 0;

         if(empty($_POST['search'])){
            
            $total_balance = $db->query("SELECT SUM(amount) as amount , currency_id FROM `account_balance` $currency_condition  GROUP BY currency_id ");

            foreach ($total_balance as $key => $row) {
               $array_temp[$row['currency_id']] = $row['amount'];
            }

         }else {

            $view_data = $db->query(" SELECT * FROM `accounts` WHERE `deleted` = '0' $condition ");

            foreach ($view_data as $key => $accounts_row ) {
               $account_id = $accounts_row['id'];
               $total_balance_customer = $db->query("SELECT SUM(amount) as amount , currency_id FROM `account_balance` WHERE account_id = $account_id $currency_condition  GROUP BY currency_id ");

               foreach ($total_balance_customer as $key => $account_balance_row) {
                  $array_temp[$currency_id] += $account_balance_row['amount'];
               }
            }

         }

         $temp           = 0;
         $total_balance_doller = 0;
         foreach ($array_temp as $key => $array_temp_row) {
                
            if($array_temp_row == 0 )
               continue;

            $currency_id = $key;
            
            $currency_rate  = $db->query("SELECT `sell_price` , `amount_transaction` FROM `currency_rate` WHERE currency_from_id = '2' AND currency_to_id = '$currency_id'  ");
            $currency_rate_value    = 1;
            $amount_transaction     = 1;
            
            if($currency_rate->rowCount() > 0 ){
                
               $currency_rate_row      = $currency_rate->fetch();
               $currency_rate_value    = ($currency_rate_row['sell_price'] == 0 ) ? 1 : $currency_rate_row['sell_price'] ;
               $amount_transaction     = ($currency_rate_row['amount_transaction'] == 0) ? 1 : $currency_rate_row['amount_transaction'];
                
            } 

            if($currency_id == 2){
               $temp = $array_temp_row;
            }else {
               $temp = $array_temp_row / ( $currency_rate_value * $amount_transaction );                
            }

            $total_balance_doller += $temp;
         }

         echo '
            <tr>
               <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[1].'  </span></th>
               <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[2].'  </span></th>
               <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[3].'  </span></th>
               <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[4].'  </span></th>
               <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[5].'  </span></th>
               <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$total_balance_doller.'  </span></th>
            </tr>
         ';


$html = '
    <div style ="text-align:right;position:relative;top:30px; font-size:16px  " >   گزارش انتقالات و معاملات پولی </div>
    <div style ="text-align:right;position:relative;top:30px; font-size:16px  " >   دارنده حساب :   </div>
    <div style ="text-align:right;position:relative;top:30px; font-size:16px  " > شماره حساب  : </div>
    <div style ="text-align:right;position:relative;top:30px; font-size:16px  " >تاریخ گزارش  : '.$PDATE.' </div>
    <br>

<table border="1"  cellpadding="5">
    <tr>
        <th  align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="150">شماره</th>
        <th  align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="150">حساب</th>
        <th  align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="150">نام</th>
        <th  align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="150">افغانی</th>
        <th  align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="150">دالر</th>
        <th  align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="150">تومان</th>
        <th  align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="150">کلدار</th>
        <th  align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="150">یورو</th>
        <th  align="center" style="font-weight:600;background-color:#95ccec;color:#000"  width="150">بیلانس</th>
    </tr>
    '.$main_data.'
   
</table>
<br><br><br>'.$add_br.'
<h4 align="right">
 مجموع کل
</h4>
<table border="1"  cellpadding="4">
    <tr>
         <th align="center"> مجموعه افغانی   </th>
         <th align="center"> مجموعه دالر </th>
         <th align="center"> مجموعه تومان </th>
         <th align="center">مجموعه  کلدار</th>
         <th align="center">مجموعه یورو</th>
         <th align="center"> مجموعه به دالر  </th>
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