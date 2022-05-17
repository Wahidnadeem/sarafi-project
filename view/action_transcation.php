<?php

    require_once "_config.php";
    
    if( isset($_POST['insert']) ){

        // this is use for trancation 
        $db->beginTransaction();
        $exc = true;
        
        $account_id  = VD($_POST['account_id']);
        $currency_id = VD($_POST['currency_id']);
        $amount      = VD($_POST['amount']);
        $date        = VD($_POST['date']);
        $note        = VD($_POST['note']);
        $type        = VD($_POST['type']);
        $by_person  = VD($_POST['by_person']);

        $amount = str_replace(',','',$amount);
        $amount = $amount * 1;
 

        // INSERT AND UPDATE CUSTOMER BLANCE CASH IN
        $is_exest_currecny_row  = $db->query("SELECT * FROM `account_balance` WHERE `account_id` = '$account_id' AND `currency_id` = '$currency_id' AND deleted = 0 LIMIT 1 ");

        if ($is_exest_currecny_row->rowCount() > 0 ) {
            

            $account_blance_row = $is_exest_currecny_row->fetch();
            $amount_update = ($type == "credit") ? $account_blance_row['amount'] + $amount : $account_blance_row['amount'] - $amount;
            
            $update = edit('account_balance',[ 'amount' => $amount_update ],$account_blance_row['id'] );
            
            if(!$update){
                $db->rollback();
                header("location:transcation.php?error");
                exit();
            }
            
            if($type == "credit"){
                $exc = increase_currency_amount('master_balance',$currency_id,$amount);
            }else if($type == "debt") {
                $exc = decrease_currency_amount('master_balance',$currency_id,$amount);
            }

            if(!$exc){
                $db->rollback();
                header("location:transcation.php?error");
                exit();
            }
            
        }else {

            

            $amount  = ( $type == "credit" ) ? $amount * 1 : $amount * -1 ;
            
            $insert = insert(
                'account_balance',
                [
                    'account_id'             => $account_id,
                    'currency_id'            => $currency_id,
                    'amount'                 => $amount,   
                ]
            );

            
            if(!$insert){
                $db->rollback();
                header("location:transcation.php?error");
                exit();
            } 
            
            $amount  = ( $amount > 0 ) ? $amount : $amount * -1 ;
        
            if($type == "credit"){
                $exc = increase_currency_amount('master_balance',$currency_id,$amount);
            }else if($type == "debt") {
                $exc = decrease_currency_amount('master_balance',$currency_id,$amount);
            }

            if(!$exc){
                $db->rollback();
                header("location:transcation.php?error");
                exit();
            }

        }

        
        
        $data = [
            'account_id'            => $account_id,
            'currency_id'            => $currency_id,
            'amount'                 => $amount,
            'date'                   => $date,
            'note'                   => $note,
            'type'                   => $type,
            'by_person'             => $by_person,
            'user_id'                => $user_id,
            'account_type'            => 'public',
        ];

        $insert = insert('account_transaction',$data);

        if(!$insert){
            $db->rollback();
            header("location:transcation.php?error");
            exit();
        }


        $last_id  = $db->lastInsertId();

        $account_type = $db->query("SELECT `type` , `account_type` FROM accounts  WHERE id = '$account_id' LIMIT 1 ");
        if($account_type->rowCount() > 0 ){


            $account_type_row = $account_type->fetch();
            if($account_type_row['type'] == "special"){


                
                $account_type = $account_type_row['account_type'];
                $final_amount = cal_intent($account_type , $amount, $currency_id );
                

                $data = [
                    'type'          => $account_type,
                    'amount'        => $amount,
                    'date'          => $date,
                    'currency_id'   => $currency_id,
                    'page'          => 'transcation',
                    'user_id'       => $user_id,
                    'page_id'       => $last_id,
                    'note'          => $note,
                    'final_amount'  => $final_amount,
                ];

                $insert = insert('intent',$data);

                if(!$insert){
                    $db->rollback();
                    header("location:transcation.php?error");
                    exit();
                }

                $edit = edit('account_transaction',['account_type' => 'special'],$last_id);

                if(!$edit){
                    $db->rollback();
                    header("location:transcation.php?error");
                    exit();
                }

            }
        }

        $db->commit();
        header("location:transcation.php?saved");
        exit();
    }

// DELETE QUERY
    
    if(isset($_GET['delete']) && isset($_GET['id']) ){

        // this is use for trancation 
        $db->beginTransaction();
        $exc = true;

        $id      = base64_decode($_GET['id']);

        $acount_transaction_row = select_one('account_transaction',$id);
        
        $account_id  = $acount_transaction_row['account_id'];
        $currency_id = $acount_transaction_row['currency_id'];
        $amount      = $acount_transaction_row['amount'];
        $type        = $acount_transaction_row['type'];

        if($type == "credit"){
            $exc = decrease_currency_amount('master_balance',$currency_id,$amount);

            if(!$exc){
                $db->rollback();
                header("location:transcation.php?error");
                exit();
            }

            $account_blase_amount = $db->query("SELECT `amount` FROM `account_balance` WHERE `currency_id` = '$currency_id' AND `account_id` = '$account_id' AND deleted = 0 LIMIT 1")->fetch()['amount'] - $amount;
            $update_account_blance = $db->query("UPDATE `account_balance` SET `amount` = '$account_blase_amount' WHERE `currency_id` = '$currency_id' AND `account_id` = '$account_id' AND deleted = 0 LIMIT 1"); 

            if(!$update_account_blance){
                $db->rollback();
                header("location:transcation.php?error");
                exit();
            }
        }else if($type = "debt") {
            $exc = increase_currency_amount('master_balance',$currency_id,$amount);

            if(!$exc){
                $db->rollback();
                header("location:transcation.php?error");
                exit();
            }

            $account_blase_amount = $db->query("SELECT `amount` FROM `account_balance` WHERE `currency_id` = '$currency_id' AND `account_id` = '$account_id' AND deleted = 0 LIMIT 1")->fetch()['amount'] + $amount;
            $update_account_blance = $db->query("UPDATE `account_balance` SET `amount` = '$account_blase_amount' WHERE `currency_id` = '$currency_id' AND `account_id` = '$account_id' AND deleted = 0 LIMIT 1"); 

            if(!$update_account_blance){
                $db->rollback();
                header("location:transcation.php?error");
                exit();
            }
        }


       $deleted = edit('account_transaction',['deleted' => 1],$id);

        $is_exit = $db->query("SELECT * FROM intent WHERE page_id  = $id AND `page` = 'transcation' LIMIT 1  ");
        if($is_exit->rowCount() > 0) {

            $is_exit_row = $is_exit->fetch();
            
            $current_amount = get_column_value('master_balance',10,'amount');
            if ( $is_exit_row['type'] == 'debt'){
                $edit = edit('master_balance',['amount' =>  ($current_amount + $is_exit_row['final_amount'])], 10);
            }else if ( $is_exit_row['type'] == 'credit' ){
                $edit = edit('master_balance',['amount' =>  ($current_amount - $is_exit_row['final_amount'])], 10);
            }

            $deleted = $db->query(" UPDATE `intent` SET deleted = 1 WHERE page_id  = $id AND `page` = 'transcation' LIMIT 1 ");

            if(!$deleted){
                $db->rollback();
                header("location:transcation.php?error");
                exit();
            }
        }

       
        if($deleted){
            $db->commit();
            header("location: transcation.php?deleted");
            exit();
        }else{
            $db->rollback();
            header("location:transcation.php?error");
            exit();
        }
    }

    // EDIT QUERY

        if(isset($_POST['edit']) AND isset($_POST['row_id'])) {


            // this is use for trancation 
            $db->beginTransaction();
            $exc = true;

            $id                         = base64_decode($_POST['row_id']);
            $account_transaction_row   = select_one('account_transaction',$id);
            

            $account_id     = $account_transaction_row['account_id'];
            $currency_id    = $account_transaction_row['currency_id'];
            $amount         = $account_transaction_row['amount'];
            $type           = $account_transaction_row['type'];

            if($type == "credit"){
                $exc = decrease_currency_amount('master_balance',$currency_id,$amount);

                if(!$exc){
                    $db->rollback();
                    header("location:transcation.php?error");
                    exit();
                }

                $account_blanse_amount = $db->query("SELECT `amount` FROM `account_balance` WHERE `currency_id` = '$currency_id' AND `account_id` = '$account_id' AND deleted = 0 LIMIT 1")->fetch()['amount'] - $amount;
                $update_account_blance = $db->query("UPDATE `account_balance` SET `amount` = '$account_blanse_amount' WHERE `currency_id` = '$currency_id' AND `account_id` = '$account_id' AND deleted = 0 LIMIT 1"); 

                if(!$update_account_blance){
                    $db->rollback();
                    header("location:transcation.php?error");
                    exit();
                }
            }else if($type = "debt") {
                $exc = increase_currency_amount('master_balance',$currency_id,$amount);

                if(!$exc){
                    $db->rollback();
                    header("location:transcation.php?error");
                    exit();
                }

                $account_blanse_amount = $db->query("SELECT `amount` FROM `account_balance` WHERE `currency_id` = '$currency_id' AND `account_id` = '$account_id' AND deleted = 0 LIMIT 1")->fetch()['amount'] + $amount;
                $update_account_blance = $db->query("UPDATE `account_balance` SET `amount` = '$account_blanse_amount' WHERE `currency_id` = '$currency_id' AND `account_id` = '$account_id' AND deleted = 0 LIMIT 1"); 

                if(!$update_account_blance){
                    $db->rollback();
                    header("location:transcation.php?error");
                    exit();
                }
            }

                        
            $account_id         = VD($_POST['account_id']);
            $currency_id        = VD($_POST['currency_id']);
            $amount             = VD($_POST['amount']);
            $note               = VD($_POST['note']);
            $date               = VD($_POST['date']);
            $type               = VD($_POST['type']);
            $by_person          = VD($_POST['by_person']);

            $amount = str_replace(',','',$amount);
                        
            $edit = edit(
                'account_transaction',
                [
                    'account_id'             => $account_id,
                    'currency_id'            => $currency_id,
                    'amount'                 => $amount,
                    'date'                   => $date,
                    'note'                   => $note,
                    'type'                   => $type,
                    'by_person'             => $by_person,
                    'account_type'             => 'public',
                ],
                $id
            );

            if(!$edit){
                $db->rollback();
                header("location:transcation.php?error");
                exit();
            }

            // INSERT AND UPDATE CUSTOMER BLANCE CASH IN
        $is_exest_currecny_row  = $db->query("SELECT * FROM `account_balance` WHERE `account_id` = '$account_id' AND `currency_id` = '$currency_id' AND deleted = 0 LIMIT 1 ");

        if ($is_exest_currecny_row->rowCount() > 0 ) {
            

            $customer_blance_row = $is_exest_currecny_row->fetch();
            $amount_update = ($type == "credit") ? $customer_blance_row['amount'] + $amount : $customer_blance_row['amount'] - $amount;
            
            $update = edit('account_balance',[ 'amount' => $amount_update ],$customer_blance_row['id'] );
            
            if(!$update){
                $db->rollback();
                header("location:transcation.php?error");
                exit();
            }
            
            if($type == "credit"){
                $exc = increase_currency_amount('master_balance',$currency_id,$amount);
            }else if($type == "debt") {
                $exc = decrease_currency_amount('master_balance',$currency_id,$amount);
            }

            if(!$exc){
                $db->rollback();
                header("location:transcation.php?error");
                exit();
            }
            
        }else {
            
            $insert = insert(
                'account_balance',
                [
                    'account_id'            => $account_id,
                    'currency_id'            => $currency_id,
                    'amount'                 => $amount,   
                ]
            );

            if(!$insert){
                $db->rollback();
                header("location:transcation.php?error");
                exit();
            } 
            
            if($type == "credit"){
                $exc = increase_currency_amount('master_balance',$currency_id,$amount);
            }else if($type == "debt") {
                $exc = decrease_currency_amount('master_balance',$currency_id,$amount);
            }

            if(!$exc){
                $db->rollback();
                header("location:transcation.php?error");
                exit();
            }
        }

        // this code use for calculate intent
        $account_type = $db->query("SELECT `type` , `account_type` FROM accounts  WHERE id = '$account_id' LIMIT 1 ");
        
        if($account_type->rowCount() > 0 ){
            $account_type_row = $account_type->fetch();
            if($account_type_row['type'] == "special"){

                $is_exit = $db->query("SELECT * FROM intent WHERE page_id  = $id AND `page` = 'transcation' LIMIT 1  ");
                
                if($is_exit->rowCount() > 0) {

                    $is_exit_row = $is_exit->fetch();
                    
                    $current_amount = get_column_value('master_balance',10,'amount');
                    if ( $is_exit_row['type'] == 'debt'){
                        $edit = edit('master_balance',['amount' =>  ($current_amount + $is_exit_row['final_amount'])], 10);
                    }else if ( $is_exit_row['type'] == 'credit' ){
                        $edit = edit('master_balance',['amount' =>  ($current_amount - $is_exit_row['final_amount'])], 10);
                    }

                    if(!$edit){
                        $db->rollback();
                        header("location:transcation.php?error");
                        exit();
                    }

                    $amount = VD($_POST['amount']);
                    $amount = str_replace(',','',$amount);

                    $final_amount = cal_intent($is_exit_row['type'] , $amount , VD($_POST['currency_id']) );
                    
                    $data = [
                        'amount'        => $amount,
                        'date'          => $date,
                        'currency_id'   => $currency_id,
                        'note'          => $note,
                        'final_amount'  => $final_amount,
                    ];

                    $insert = edit('intent',$data,$is_exit_row['id']);

                    if(!$insert){
                        $db->rollback();
                        header("location:transcation.php?error");
                        exit();
                    }

                    $edit = edit('account_transaction',['account_type' => 'special'],$id);

                    if(!$edit){
                        $db->rollback();
                        header("location:transcation.php?error");
                        exit();
                    }

                }
            }

        }



                     
        // end update msater blance 
        $db->commit();
        header("location: transcation.php?edit");
        exit();
            
    }

?>