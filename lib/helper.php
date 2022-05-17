<?php




    function get_currency_options (){
        global $db;
        return  $db->query("SELECT * FROM currencies WHERE deleted = 0 ");
    }


    function get_column_value( $table , $id , $column , $error = false){

        if($error){
            echo "SELECT $column FROM `$table` WHERE deleted = '0' AND id = '$id'";
            exit;
        }
    
        global $db;
        $data   = $db->query("SELECT $column FROM `$table` WHERE deleted = '0' AND id = '$id' ");
        return  ($data->rowCount() >  0 ) ? $data->fetch()[$column] : '';
    }

    function get_user_name ($id){
        return get_column_value('users',$id,'full_name');
    }


    function change_master_balance($from_id,$from_amount,$to_id,$to_amount){
        
        //  this function use to update master balance table 
        //  this function well use to all system 
        
        global $db;
        $exe = true;
        
        $update  = increase_currency_amount('master_balance',$from_id,$from_amount);
        if(!$update)
            $exe = false;

        $update =  decrease_currency_amount('master_balance',$to_id,$to_amount);
        if(!$update)
            $exe = false;

        return $exe;
    }


    //  this function use in buy_sell page 
    function get_amount_of_daily_currency($currency_id , $type , $date){

        global $db;

        if ($type == "buy"){
            return $db->query("SELECT SUM(currency_from_amount) as amount FROM `buy_sell` WHERE deleted = 0 AND `date` = '$date' AND `type` = 'buy' AND currency_from_id = $currency_id ")->fetch()['amount'] + 0 ;
        }else {
            return $db->query("SELECT SUM(currency_from_amount) as amount FROM `buy_sell` WHERE deleted = 0 AND `date` = '$date' AND `type` = 'sell' AND currency_from_id = $currency_id ")->fetch()['amount'] + 0 ;
        }
    }


    function increase_currency_amount($table,$currency_id,$amount){

        global $db;

        $main_amount = get_column_value($table,$currency_id,'amount') + $amount;
        $edit = $db->query("UPDATE $table SET  `amount` = '$main_amount' WHERE currency_id = '$currency_id' LIMIT 1 ");

        return ($edit) ? true : false;
    }

    function decrease_currency_amount($table,$currency_id,$amount){

        global $db;

        $main_amount = get_column_value($table,$currency_id,'amount') - $amount;
        $edit = $db->query("UPDATE $table SET  `amount` = '$main_amount' WHERE currency_id = '$currency_id' LIMIT 1 ");
        
        return ($edit) ? true : false;
    }


    //  this function use in buy_sell page 
    function get_amount_of_currency( $type , $currency_id ,  $condation  ){

        global $db;

        if ($type == "buy"){
            return $db->query("SELECT SUM(currency_from_amount) as amount FROM `buy_sell` WHERE deleted = 0 AND `type` = 'buy'  and currency_from_id = $currency_id $condation ")->fetch()['amount'] + 0 ;
        }else {
            return $db->query("SELECT SUM(currency_from_amount) as amount FROM `buy_sell` WHERE deleted = 0 AND `type` = 'sell' and currency_from_id = $currency_id  $condation ")->fetch()['amount'] + 0 ;
        }
    }

     function get_amount_of_currency_pdate( $type , $currency_id ,  $condation){

            global $PDATE;
            global $db;

            if ($type == "buy"){
                return $db->query("SELECT SUM(currency_from_amount) as amount FROM `buy_sell` WHERE deleted = 0 AND `type` = 'buy' AND `date` = '$PDATE'  and currency_from_id = $currency_id $condation ")->fetch()['amount'] + 0 ;
            }else {
                return $db->query("SELECT SUM(currency_from_amount) as amount FROM `buy_sell` WHERE deleted = 0 AND `type` = 'sell' AND `date` = '$PDATE' and currency_from_id = $currency_id  $condation ")->fetch()['amount'] + 0 ;
            }
        }


    function update_currency_rate($user_id , $pdate ){

        global $db;
        $yesterday_date =  date('Y-m-d',strtotime("-1 days"));
        $yesterday_date =  clean_data(gregorian_to_jalali_date($yesterday_date,'-'));
        
        $currencies = select_all('currencies');

        foreach ($currencies as $key => $value) {
            
            $currency_id = $value['id'];
            if($currency_id == 2) 
                continue;

            $data = $db->query(" SELECT * FROM `currency_rate` WHERE currency_from_id = '2' AND  currency_to_id = $currency_id AND date = '$pdate' ORDER BY id DESC LIMIT 1  ");
            if($data->rowCount() > 0 ){

                
                $currency_rate_row = $db->query(" SELECT * FROM `currency_rate` WHERE currency_from_id = '2' AND  currency_to_id = $currency_id AND date = '$yesterday_date' ORDER BY id DESC LIMIT 1  ")->fetch();

                $data = [
                    'currency_from_id'      => '2',
                    'currency_to_id'        => $currency_id,
                    'amount_transaction'    => $currency_rate_row['amount_transaction'],
                    'buy_price'             => $currency_rate_row['buy_price'],
                    'sell_price'            => $currency_rate_row['sell_price'],
                    'date'                  => $pdate,
                    'user_id'               => $user_id,
                ];
                $inesrt = edit('currency_rate',$data,$currency_rate_row['id']);
            }else {

                $data = [
                    'currency_from_id'      => '2',
                    'currency_to_id'        => $currency_id,
                    'amount_transaction'    => 1,
                    'buy_price'             => 1,
                    'sell_price'            => 1,
                    'date'                  => $pdate,
                    'user_id'               => $user_id,
                ];
                 $inesrt = insert('currency_rate',$data);
            }

        }
    }





    function cal_intent( $type , $amount , $currency_id ){
        global $db;

        $final_amount = 0;
        $final_doller_amount = 0;

        if($currency_id == 2 ){
            $final_amount = $amount;
            $final_doller_amount = $amount;
        }else {

            $currency_rate  = $db->query("SELECT `sell_price` , `amount_transaction` FROM `currency_rate` WHERE currency_from_id = '2' AND currency_to_id = '$currency_id' ORDER BY id DESC LIMIT 1    ");
            $currency_rate_value    = 1;
            $amount_transaction     = 1;
            
            if($currency_rate->rowCount() > 0 ){

                $currency_rate_row      = $currency_rate->fetch();
                $currency_rate_value    = ($currency_rate_row['sell_price'] == 0 ) ? 1 : $currency_rate_row['sell_price'] ;
                $amount_transaction     = ($currency_rate_row['amount_transaction'] == 0) ? 1 : $currency_rate_row['amount_transaction'];
            
            } 
            $final_amount = (  $amount / ( $currency_rate_value * $amount_transaction ) ) ;                
        }

        $final_doller_amount = $final_amount;

        if($type == "debt"){
            $final_amount = get_column_value('master_balance',10,'amount') - $final_amount;
        }else if ($type == "credit"){
            $final_amount = get_column_value('master_balance',10,'amount') + $final_amount;
        }
        
        edit('master_balance',['amount' => $final_amount],10);
        
        return $final_doller_amount;
        
    }



?>