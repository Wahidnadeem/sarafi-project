<?php

require_once ("_config.php");

// add query
if(isset($_POST['insert'])){


    // genrate code account
    $value = $db->query("SELECT account_code FROM `accounts` ORDER BY id DESC LIMIT 1")->fetch();
    $account_code = (!empty($value['account_code'])) ?  $value['account_code']+1 : 1;
    // end  
    $page = VD($_POST['page']);

    $data = [

        'first_name'         => VD($_POST['first_name']),
        'last_name'          => VD($_POST['last_name']),
        'account_code'       => $account_code,
        'fname'              => VD($_POST['fname']),
        'phone'              => VD($_POST['phone']),
        'type'               => VD($_POST['type']),
        'address'            => VD($_POST['address']),
        'note'               => VD($_POST['note']),
        'date'               => VD($_POST['date']),
        'user_id'            => $user_id,
        'account_type'       => VD($_POST['account_type']),
    ];


    $insert = insert('accounts',$data);
    if($insert){
        header("location: $page.php?saved");
        exit();
    }else{
        header("location: $page.php?error");
        exit();
    }

}

// delete query

if(isset($_GET['delete']) && isset($_GET['id']) ){

    $id      = base64_decode($_GET['id']);
    $page    = VD($_GET['pagename']);

    $if_exist = $db->query("SELECT * FROM `account_balance` WHERE `deleted` = '0' AND `account_id` = '$id' ");

    if($if_exist->rowCount() > 0){

        foreach ($if_exist as $key => $value) {
            if($value['amount'] > 0){
                header("location:add_account.php?has_account");
                exit();          
            }
        }
    }

   $deleted = edit('accounts',['deleted' => 1],$id);
   

    if($deleted){
        header("location: $page.php?deleted");
        exit();
    }else{
        header("location: $page.php?error");
        exit();
    }
}

// edit query
if (isset($_POST['edit']) AND isset($_POST['row_id'])) {

    $id         = base64_decode($_POST['row_id']);
    $page       = VD($_POST['page']);

    $edit_data = [

        'first_name'         => VD($_POST['first_name']),
        'last_name'          => VD($_POST['last_name']),
        'fname'              => VD($_POST['fname']),
        'phone'              => VD($_POST['phone']),
        'account_type'       => VD($_POST['account_type']),
        'address'            => VD($_POST['address']),
        'note'               => VD($_POST['note']),
        'date'               => VD($_POST['date']),
        'user_id'            => $user_id,

    ];

    $query = edit('accounts',$edit_data,$id);
    if ($query) {
        header("location: $page.php?edit");
        exit();
    }else{
        header("location: $page.php?error");
        exit();
    }
}
?>
