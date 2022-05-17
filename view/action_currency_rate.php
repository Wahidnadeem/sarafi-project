<?php

    require_once "_config.php";

    if(isset($_POST['insert'])){

        // this is use for trancation 
        $db->beginTransaction();
        $exc = true;
        
        $currency_from_id   = VD($_POST['currency_from_id']);
        $currency_to_id     = VD($_POST['currency_to_id']);
        $amount_transaction = VD($_POST['amount_transaction']);
        $buy_price          = VD($_POST['buy_price']); 
        $sell_price         = VD($_POST['sell_price']);
        $date               = VD($_POST['date']);
        $note               = VD($_POST['note']);

        $amount_transaction   = str_replace(',','',$amount_transaction);
        $buy_price   = str_replace(',','',$buy_price);
        $sell_price   = str_replace(',','',$sell_price);



        //  this query use for validation 
        $is_exsit = $db->query("SELECT id FROM currency_rate WHERE  currency_from_id = '$currency_from_id' AND currency_to_id  = '$currency_to_id' AND `date` = '$date'   AND deleted = '0' LIMIT 1 ");


        if($is_exsit->rowCount() > 0 ){
            $row_id = $is_exsit->fetch()['id'];

            $exc = edit(
                'currency_rate',
                [
                    'currency_from_id'      => $currency_from_id,   
                    'currency_to_id'        => $currency_to_id,   
                    'amount_transaction'    => $amount_transaction,   
                    'buy_price'             => $buy_price,   
                    'sell_price'            => $sell_price,   
                    'date'                  => $date,   
                    'note'                  => $note,   
                    'user_id'               => $user_id,   
                ],
                $row_id
            );

        }else {

            $exc = insert(
                'currency_rate',
                [
                    'currency_from_id'      => $currency_from_id,   
                    'currency_to_id'        => $currency_to_id,   
                    'amount_transaction'    => $amount_transaction,   
                    'buy_price'             => $buy_price,   
                    'sell_price'            => $sell_price,   
                    'date'                  => $date,   
                    'note'                  => $note,   
                    'user_id'               => $user_id,   
                ]
            );
        }

        if($exc){
            $db->commit();
            header("location: currency_rate.php?saved");
            exit();
        }else {
            $db->rollback();
            header("location: currency_rate.php?error");
            exit();
        }        
        
    }


?>