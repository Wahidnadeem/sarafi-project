<?php


    require_once "_config.php";
    
    if( isset($_POST['insert']) ){


        // this is use for trancation 
        $db->beginTransaction();
        $exc = true;

        $currency_from_id       = VD($_POST['currency_from_id']);
        $currency_from_amount   = VD($_POST['currency_from_amount']);
        $currency_to_id         = VD($_POST['currency_to_id']);
        $currency_to_amount     = VD($_POST['currency_to_amount']);
        $rate                   = VD($_POST['rate']);
        $date                   = VD($_POST['date']);
        $note                   = VD($_POST['note']);
        $page                   = VD($_POST['page']);

        $currency_from_amount   = str_replace(',','',$currency_from_amount);
        $currency_to_amount     = str_replace(',','',$currency_to_amount);

        $type                   = VD($_POST['type']);



        $insert = insert(
            'buy_sell',
            [
                'currency_from_id'      => $currency_from_id, 
                'currency_from_amount'  => $currency_from_amount, 
                'currency_to_id'        => $currency_to_id, 
                'currency_to_amount'    => $currency_to_amount, 
                'rate'                  => $rate, 
                'date'                  => $date, 
                'note'                  => $note, 
                'type'                  => $type, 
                'user_id'               => $user_id, 
            ]
        );

        $last_id  = $db->lastInsertId();

        if(!$insert){
            $db->rollback();
            header("location: buy_sell.php?error");
            exit();
        }
        
        if($type == "buy"){
            $exc = change_master_balance( $currency_from_id , $currency_from_amount , $currency_to_id , $currency_to_amount );
        }
        else if  ($type == "sell"){
            $exc = change_master_balance( $currency_to_id , $currency_to_amount , $currency_from_id , $currency_from_amount );
        }


        //  calculate  intent part 
        if($type == "sell"){

            $get_buy_rate = $db->query("SELECT `buy_price` , `amount_transaction` FROM currency_rate WHERE currency_from_id = $currency_from_id AND currency_to_id = $currency_to_id ORDER BY id DESC LIMIT 1 ");

            $amount_transaction_sell = 1;;
            $buy_rate = 1;

            if($get_buy_rate->rowCount() > 0){
                $get_buy_rate_row = $get_buy_rate->fetch();
                $buy_rate                   = $get_buy_rate_row['buy_price'];
                $amount_transaction_sell    = $get_buy_rate_row['amount_transaction'];
            }

            $intent_amount  = ($currency_from_amount * $buy_rate) /  $amount_transaction_sell;
            $intent_amount = $currency_to_amount - $intent_amount;

            $final_amount   = cal_intent('credit',$intent_amount,$currency_to_id); 

            $last_id = $db->query(" SELECT id FROM buy_sell ORDER BY id DESC ")->fetch()['id'];

            $data = [
                'type'          => 'credit',
                'amount'        => $intent_amount,
                'date'          => $date,
                'page'          => 'buy_sell',
                'user_id'       => $user_id,
                'page_id'       => $last_id,
                'currency_id'   => $currency_to_id,
                'note'          => $note,
                'final_amount'  => $final_amount,
                'buy_rate'      => $buy_rate,
                'sell_rate'     => $rate,
            ];
            
            $insert = insert('intent',$data);
            if(!$insert){
                $db->rollback();
                header("location: buy_sell.php?error");
                exit();
            }            

        }


        // $currency_rate = $db->query("SELECT * FROM `currency_rate` WHERE `currency_from_id` = '$currency_from_id' AND `currency_to_id` = '$currency_to_id' AND `deleted` = '0' AND `date` = '$PDATE' LIMIT 1")->fetch();
        // $amount_transaction = $currency_rate['amount_transaction'];
        // $buy_price = $currency_rate['buy_price'];

        // //dollar/afghani    AND dollar/Toman
        // if (($currency_from_id == 2 AND $currency_to_id == 1) OR ($currency_from_id == 2 AND $currency_to_id == 3)OR ($currency_from_id == 2 AND $currency_to_id == 4) OR ($currency_from_id == 5 AND $currency_to_id == 1))  {
            
        //     $currency_from_amount_rate = $buy_price * $currency_from_amount;
        //     $currency_from_amounts_buy = $rate * $currency_from_amount;

        //     $final_amounts = ($currency_from_amounts_buy - $currency_from_amount_rate) * $amount_transaction ;
           
        // // Toman/Aghani
        // }elseif(($currency_from_id == 3 AND $currency_to_id == 1) OR ($currency_from_id == 4 AND $currency_to_id == 1)){

        //         $currency_from_amount_rate = $currency_from_amount * $buy_price;
        //         $currency_from_amounts_buy = $currency_from_amount * $rate ;

        //         $final_amounts = ($currency_from_amounts_buy - $currency_from_amount_rate) / $amount_transaction;

        //  // Toman/dollar
        // }elseif($currency_from_id == 3 AND $currency_to_id == 2){

        //         $currency_from_amount_rate = $currency_from_amount / $buy_price ;
        //         $currency_from_amounts_buy = $currency_from_amount / $rate ;

        //         $final_amounts = ($currency_from_amounts_buy - $currency_from_amount_rate) * $amount_transaction;
        // }

        // if ($type =="sell") {
           
        //     $intent_amount = cal_intent( $type , $final_amounts , $currency_to_id);

        //      $data = [
        //         'type'          => 'credit',
        //         'amount'        => VD($final_amounts),
        //         'page'          => 'buy_sell',
        //         'page_id'       => $last_id,
        //         'final_amount'  => $intent_amount,
        //         'currency_id'   => VD($_POST['currency_from_id']),
        //         'note'          => VD($_POST['note']),
        //         'date'          => VD($_POST['date']),
        //         'user_id'       => $user_id,
        //     ];

        //     $insert = insert('intent',$data);

        // }

        if($exc){
            $db->commit();
            header("location: buy_sell.php?saved");
            exit();
        }else {
            $db->rollback();
            header("location: buy_sell.php?error");
            exit();
        }
    }



    if(isset($_GET['delete']) && isset($_GET['id']) ){


        $id = base64_decode($_GET['id']);
        $buy_sell_row = select_one('buy_sell',$id);

        $db->beginTransaction();
        $exc = true;

        $currency_from_id       = $buy_sell_row['currency_from_id'];
        $currency_from_amount   = $buy_sell_row['currency_from_amount'];
        $currency_to_id         = $buy_sell_row['currency_to_id'];
        $currency_to_amount     = $buy_sell_row['currency_to_amount'];
        $type                   = $buy_sell_row['type'];


        if($type == "sell")
            $exc = change_master_balance( $currency_from_id , $currency_from_amount , $currency_to_id , $currency_to_amount );
        else if  ($type == "buy")
            $exc = change_master_balance( $currency_to_id , $currency_to_amount , $currency_from_id , $currency_from_amount );


        if(!$exc){
            $db->rollback();
            header("location: buy_sell.php?error");
            exit();
        }


        if ($type == "sell"){

            $intent_data = $db->query(" SELECT * FROM intent WHERE page_id = '$id' AND `page` = 'buy_sell' ");
            if($intent_data->rowCount() > 0 ){

                $intent_row  = $intent_data->fetch();
                $current_amount = get_column_value('master_balance',10,'amount'); 
                $edit = edit('master_balance',['amount' =>  ($current_amount - $intent_row['final_amount'])], 10);
                
                if(!$edit){
                    $db->rollback();
                    header("location: buy_sell.php?error");
                    exit();
                }

                $deleted = $db->query(" UPDATE `intent` SET deleted = 1 WHERE page_id = '$id' AND `page` = 'buy_sell' LIMIT 1 ");

                if(!$deleted){
                    $db->rollback();
                    header("location:transcation.php?error");
                    exit();
                }

            }
        }


        $edit = edit('buy_sell',['deleted'=>1],$id);

        if($edit){
            $db->commit();
            header("location: buy_sell.php?deleted");
            exit();
        }else {
            $db->rollback();
            header("location: buy_sell.php?error");
            exit();
        }

    }


    if(isset($_POST['edit']) && isset($_POST['row_id']) ){


        // this is use for trancation 
        $db->beginTransaction();
        $exc = true;


        $id             = base64_decode($_POST['row_id']);
        $buy_sell_row   = select_one('buy_sell',$id);

        $currency_from_id       = $buy_sell_row['currency_from_id'];
        $currency_from_amount   = $buy_sell_row['currency_from_amount'];
        $currency_to_id         = $buy_sell_row['currency_to_id'];
        $currency_to_amount     = $buy_sell_row['currency_to_amount'];
        $current_type           = $buy_sell_row['type'];


        if($current_type == "sell")
            $exc = change_master_balance( $currency_from_id , $currency_from_amount , $currency_to_id , $currency_to_amount );
        else if  ($current_type == "buy")
            $exc = change_master_balance( $currency_to_id , $currency_to_amount , $currency_from_id , $currency_from_amount );


        if(!$exc){
            $db->rollback();
            header("location: buy_sell.php?error");
            exit();
        }


        $currency_from_id       = VD($_POST['currency_from_id']);
        $currency_from_amount   = VD($_POST['currency_from_amount']);
        $currency_to_id         = VD($_POST['currency_to_id']);
        $currency_to_amount     = VD($_POST['currency_to_amount']);
        $rate                   = VD($_POST['rate']);
        $date                   = VD($_POST['date']);
        $note                   = VD($_POST['note']);

        $type                   = VD($_POST['type']);

        $currency_from_amount   = str_replace(',','',$currency_from_amount);
        $currency_to_amount     = str_replace(',','',$currency_to_amount);

        $edit = edit(
            'buy_sell',
            [
                'currency_from_id'      => $currency_from_id, 
                'currency_from_amount'  => $currency_from_amount, 
                'currency_to_id'        => $currency_to_id, 
                'currency_to_amount'    => $currency_to_amount, 
                'rate'                  => $rate, 
                'date'                  => $date, 
                'note'                  => $note, 
                'type'                  => $type, 
            ],
            $id
        );


        if(!$edit){
            $db->rollback();
            header("location: buy_sell.php?error");
            exit();
        }
    

        if($type == "buy")
            $exc = change_master_balance( $currency_from_id , $currency_from_amount , $currency_to_id , $currency_to_amount );
        else if  ($type == "sell")
            $exc = change_master_balance( $currency_to_id , $currency_to_amount , $currency_from_id , $currency_from_amount );


        $intent_data = $db->query(" SELECT * FROM intent WHERE `page` = 'buy_sell' AND `page_id` = $id LIMIT 1  ");
        
        if($intent_data->rowCount() > 0 ){

            $intent_row  = $intent_data->fetch();
            $current_amount = get_column_value('master_balance',10,'amount'); 
            $edit = edit('master_balance',['amount' =>  ($current_amount - $intent_row['final_amount'])], 10);
            
            if(!$edit){
                $db->rollback();
                header("location: buy_sell.php?error");
                exit();
            }


            if($type == "sell"){

                $get_buy_rate = $db->query("SELECT `buy_price` , `amount_transaction` FROM currency_rate WHERE currency_from_id = $currency_from_id AND currency_to_id = $currency_to_id ORDER BY id DESC LIMIT 1 ");

                $amount_transaction_sell = 1;
                $buy_rate = 1;

                if($get_buy_rate->rowCount() > 0){
                    $get_buy_rate_row = $get_buy_rate->fetch();
                    $buy_rate                   = $get_buy_rate_row['buy_price'];
                    $amount_transaction_sell    = $get_buy_rate_row['amount_transaction'];
                }

                $intent_amount  = ($currency_from_amount * $buy_rate) /  $amount_transaction_sell;
                $intent_amount = $currency_to_amount - $intent_amount;

                $final_amount   = cal_intent('credit',$intent_amount,$currency_to_id); 
                
                $data = [
                    'amount'        => $intent_amount,
                    'date'          => $date,
                    'currency_id'   => $currency_to_id,
                    'note'          => $note,
                    'final_amount'  => $final_amount,
                    'buy_rate'      => $buy_rate,
                    'sell_rate'     => $rate,
                ];
                
                $edit = edit('intent',$data,$intent_row['id']);

                if(!$edit){
                    $db->rollback();
                    header("location: buy_sell.php?error");
                    exit();
                }

            }
        }


        if($exc){
            $db->commit();
            header("location: buy_sell.php?edit");
            exit();
        }else {
            $db->rollback();
            header("location: buy_sell.php?error");
            exit();
        }


    }




?>