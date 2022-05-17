<?php


header('Content-type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');
mb_regex_encoding('UTF-8');

error_reporting(1);
session_start();
ob_start();

ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');
ini_set('max_file_uploads', '50');

ini_set('display_errors', true);
// ini_set('error_log', 'error.txt');
date_default_timezone_set('Asia/Kabul');

//sarafi_test
$keyword = "main_sarafi";

try {

    $DB_LOCALHOST   = 'localhost';
    $DB_USER        = 'root';
    $DB_PASSWORD    = '';
    $DB_DB          = 'main_sarafi';

    $db = new PDO("mysql:host=$DB_LOCALHOST;dbname=$DB_DB;charset=utf8", $DB_USER, $DB_PASSWORD);

} catch (PDOEXCEPTION $exception) {
    die("<P style='background:#F44336;color:white;padding;padding:20px;font-size:20px;border-radius:10px 0px 10px 0px'><b>!با مسوول سیستم دیتابیس تماس بگیرید </b></P>");
    exit();
}


require_once("public_function.php");
require_once("public_array.php");
require_once("helper.php");

?>