<?php

require_once ("_config.php");

// add query
if(isset($_POST['insert'])){

    $data = [

        'full_name'          => VD($_POST['full_name']),
        'father_name'        => VD($_POST['father_name']),
        'phone'              => VD($_POST['phone']),
        'username'           => VD($_POST['username']),
        'password'           => VD($_POST['password']),
        'note'               => VD($_POST['note']),
        'date'               => VD($_POST['date']),
        'user_id'            => $user_id,
        
    ];


    $insert = insert('users',$data);
    if($insert){
        header("location: add_user.php?saved");
        exit();
    }else{
        header("location: add_user.php?error");
        exit();
    }

}

// delete query

if(isset($_GET['delete']) && isset($_GET['id']) ){

    $id      = base64_decode($_GET['id']);

    if($user_id == $id){
        header("location:add_user.php?users");
        exit();
    }
    
   $deleted = edit('users',['deleted' => 1],$id);
   

    if($deleted){
        header("location: add_user.php?deleted");
        exit();
    }else{
        header("location: add_user.php?error");
        exit();
    }
}

// edit query
if (isset($_POST['edit']) AND isset($_POST['row_id'])) {

    $id         = base64_decode($_POST['row_id']);

    $edit_data = [

        'full_name'          => VD($_POST['full_name']),
        'father_name'        => VD($_POST['father_name']),
        'phone'              => VD($_POST['phone']),
        'username'           => VD($_POST['username']),
        'password'           => VD($_POST['password']),
        'note'               => VD($_POST['note']),
        'date'               => VD($_POST['date']),
        'user_id'            => $user_id,
        
    ];

    $query = edit('users',$edit_data,$id);
    if ($query) {
        header("location: add_user.php?edit");
        exit();
    }else{
        header("location: add_user.php?error");
        exit();
    }
}
?>
