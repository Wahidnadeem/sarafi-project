<?php

require_once("../lib/db.php");

$username = VD($_POST['username']);
$password = VD($_POST['password']);

if(!empty($username) && !empty($password) ){

    $is_user = $db->prepare("SELECT * FROM users WHERE `username` = :username and `password` = :password and deleted = 0 limit 1");
    $is_user->execute(['username' => $username , 'password' => $password]);

    if($is_user->rowCount() > 0 ){
        $row                        = $is_user->fetch();

        $_SESSION['user_id']        = $row['id'];
        $_SESSION['user_name']      = $row['full_name'];
        $_SESSION['user_photo']     = $row['photo'];
        // $_SESSION['user_type']      = $row['type'];
        $_SESSION['auth']           = "b58ac01c6c7a9fb5ffd1a5d9c7d68955-NovaVTeam";
        header("location:     ../view/index.php");
        exit();
    }else {
        header("location: index.php?notuser");
        exit();
    }
    
}else {
    header("location: index.php?empty");
    exit();
}

header("location: index.php?empty");
exit();


?>