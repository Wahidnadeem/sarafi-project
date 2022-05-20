<?php 
require_once("_config.php");

   if(!isset($_GET['id'])){
        header("location: transcation.php?error");
        exit(); 
    }

   $account_id  = base64_decode($_GET['id']);

$condition = '';

if(isset($_GET['search'])){

 
 if(!empty($_GET['search_type_buy']) OR !empty($_GET['search_type_sell'])){
     @$search_type_buy  = VD($_GET['search_type_buy']);
     @$search_type_sell = VD($_GET['search_type_sell']);
     $condition  .= " AND (type = '$search_type_buy' OR type = '$search_type_sell') ";
 }

 if(!empty($_GET['search_currecy'])){
    $search_currecy = VD($_GET['search_currecy']);
    $condition .= " AND  currency_id = '$search_currecy' ";
 }

 if(!empty($_GET['start_date']) && !empty($_GET['end_date']) ){
    $start_date = VD($_GET['start_date']);
    $end_date   = VD($_GET['end_date']);

    $condition .= " AND `date` BETWEEN  '$start_date' AND '$end_date' ";
 }
}

$view_data = $db->query("SELECT * FROM `account_transaction` WHERE `account_id` = '$account_id' AND deleted = '0' $condition ORDER BY id DESC LIMIT $to OFFSET $from ");

$list_data  = $db->query("SELECT count(id) as record FROM account_transaction WHERE `account_id` = '$account_id' AND deleted = 0 $condition ")->fetch();
$record     = $list_data['record'];


$account_name = $db->query("SELECT * FROM accounts WHERE `deleted` = '0' AND `id` = '$account_id' LIMIT 1")->fetch();

?>


<!DOCTYPE html>
<html lang="pe" dir="rtl">

<head>
   <?php 
      $title =' حساب : '.$account_name['first_name'] .' '. $account_name['last_name'].'';
      require_once "_head.php" ;
      ?>

   <style type="text/css">
      @media print {

         .print-none {
            display: none !important;
         }

      }

      .right {
         text-align: ;
      }
   </style>
</head>
<body>
   <div class="container">
   <div class="col-xl-12 mt-4 print-none" >
      <div class="mshadow bg-white p-2">
        <div class="row mt-2">
         <h5 class="text-start lalezar text-muted mb-3 ms-3">جستجو</h5>
         <div class="col-md-12">
          <form role="form" class="currency_validate trade-form row g-3" action="short_account_report.php" method="GET" enctype="multipart/form-data">
            <input type="hidden" name="search" value="1">
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <!-- SEARCH BOX -->
            <div class="row">
               <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12 col-xl-12">
                  <!-- table  -->
                  <table>
                     <br>
                     <tr>
                        <th class="ps-2">  نوعیت  </th>
                        <th class="ps-2"> واحد پول</th>
                        <th class="ps-2"> از تاریخ</th>
                        <th class="ps-2"> الی تاریخ</th>
                     </tr>

                     <tr>


                        <td >
                          <div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="credit" name="search_type_buy" id="flexCheckDefault">
                          <label class="form-check-label" for="flexCheckDefault">
                            رسید
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="debt" name ="search_type_sell" id="flexCheckChecked">
                          <label class="form-check-label" for="flexCheckChecked">
                            برد
                          </label>
                        </div>
                      </div>
                        </td>

                        <td class="ps-2">
                        <select class="form-control w-13" name="search_currecy">
                           <option  value=""> پول را انتخاب کنید</option>
                           <?php
                           foreach (get_currency_options() as  $value) {
                           echo '<option value="'.$value['id'].'"> '.$value['name'].' </option>';
                        }
                        ?>
                     </select>
                        </td>

                        <td class="ps-2">
                           <input type="text" id="start_date" onload ="startDateEndDate(this.value , end_date.value)" autocomplete="off" name="start_date" class="form-control date" >
                        </td>

                        <td class="ps-2">
                           <input type="text" id="end_date" autocomplete="off" name="end_date" class="form-control date" >
                        </td>

                        <td class="ps-2">
                           <button  type="submit" name="search" class="pointer btn btn-secondary w-13" ><i class="fa fa-search"></i> جستجو </button>
                        </td>
                        <td class="ps-2">
                          <a href="transcation.php" class="pointer btn btn-danger w-13" ><i class="fas fa-undo-alt"></i> برگشت 
                          </a>
                        </td>
                     </tr>
                  </table>
                   
                  <!-- /end table -->

               </div> <!-- COL-LG-12 -->
            </div> <!-- ROW -->
          </form>
         </div>
         </div>
      </div>
   </div>
      <section class="row">


         <div class="col-xl-12 mt-4">
            <div style="text-align: center;">
               <img src="./assist/img/img2.png" alt="">
            </div>
         </div>
         &nbsp;&nbsp; 
         <button class="pointer btn btn-info w-13 print-none" onclick="window.print();"
            style="color: #fff; position: relative; top:-10px"> <i class="fa fa-print"></i> Print
         </button>
         &nbsp;&nbsp;
         <a href="../tcpdf/index.php?account_id=<?php echo $_GET['id'];?>&query=<?php echo $condition ?>" class="pointer btn btn-warning w-13 print-none"  style="color: #fff; position: relative; top:-10px"> <i class="fa fa-file"></i> PDF
         </a>
         &nbsp;&nbsp;
         <div class="card">

            <div class="card-body">
               <div class="row mt-2">
                  <h5 class="text-start lalezar text-muted mb-3 ms-3">معاملات و انتقالات : &nbsp;
                     <span
                        style="font-size: 22px; color: lightseagreen;"> 
                     <?php 
                        echo $account_name['first_name'] .' '. $account_name['last_name'] .' - '.$account_name['account_code'];
                     ?>
                     </span>
                     <span style="font-size: 22px; color: lightseagreen;float: left;"> &nbsp;&nbsp;
                     </span>
                  </h5>
                  <table id="datatable2" class="table table-striped dt-responsive nowrap w-100">
                     <thead>
                        <tr>
                           <th>شماره</th>
                           <th>واحد پول</th>
                           <th>مقدار</th>
                           <th>نوعیت</th>
                           <th> توسط</th>
                           <th>تاریخ</th>
                           <th>توضیحات</th>
                        </tr>
                     </thead>
                     <tbody>

                        <?php
                           if( $view_data->rowCount() > 0  ) {
                              foreach ($view_data as $rows) {


                                 $account_row = select_one('accounts',$rows['account_id']);
                                 $currency_row = select_one('currencies',$rows['currency_id']);

                                 if ($rows['type'] == "credit") {
                                    $type_status = '<td class = "recive_money">رسید</td>';
                                 }elseif($rows['type'] == "debt"){
                                    $type_status = '<td class = "send_money">برد</td>';
                                 }

                                 echo '
                                 <tr>
                                    <td>' . ($count++) . ' </td>
                                    <td>' . $currency_row['name'] . ' </td>
                                    <td><span class ="label label-info togg '.$CURRENCY_ICON[$rows['currency_id']].' CurNumDiv"> '.$rows['amount']. '</span> <span class="h6 mb-0 togg priv">****</span> </td>
                                       '.$type_status.'
                                    <td>' . $rows['by_person'] . ' </td>
                                    <td> '.$rows['date']. ' </td>
                                    <td> ' . $rows['note'] . ' </td>
                                 </tr>
                                 ';
                              }
                           }else {
                              echo '
                                  <tr>
                                     <td colspan="13" style="text-align: center !important">
                                           <img src="img/empty.png" width ="auto" height ="400">
                                           <br>
                                           <div class="pb-4 lalezar h3 text-muted">هیج اطلاعاتی برای نمایش وجود ندارد!</div>
                                     </td>
                                  </tr>
                                    <style>
                                    .table-striped>tbody>tr:nth-of-type(odd)>* {
                                       --bs-table-accent-bg: none !important;
                                   }
                                    </style>
                                  ';
                           }

                        ?>
                     </tbody>
                  </table>
                  <div class="d-flex justify-content-center mt-3">
                        <?php
                            $pagination->records($record);
                            $pagination->records_per_page($records_per_page);
                            if($record>50){
                               $pagination->render();
                            }
                        ?>
                  </div>
               </div>
               <br>
            </div>
         </div>
      </section>
      <section class="row mt-4">
         <div class="card">
            <div class="card-body">
               <div class="row mt-2">
                  <h5 class="text-start lalezar text-muted mb-3 ms-3"> جمله حساب  : &nbsp; <span
                        style="font-size: 22px; color: lightseagreen;"> <?php 
                        echo $account_name['first_name'] .' '. $account_name['last_name'] .' - '.$account_name['account_code'];
                     ?></span>

                     <span style="font-size: 22px; color: lightseagreen;float: left;"> <?php echo persionData($PDATE);?> </span>
                  </h5>
                  <table id="datatable" class="table table-striped dt-responsive nowrap w-100">
                     <thead>
                        <tr>
                           <th>شماره</th>
                           <th>واحد پول</th>
                           <th>رسید</th>
                           <th>برد</th>
                           <th>موجودی فعلی</th>
                        </tr>
                     </thead>
                     <tbody>
                      <?php

                        foreach ($MIAN_CURRENCIES as $key => $value) {

                          $credit = $db->query("SELECT SUM(amount) as amount FROM `account_transaction` WHERE deleted = 0 
                          AND `type` = 'credit' AND `account_id` = '$account_id' AND `currency_id` = $key $condition")->fetch()['amount'] + 0 ;

                          $debt = $db->query("SELECT SUM(amount) as amount FROM `account_transaction` WHERE deleted = 0 AND `type` = 'debt' AND `account_id` = '$account_id' AND `currency_id` = $key $condition ")->fetch()['amount'] + 0 ;
                                 
                                 $total_currecny_blase = $credit - $debt;
                                  if ( $total_currecny_blase < 0) {
                                   $master_blance = '<span class = "send_money" dir = "ltr">'.number_format($total_currecny_blase).'</span>';
                                  }elseif($total_currecny_blase >=0){
                                    $master_blance = '<span class = "default">'.number_format($total_currecny_blase).'</span>';
                                  }

                                  echo '
                                     <tr>
                                        <td> '.$key.'</td>
                                        <td> '.$MIAN_CURRENCIES[$key].' </td>
                                        <td> <span class="'.$CURRENCY_ICON[$key].'">'.number_format($credit).'          </span> </td>
                                        <td> <span class="'.$CURRENCY_ICON[$key].'">'.number_format($debt).'            </td>
                                        <td> <span class="'.$CURRENCY_ICON[$key].'">'.$master_blance.'   </span> </td>
                                     </tr>
                                  ';
                               }
                                       
                                       ?>
                     </tbody>
                  </table>
                  
               </div>
            </div>
         </div>
      </section>
      <br>
   </div>

   <?php 
require_once("_script.php");

    ?>



<script type="text/javascript">
         function startDateEndDate(start_date , end_date){
                    $("#start_date").val(''); 
                    $("#end_date").val(''); 
            }
            setTimeout(startDateEndDate, 10);
    </script>

</body>

</html>