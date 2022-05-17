<?php

    require_once "_config.php";

    $type = VD($_POST['type']);

    if($type == "is_currncy_rate_exist"){

        $from_id    = VD($_POST['from_id']);
        $to_id      = VD($_POST['to_id']);

        $get_data = $db->query("SELECT amount_transaction,buy_price , sell_price , note FROM currency_rate WHERE  currency_from_id = '$from_id' AND currency_to_id  = '$to_id'  AND deleted = '0' ORDER BY id DESC LIMIT 1 ");
        
        if ($get_data->rowCount() > 0 ){
            $row = $get_data->fetch();
            echo json_encode($row);
        }else {
            echo 'false';
        }
        exit;
    }


    else if ( $type == "getCurrencyRate" ){

        $from_id            = VD($_POST['from_id']);
        $to_id              = VD($_POST['to_id']);

        $get_data = $db->query("SELECT amount_transaction,buy_price , sell_price  FROM currency_rate WHERE currency_from_id = '$from_id' AND currency_to_id  = '$to_id' AND deleted = '0'ORDER BY id DESC LIMIT 1 ");

        if($get_data->rowCount() > 0 ){
            $row = $get_data->fetch();
            echo json_encode($row);
        }else {
            echo 'false';
        }
        exit;

    }

    //  this is use in customer_transcation page
    else if ($type == "getDetailsAccountBalance") {

        $account_id  = VD($_POST['account_id']);
        $output = '';

        $view_data = $db->query("SELECT * FROM `account_transaction` WHERE deleted = '0' and  account_id = '$account_id' ORDER BY id DESC LIMIT 5");


        if( $view_data->rowCount() > 0  ) {
            foreach ($view_data as $rows) {

                // $account_row = select_one(`accounts`,$rows['account_id']);

                $currency_row = select_one('currencies',$rows['currency_id']);

                if ($rows['type'] == "credit") {
                    $type_status = '<td class ="recive_money">رسید</td>';
                }elseif($rows['type'] == "debt"){
                    $type_status = '<td class ="send_money">برد</td>';
                }

                $output .= '
                <tr class="active">
                    <td >' . ($count++) . ' </td>
                    '. $type_status.'
                    <td >' . $rows['by_person'] . ' </td>
                    <td >' . $currency_row['name'] . ' </td>
                    <td ><span class ="label label-info togg CurNumDiv_a"> '.$rows['amount']. '</span> <span class="h4 mb-0 togg priv">******</span> </td>
                    <td >' . $rows['date'] . ' </td>
            
                </tr>
                ';
            }
        }else {
            $output = '
            <tr>
                <td colspan="13" class="text-center">
                    <img src="img/empty.png">
                    <br>
                    کدام اطلاعاتی وجود ندارد 
                    <br><br>
                </td>
            </tr>
            ';
        }


        $account_master_blance = $db->query("SELECT * FROM `account_balance` WHERE account_id = $account_id  ");
        $total_doller = 0;

        foreach ($account_master_blance as $key => $value) {
                                                    
            $currency_id    = $value['currency_id'];
            $currency_rate  = $db->query("SELECT `sell_price` , `amount_transaction` FROM `currency_rate` WHERE currency_from_id = '2' AND currency_to_id = '$currency_id' ORDER BY id DESC LIMIT 1  ");
            $currency_rate_value    = 1;
            $amount_transaction     = 1;
            
            if($currency_rate->rowCount() > 0 ){
                
                $currency_rate_row      = $currency_rate->fetch();
                $currency_rate_value    = ($currency_rate_row['sell_price'] == 0 ) ? 1 : $currency_rate_row['sell_price'] ;
                $amount_transaction     = ($currency_rate_row['amount_transaction'] == 0) ? 1 : $currency_rate_row['amount_transaction'];
                
            } 

            if($value['currency_id'] == 2){
                $temp = $value['amount'];
            }else {
                $temp = $value['amount'] / ( $currency_rate_value * $amount_transaction );                
            }

            $total_doller += $temp;
        }

        
        
        $total_dollar = ( $total_doller  < 0  ) ? '<span class ="send_money"> '.number_format($total_doller, 2).' </span>' : ''.number_format($total_doller, 2).''  ;
        
        $amount_of_currecny = [];

        $account_row        = $db->query("SELECT * FROM `account_balance` WHERE `account_id` = '$account_id' AND `deleted` = '0' ");
        foreach ($account_row as $key => $value) {
            $amount_of_currecny[$value['currency_id']] = $value['amount'];
        }

        $master_blance = '';
        $numbers = ['1','2','3','4','5'];
        foreach ($numbers as $key => $value) {
            if(isset($amount_of_currecny[$value])){
                $color_lable = (  $amount_of_currecny[$value] >= 0  ) ? '' : 'send_money' ;
                $master_blance .= '<td><span class ="'.$color_lable.'" dir="ltr"><span class="togg CurNumDiv_a">'.$amount_of_currecny[$value].'</span><span class="h4 mb-0 togg priv">******</span></span></td>'; 
            }else {
                $master_blance .= '<td><span> 0 </span></td>';
            }                                                          
        }

        $short_account_report = '
        <div class="row">
            <div class="col-md-8">
                <a class = "d-grid gap-2" href = "short_account_report.php?id='.base64_encode($account_id).'">
                    <button class="btn btn-outline-dark" type="button">کل انتقالات</button>
                </a>    
            </div>
            <div class="col-md-4">
                <a class = "d-grid gap-2" href = "../tcpdf/transcation_pdf.php?account_id='.base64_encode($account_id).'">
                    <button class="btn btn-outline-dark" type="button"><i class="fa fa-file-pdf"></i></button> 
                </a>   
            </div>
        </div>        
        ';

        echo $output.'##'.$total_dollar.'##'.$master_blance .'##'.$short_account_report;
        exit;

        // $color_lable = (  $total_blance_in_usd >= 0  ) ? 'info' : 'danger' ;
        // echo '<th class="center cfont"><span class ="label label-'.$color_lable.'"> '.number_format($total_blance_in_usd,2).' </span></th>';
        // echo '<th class="center cfont" style="cursor: pointer" ><span onclick="popup(\'customer_popup_report.php?search_customer='.$customer_id.'&search=1\')"> <i class="fa fa-file"></i>  </span></th>';

        // echo '</tr>';
        // exit;
    }


    //  this is use in customer_transcation page
    else  if ( $type == "is_bigger" ) {

        $currency_id            = VD($_POST['currency_id']);
        $account_amount         = VD($_POST['debt_amount']);
        $account_id             = VD($_POST['account_id']);

        $account_amount         = str_replace(',','',$account_amount);


        $select_amount_account = $db->query("SELECT amount FROM account_balance WHERE account_id = '$account_id' AND currency_id = '$currency_id' LIMIT 1  ");
        $amount = ( $select_amount_account->rowCount() > 0  ) ? $select_amount_account->fetch()['amount'] * 1 : 0; 
        if ($amount >= $account_amount) {
            echo "false";
        }else{
            echo "true";
        }
        exit();
    } 


    // GET DETAILS ABOUT LAST TEN TRANSFERS TRADER Hamid comment this part of code becase this table is not exist 
    // else  if ($type == "getDetailsTraderTransfers") {

    //     $trader_id         = $_POST['trader_id'];

    //     $list_data = $db->query("SELECT * FROM money_transfer WHERE `trader_id` = '$trader_id' AND `deleted` = '0' ORDER BY id DESC LIMIT 10");

    //     if($list_data->rowCount() > 0 ) {
    //         foreach ($list_data as $row_data) {

    //             $currency_id = $row_data['currency_id'];
    //             $found_currency = $db->query("SELECT name FROM currencies WHERE `id` = '$currency_id' AND `deleted` = '0' LIMIT 1")->fetch();
    //             $currency_name = $found_currency['name'];

    //             if ($row_data['type_transaction'] == "credit") {
    //                 $type_status = '<td class = "text-center" style = "background:#24dd6e;">گرفته</td>';
    //             }else if($row_data['type_transaction'] == "debt"){
    //                 $type_status = '<td class = "text-center" style = "background:#f15067;">فرستاده</td>';
    //             }

    //             echo '

    //             <tr>
    //                     <th>'.($count++).'</th>
    //                     '.$type_status.'
    //                     <th>'.$currency_name.'</th>
    //                     <th>'.$row_data['amount'].'</th>
    //                     <th>'.$row_data['date'].'</th>
    //             </tr> ';

    //             }
    //             echo ' <th class="center text-muted" colspan="3" style="cursor: pointer; font-size:16px; font-family: bfont"><span onclick="popup(\'trader_popup_report.php?search_trader='.$trader_id.'&search=1\')"> <i class="fa fa-file">  <span style="font-family: \'BTITRBD-BOLD\';">دیدن تمامی انتقالات پولی</span> </i>  </span></th> ';
    //         }else{
    //             echo ' <tr>
    //                     <td colspan="5" class="center blue"><p style="padding:10px;padding-top:15px;"><i class="fa fa-refresh fa-spin"> </i> هیچ حواله نیست</p></td>
    //                 </tr>';
    //         }
    //     }

        else if ( $type == "getDetailsAccountBalance_index" ) {

            $account_id = VD($_POST['account_id']);

            $account_row = select_one('accounts',$account_id);
            $output = $account_row['first_name'].'##';

            $view_data = $db->query("SELECT * FROM `account_transaction` WHERE deleted = '0' and  account_id = '$account_id' ORDER BY id DESC LIMIT 5");
            
            if( $view_data->rowCount() > 0  ) {
                foreach ($view_data as $rows) {
        
                    $currency_row = select_one('currencies',$rows['currency_id']);
    
                    if ($rows['type'] == "credit") {
                        $type_status = '<td class ="recive_money">رسید</td>';
                    }elseif($rows['type'] == "debt"){
                        $type_status = '<td class ="send_money">برد</td>';
                    }
    
                    $output .= '
                    <tr class="active">
                        <td >' . ($count++) . ' </td>
                        '. $type_status.'
                        <td >' . $rows['by_person'] . ' </td>
                        <td >' . $currency_row['name'] . ' </td>
                        <td ><span class ="label label-info togg CurNumDiv_a"> '.$rows['amount']. '</span> <span class="h4 mb-0 togg priv">******</span> </td>
                        <td >' . $rows['date'] . ' </td>
                
                    </tr>
                    ';
                }
            }else {
                $output .= '
                <tr>
                    <td colspan="13" class="text-center">
                        <img src="img/empty.png">
                        <br>
                        کدام اطلاعاتی وجود ندارد 
                        <br><br>
                    </td>
                </tr>
                ';
            }

            $output .= '##';


            $account_master_blance = $db->query("SELECT * FROM `account_balance` WHERE account_id = $account_id  ");
            $total_doller = 0;

            foreach ($account_master_blance as $key => $value) {
                                                        
                $currency_id    = $value['currency_id'];
                $currency_rate  = $db->query("SELECT `sell_price` , `amount_transaction` FROM `currency_rate` WHERE currency_from_id = '2' AND currency_to_id = '$currency_id'  ");
                $currency_rate_value    = 1;
                $amount_transaction     = 1;
                
                if($currency_rate->rowCount() > 0 ){
                    
                    $currency_rate_row      = $currency_rate->fetch();
                    $currency_rate_value    = ($currency_rate_row['sell_price'] == 0 ) ? 1 : $currency_rate_row['sell_price'] ;
                    $amount_transaction     = ($currency_rate_row['amount_transaction'] == 0) ? 1 : $currency_rate_row['amount_transaction'];
                    
                } 

                if($value['currency_id'] == 2){
                    $temp = $value['amount'];
                }else {
                    $temp = $value['amount'] / ( $currency_rate_value * $amount_transaction );                
                }

                $total_doller += $temp;
            }


            $total_dollar = ( $total_doller  < 0  ) ? '<span class ="send_money"> '.number_format($total_doller, 2).' </span>' : ''.number_format($total_doller, 2).''  ;
        
            $amount_of_currecny = [];

            $account_row        = $db->query("SELECT * FROM `account_balance` WHERE `account_id` = '$account_id' AND `deleted` = '0' ");
            foreach ($account_row as $key => $value) {
                $amount_of_currecny[$value['currency_id']] = $value['amount'];
            }

            $master_blance = '';
            $numbers = ['1','2','3','4','5'];

            $output .= '<div class="row pt-3">';

            foreach ($numbers as $key => $value) {
                if(isset($amount_of_currecny[$value])){
                    $color_lable = (  $amount_of_currecny[$value] >= 0  ) ? '' : 'send_money' ;
                    $output .= '
                        <div class="col-12 d-flex justify-content-between pb-2 pt-2 border-bottom">
                            <div> '.$MIAN_CURRENCIES[$value].'</div>
                            <div class="'.$color_lable.'"><span class="togg CurNumDiv_a ">'.( $amount_of_currecny[$value] *1  ).'</span><span class="h4 mb-0 togg priv">******</span></span></div>
                        </div>
                    ';
                    // $master_blance .= '<td><span class ="'.$color_lable.'" dir="ltr"><span class="togg CurNumDiv_a">'.$amount_of_currecny[$value].'</span><span class="h4 mb-0 togg priv">******</span></span></td>'; 
                }else {
                    $output .= '
                        <div class="col-12 d-flex justify-content-between pb-2 pt-2 border-bottom">
                            <div> '.$MIAN_CURRENCIES[$value].'</div>
                            <div> 0 </div>
                        </div>
                    ';
                }                                                          
            }

            $output .= '
                    <div class="col-12 d-flex justify-content-between pb-2 pt-4">
                        <div class="lalezar text-muted">مجموعه کل به دالر </div>
                        <div class="">'.$total_dollar.'</div>
                    </div>
                </div>##
            ';


            echo $output;
            exit;

        }


        else  if($type == "CHANGE_IMG_ICON"){
            $key = VD($_POST['key']);
            $_SESSION['EYE'] = ( $key == "show" ) ? "SHOW" : "HIDE";
            exit;
        }




?>