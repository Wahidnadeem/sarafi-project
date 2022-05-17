<?php

session_start();
ob_clean();

unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['user_photo']);
unset($_SESSION['auth']);

session_destroy();
header("location: ../login/");
exit();

?>