<?php

//  this function use for valid data
function VD($data){

    if(empty($data)){
        $data = '';
    }
    $data   =   trim($data);
    $data   =   stripslashes($data);
    $data   =   htmlspecialchars($data);
    $data   =   strip_tags($data);

    return $data;
}

function insert( $table , $columns , $error = false ){

    global $db;

    $columns_name 	= '';
    $values  		= '';

    foreach ($columns as $key => $value) {
        $columns_name .= '`'.$key.'`,';
        ($error) ? $values .= "'".$value."'," : $values .= ":".$key.",";
    }

    $columns_name = rtrim($columns_name,',');
    $values = rtrim($values,',');


    $sql = "INSERT INTO $table ($columns_name) VALUES ($values);";

    if($error){
        return $sql;
    }


    $stmt 	=  $db->prepare($sql);
    $result =  $stmt->execute($columns);

    if($result){
        return true;
    }else {
        return false;
    }
}


function edit($table , $columns , $rowId ,  $error = false){

    global $db;
    $temp_query = '';

    foreach ($columns as $key => $value) {
        ($error) ? $temp_query .= "`".$key."`='".$value."'," : $temp_query .= "`".$key."`= :".$key.",";
    }

    $temp_query = rtrim($temp_query,',');

    $sql = "UPDATE `$table` SET  $temp_query  WHERE id = '$rowId' ";

    if($error){
        return  $sql;
    }


    $stmt 	=  $db->prepare($sql);
    $result =  $stmt->execute($columns);

    if($result){
        return true;
    }else {
        return false;
    }

}



function delete ($table , $rowId , $error = false ){

    global $db;

    $sql = "DELETE FROM `$table` WHERE  `id` = '$rowId' LIMIT 1  ";

    if($error){
        return $sql;
    }

    $stmt 	=  $db->prepare($sql);
    $result =  $stmt->execute();

    if($result){
        return true;
    }else {
        return false;
    }
}



function last_id ($table){
    global $db;
    $sql = "SELECT `id` FROM `$table` ORDER BY id DESC LIMIT 1  ";
    $number = $db->query($sql);
    $number = $number->fetch()['id'];
    return ($number > 0 ) ? $number + 0 : 0 ;
}


function save_file($dir_name,$last_id, $file_name_v = 'photo'){

    if(!empty($_FILES[$file_name_v]['name'])){

        if(!file_exists("../upload/$dir_name/".$last_id))
            mkdir("../upload/$dir_name/".$last_id);

        $ext = substr($_FILES[$file_name_v]['name'], strripos($_FILES[$file_name_v]['name'], '.'));
        $file_name = $last_id.time().$ext;
        $destination = "../upload/$dir_name/$last_id/$file_name";
        if(move_uploaded_file($_FILES[$file_name_v]['tmp_name'],$destination)){
            $img = $destination;
        }else {
            $img="../upload/$dir_name/default.png";
        }

    }else{
        $img="../upload/$dir_name/default.png";
    }

    return $img;
}


function delete_file($path){
    if(file_exists($path)){
        if(unlink($path)){
            return true;
        }else {
            return false;
        }
    }else {
        return  "nothing";
    }
}


function replace_file($dir_name, $last_id , $path ,  $file_name_v = 'photo'){
    delete_file($path);
    return save_file($dir_name,$last_id,$file_name_v);
}


function gregorian_to_jalali($gy,$gm,$gd,$mod=''){

    $g_d_m=array(0,31,59,90,120,151,181,212,243,273,304,334);

    if($gy>1600){
        $jy=979;
        $gy-=1600;
    }else{
        $jy=0;
        $gy-=621;
    }

    $gy2=($gm>2)?($gy+1):$gy;
    $days=(365*$gy) +((int)(($gy2+3)/4)) -((int)(($gy2+99)/100)) +((int)(($gy2+399)/400)) -80 +$gd +$g_d_m[$gm-1];
    $jy+=33*((int)($days/12053));
    $days%=12053;
    $jy+=4*((int)($days/1461));
    $days%=1461;

    if($days > 365){
        $jy+=(int)(($days-1)/365);
        $days=($days-1)%365;
    }

    $jm=($days < 186)?1+(int)($days/31):7+(int)(($days-186)/30);
    $jd=1+(($days < 186)?($days%31):(($days-186)%30));
    return($mod=='')?array($jy,$jm,$jd):$jy.$mod.$jm.$mod.$jd;
}

function gregorian_to_jalali_date($date,$exp_type){

    $year  = explode($exp_type,$date)[0];
    $month = explode($exp_type,$date)[1];
    $day   = explode($exp_type,$date)[2];

    $g_array_date = gregorian_to_jalali($year,$month,$day);

    $f_year   = $g_array_date[0];
    $f_month  = $g_array_date[1];
    $f_day    = $g_array_date[2];

    if(strlen($f_month)<2){

        $f_month = "0".$f_month;
    }
    if(strlen($f_day)<2){

        $f_day = "0".$f_day;
    }
    return $f_year.$exp_type.$f_month.$exp_type.$f_day;
}

// ============================================== THIS FUNCTION USE FROM SHOW PERSION DATA IN TABLE ===============
function persionData($date , $sine = "-"){
    if(DateTime::createFromFormat('Y-m-d' , $date )){
        list($y,$m,$d) = explode($sine, $date);
        $monthes =  array( "" , "حمل" ,"ثور","جوزا","سرطان","اسد","سنبله","میزان","عقرب","قوس","جدی","دلو","حوت" );
        $return_data  = $y."،".$monthes[(int)$m]." ".(int)$d;
        return $return_data;
    }else{
        return $date;
    }
}


//clean data
function clean_data($date,$exp_type = '-'){

    $f_year   = explode($exp_type,$date)[0];
    $f_month  = explode($exp_type,$date)[1];
    $f_day    = explode($exp_type,$date)[2];

    if(strlen($f_month)<2){
        $f_month = "0".$f_month;
    }

    if(strlen($f_day)<2){
        $f_day = "0".$f_day;
    }

    return $f_year.$exp_type.$f_month.$exp_type.$f_day;
}



function getWeekDay($day = 0){

    $persionDay = [ 'Today' => 'امروز' , 'Saturday' => 'شنبه' , 'Sunday' => 'یک شنبه '  , 'Monday' => 'دوشنبه'  , 'Tuesday' => 'سه شنبه' , 'Wednesday' => 'چهارشنبه'  , 'Thursday' => 'پنج شنبه'  , 'Friday' => 'جمعه' ];

    if($day == 0 )
        return $persionDay['Today'];

    $date = date_create(date('Y-m-d'));

    date_add($date,date_interval_create_from_date_string(" $day days"));
    $date =  date_format($date,"Y-m-d");

    //Convert the date string into a unix timestamp.
    $unixTimestamp = strtotime($date);

    //Get the day of the week using PHP's date function.
    $dayOfWeek = date("l", $unixTimestamp);


    //Print out the day that our date fell on.
    return $persionDay[$dayOfWeek];
}


function M_to_P($date,$exp_type = '-'){

    $year  = explode($exp_type,$date)[0];
    $month = explode($exp_type,$date)[1];
    $day   = explode($exp_type,$date)[2];

    $g_array_date = gregorian_to_jalali($year,$month,$day);

    $f_year   = $g_array_date[0];
    $f_month  = $g_array_date[1];
    $f_day    = $g_array_date[2];

    if(strlen($f_month)<2){

        $f_month = "0".$f_month;
    }
    if(strlen($f_day)<2){

        $f_day = "0".$f_day;
    }
    return $f_year.$exp_type.$f_month.$exp_type.$f_day;
}


// this is function user for get data one patient
function getPatientRow($patient_id){

    global $db;

    $patient_row = $db->prepare("SELECT * FROM patients WHERE id = :id LIMIT 1");
    $patient_row->execute(['id' => $patient_id ]);
    if($patient_row->rowCount() > 0)
        return $patient_row->fetch();
    else
        return "noting";
}


// get vision_type when get in id
function getVisionType($key){
    global $db;
    $value = $db->query("SELECT * FROM vision_types WHERE id = '$key' LIMIT 1 ");
    if($value->rowCount() == 0 ){
        return  'noting';
    }
    return $value->fetch()['name'];
}

/**
 * @param mixed
 * this is a public method to do selectAll action
 */
function selectAll($table , $column = '*' ,  $condition = ''){

    global $db;
    $con = " WHERE deleted = 0 ";
    if(!empty($condition)){
        $con .= "  $condition ";
    }

    $stmt 	=  $db->prepare(" SELECT $column FROM `$table` $con ORDER BY id DESC ");
    $result =  $stmt->execute();
    if($result){
        return $stmt;
    }else {
        var_dump($stmt);
        exit();
    }

}

/**
 * @param integer $id
 * this is a public method to do select one action
 */
function select_one($table,$id)
{
    global $db;

    $stmt = $db->prepare(" SELECT * FROM `$table` WHERE  id = $id ORDER BY id DESC ");
    $result = $stmt->execute();

    if ($result) {
        return ($stmt->fetch());
    } else {
        var_dump($stmt);
        exit();
    }
}


/**
 * @param integer $id
 * this is a public method to do select one action
 */
function getDataTypeSick( $type , $column = '*' ){
    
    global $db;

    $stmt = $db->prepare(" SELECT $column FROM `type_sick_atm` WHERE  `deleted` = '0' AND type = '$type' ORDER BY id DESC ");
    $result = $stmt->execute();

    if ($result) {
        return $stmt;
    } else {
        var_dump($stmt);
        exit();
    }

}


// this function use for get value vision it is used in vision and vision_search and dr_opd and more
function getVal($key){

    if(empty($key))
        return  '';

    global $db;

    $vlaue = $db->query("SELECT * FROM vision_types WHERE id = '$key' LIMIT 1 ");
    return $vlaue->fetch()['name'];
}



      function getPendingStatusNumber($db){
            $number = $db->query("SELECT COUNT(id) AS number FROM opd_dilatation WHERE is_done = 'pending'  ")->fetch()['number'] + 0;
            return ($number > 0 ) ? $number : 0; 
        }


        function select_all( $table , $condition = '' , $order = 'ASC' ){
            global $db;
            return  $db->query("SELECT * FROM $table WHERE deleted = '0' $condition ORDER BY id $order ");
        }


?>