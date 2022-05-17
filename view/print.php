<?php 
require_once("_config.php");


$condition = '';

if(isset($_POST['search'])){

  if(!empty($_POST['search_account'])){
    $search_account = VD($_POST['search_account']);
    $condition .= " AND account_id = '$search_account' ";
 }

 if(!empty($_POST['search_currecy'])){
    $search_currecy = VD($_POST['search_currecy']);
    $condition .= " AND  currency_id = '$search_currecy' ";
 }

 if(!empty($_POST['start_date']) && !empty($_POST['end_date']) ){
    $start_date = VD($_POST['start_date']);
    $end_date   = VD($_POST['end_date']);

    $condition .= " AND `date` BETWEEN  '$start_date' AND '$end_date' ";
 }

 $view_data = $db->query("SELECT * FROM `account_transaction` WHERE deleted = '0' $condition ORDER BY id DESC LIMIT $to OFFSET $from ");

 $list_data  = $db->query("SELECT count(id) as record FROM account_transaction WHERE deleted = 0 $condition ")->fetch();
 $record     = $list_data['record'];

}

$view_data = $db->query("SELECT * FROM `account_transaction` WHERE deleted = '0' $condition ORDER BY id DESC LIMIT $to OFFSET $from ");

$list_data  = $db->query("SELECT count(id) as record FROM account_transaction WHERE deleted = 0 $condition ")->fetch();
$record     = $list_data['record'];


?>


<!doctype html>
   <html lang="pe" dir="rtl">
   <head>
      <?php 
      require_once "_head.php" ?>

      <style type="text/css">
         @media print {

            .print-none{
               display: none !important;
            }

         }
         .right{
            text-align: ;
         }
      </style>
   </head>
   <?php require_once('alert.php');?>
   <body>
      <div class="container-fluid">
         <section class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 ps-4 pe-4 mt-4 ">
               <div class="row">


                  <div class="col-xl-12 mt-4 print-none" >
                     <div class="mshadow bg-white p-2">
                       <div class="row mt-2">
                        <h5 class="text-start lalezar text-muted mb-3 ms-3">جستجو</h5>
                        <div class="col-md-12">
                         <form role="form" class="currency_validate trade-form row g-3" action="" method="POST" enctype="multipart/form-data">
                           <input type="hidden" name="search" value="1">
                           <!-- SEARCH BOX -->
                           <div class="row">
                              <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12 col-xl-12">
                                 <!-- table  -->
                                 <table>
                                    <br>
                                    <tr>
                                       <th class="ps-2">  حساب  </th>
                                       <th class="ps-2"> واحد پول</th>
                                       <th class="ps-2"> از تاریخ</th>
                                       <th class="ps-2"> الی تاریخ</th>
                                    </tr>

                                    <tr>


                                       <td >
                                          <select class="form-control w-13 select2" name="search_account">
                                             <option  value="">حساب را انتخاب کنید</option>
                                             <?php 
                                             $search_account = $db->query("SELECT * FROM `accounts` WHERE `deleted` = '0'");
                                             foreach ($search_account as $rows){
                                                echo '<option value="'.$rows['id'].'"> '.$rows['first_name'].' '.$rows['last_name'].' - '.$rows['account_code'].' </option>';
                                             }
                                             ?>
                                          </select>
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
                                          <input type="text" id="start_date" onload ="startDateEndDate(this.value , end_date.value)" autocomplete="off" name="start_date" value="" class="form-control " >
                                       </td>

                                       <td class="ps-2">
                                          <input type="text" id="end_date" autocomplete="off" name="end_date" value="" class="form-control " >
                                       </td>

                                       <td class="ps-2">
                                          <button  type="submit" name="search" class="pointer btn btn-secondary w-13" ><i></i> جستجو </button>
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


<div class="col-xl-12 mt-4">
   <div style="text-align: center;">

      <img src="./assist/img/img2.png" alt=""></div>
   </div>
  &nbsp;&nbsp; <button  class="btn-dark print-none col-md-1" onclick="window.print();" style="color: #fff; position: relative; top:-10px"> <i class="fa fa-print"></i> Print</button>&nbsp;&nbsp; 

   <a class="btn-dark print-none col-md-1" href="../tcpdf/index.php" style="color: #fff; position: relative; top:-10px"> <span style="position: relative ;top: 6px;right: 12px;">  <i class="fa fa-file"></i> PDF </span></a>
   <div class="card">

      <div class="card-body">
         <div class="row mt-2">
            <h5 class="text-start lalezar text-muted mb-3 ms-3">معاملات     &nbsp;<span style="font-size: 22px; color: lightseagreen;">  علی  احمد بختیاری     --- 1293844</span>

               <span style="font-size: 22px; color: lightseagreen;float: left;"> شنبه  &nbsp;&nbsp; 1400/10/9 </span>
            </h5>
            <table id="datatable2" class="table table-striped dt-responsive nowrap w-100">
               <thead>
                  <tr>
                     <th>شماره</th>
                     <th> توسط</th>
                     <th>واحد پول</th>
                     <th>مقدار</th>
                     <th>نوعیت</th>
                     <th>تاریخ</th>
                     <th>توضیحات</th>
                  </tr>
               </thead>
               <tbody>

                  <?php
                  if( $view_data->rowCount() > 0  ) {
                     foreach ($view_data as $rows) {

                        $account_id = $rows['account_id'];
                        $account_data = $db->query("SELECT * FROM `accounts` WHERE `id`='$account_id'");
                        $account_row = $account_data->fetch();

                        $currency_id = $rows['currency_id'];
                        $currency_data = $db->query("SELECT * FROM `currencies` WHERE `id`='$currency_id'");
                        $currency_row = $currency_data->fetch();

                        if ($rows['type'] == "credit") {
                           $type_status = '<td class = "text-right">رسید</td>';
                        }elseif($rows['type'] == "debt"){
                           $type_status = '<td class = "text-right">برد</td>';
                        }

                        echo '
                        <tr>
                        <td>' . ($count++) . ' </td>
                        <td class="text-right">' . $rows['by_person'] . ' </td>
                        <td >' . $currency_row['name'] . ' </td>
                        <td  ><span class ="label label-info togg '.$CURRENCY_ICON[$currency_id].' CurNumDiv"> '.$rows['amount']. '</span> <span class="h6 mb-0 togg priv">****</span> </td>
                                                '.$type_status.'

                        <td > '.$rows['date']. ' </td>
                        <td > ' . $rows['note'] . ' </td>

                        </tr>
                        ';
                     }
                  }else {
                     echo '
                     <tr>
                     <td colspan="13" class="text-center">
                     <img src="img/empty.png">
                     <br>
                     کدام اطلاعاتی وجود ندارد 
                     <br><br>
                     </td>
                     </tr>
                     ';
                  }

                  ?>


               </tbody>
            </table>
         </div>
         <br>
      </div>
   </div>

   
</div>
<br>
<div class="row">
   <div class="card">
      <div class="card-body">
         <div class="row mt-2">
            <h5 class="text-start lalezar text-muted mb-3 ms-3"> جمله حساب      &nbsp; <span style="font-size: 22px; color: lightseagreen;">  علی  احمد بختیاری    ---  1293844</span>

               <span style="font-size: 22px; color: lightseagreen;float: left;"> شنبه  &nbsp;&nbsp; 1400/10/9 </span>
            </h5>
            <table id="datatable2" class="table table-striped dt-responsive nowrap w-100">
               <thead>
                  <tr>
                     <th class="center">شماره</th>
                     <th class="center">واحد پول</th>
                     <th class="center">رسید</th>
                     <th class="center">برد</th>
                     <th class="center">اتنقال</th>
                     <th class="center">موجودی فعلی</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td class="right">1</td>
                     <td class="right"> اورو</td>
                     <td class="right">1000</td>
                     <td class="right">300</td>
                     <td class="right">3</td>
                     <td class="right">200000</td>
                  </tr>
                  <tr>
                     <td class="right">2</td>
                     <td class="right"> تومان</td>
                     <td class="right">1000</td>
                     <td class="right">300</td>
                     <td class="right">3</td>
                     <td class="right">200000</td>
                  </tr>
                  <tr>
                     <td class="right">3</td>
                     <td class="right"> کلدار</td>
                     <td class="right">1000</td>
                     <td class="right">300</td>
                     <td class="right">3</td>
                     <td class="right">200000</td>
                  </tr>
                     
                  
               </tbody>
            </table>
            <br>
         </div>
      </div>
   </div>
</div>
<br>

</div>
</div>
</div>
</section>
</div>

<script type="text/javascript">
   function print(){
      window.print();
   }
</script>
</body>
</html>