<?php
require_once("_config.php");

  $condition = '';

  if(isset($_POST['search'])){
    
    
    if(!empty($_POST['search_currecny_from_id'])){
        $search_currecny_from_id = VD($_POST['search_currecny_from_id']);
        $condition  .= " AND currency_from_id = '$search_currecny_from_id' ";
    }

    if(!empty($_POST['search_currecny_to_id'])){
        $search_currecny_to_id = VD($_POST['search_currecny_to_id']);
        $condition  .= " AND currency_to_id = '$search_currecny_to_id' ";
    }

    if(!empty($_POST['search_type_buy']) OR !empty($_POST['search_type_sell'])){
        @$search_type_buy  = VD($_POST['search_type_buy']);
        @$search_type_sell = VD($_POST['search_type_sell']);
        $condition  .= " AND (type = '$search_type_buy' OR type = '$search_type_sell') ";
    }

    if(!empty($_POST['start_date']) && !empty($_POST['end_date']) ){
        $start_date = VD($_POST['start_date']);
        $end_date   = VD($_POST['end_date']);
        
        $condition .= " AND `date` BETWEEN  '$start_date' AND '$end_date' ";
    }

  }

  $view_data = $db->prepare("SELECT * FROM `buy_sell` WHERE deleted = :deleted  $condition ORDER BY id DESC LIMIT $to OFFSET $from ");
  $view_data->execute(['deleted' => 0]);

  $list_data  = $db->query("SELECT count(id) as record FROM buy_sell WHERE deleted = 0 $condition ")->fetch();
  $record     = $list_data['record'];


?>
<!DOCTYPE html>
<html lang="pe" dir="rtl">
   <head>
      <?php
         $title = "گزارش خرید و فروش";
         require_once "_head.php" ?>
   </head>
   <?php require_once('alert.php');?>
   <body>
      <div class="container-fluid">
         <?php require_once "_header.php" ?>
         <section class="row">
            <?php 
             $menu    = "report";
             $submenu = "buy_sell_report";
            require_once "_sidebar.php" ?>
          


    <div class="col-md-10 ps-4 pe-4 mt-4 ">
      <div class="row">

      <?php 
          $header_title = 'گزارشات ';
          require_once "_eye_icon.php";
          ?>


         <div class="col-xl-12 mt-4">
            <div class="mshadow bg-white p-2">
                  
                  <div class="row mt-2">
                     <h5 class="text-start lalezar text-muted mb-3 ms-3">گزارش خرید و فروش</h5>
                     <div class="col-12">
                        <form method="post" action="" class="row" enctype="multipart/form-data">
                              <input type="hidden" name="search" value="1">
                              <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                 <label for="exampleInputEmail1" class="form-label text-muted">نوعیت</label>
                                 <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-5 form-check">
                                       <input class="form-check-input" type="checkbox" value="buy" name="search_type_buy" id="flexCheckDefault">
                                       <label class="form-check-label" for="flexCheckDefault">
                                          خرید
                                       </label>
                                    </div>
                                    <div class="col-5 form-check">
                                       <input class="form-check-input" type="checkbox" value="sell" name ="search_type_sell" id="flexCheckChecked">
                                       <label class="form-check-label" for="flexCheckChecked">
                                          فروش
                                       </label>
                                    </div>
                                 </div>
                                 
                                 
                              </div>
                              <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                 <label for="exampleInputPassword1" class="form-label text-muted">از پول</label>
                                 <select class="form-control" name="search_currecny_from_id" data-placeholder="انتخاب ارز">
                                    <option  value="" >پول را انتخاب کنید</option>
                                          <?php
                                       foreach (get_currency_options() as  $value) {
                                             echo '<option value="'.$value['id'].'"> '.$value['name'].' </option>';
                                       }
                                    ?>
                                 </select>
                              </div>
                              <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                 <label for="exampleInputPassword1" class="form-label text-muted">به پول</label>
                                 <select class="form-control" name="search_currecny_to_id" data-placeholder="انتخاب ارز">
                            <option  value="" >پول را انتخاب کنید</option>
                                 <?php
                                foreach (get_currency_options() as  $value) {
                                    echo '<option value="'.$value['id'].'"> '.$value['name'].' </option>';
                                }
                            ?>
                        </select>                              </div>
                              <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                 <label for="exampleInputPassword1" class="form-label text-muted">از تاریخ</label>
                                 <input type="text" name="start_date" id="start_date" autocomplete="off" class="form-control date">
                              </div>
                              <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                 <label for="exampleInputPassword1" class="form-label text-muted">الی تاریخ</label>
                                 <input type="text" name="end_date" id="end_date" autocomplete="off" class="form-control date">
                              </div>
                              <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                 <div class="text-white pt-2 ">s</div>
                                 <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-secondary btn-block border p-2"> جستجو</button>
                                 </div>
                              </div>
                        </form>
                     </div>
                  </div>
            
            </div>
         </div>


   
          
                  <div class="col-xl-12 mt-4">
                     <div class="card">
                        <div class="card-body">
                           <div class="row mt-2">
                              <h5 class="text-start lalezar text-muted mb-3 ms-3">لیست معاملات</h5>
                              <div class="overflow-auto">
                              <table id="datatable2" class="table table-striped dt-responsive nowrap w-100">
                                 <thead>
                                    <tr>
                                       <th>شماره</th>
                                       <th>از پول</th>
                                       <th>به پول</th>
                                       <th>نرخ </th>
                                       <th> نوعیت  </th>
                                       <th>تاریخ</th>
                                       <th>توضیحات</th>
                                       <th>کاربر</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                       if( $view_data->rowCount() > 0  ) {
                                          foreach ($view_data as $rows) {
                                       
                                               if ($rows['type'] == "buy") {
                                                  $type_status = '<td class = "recive_money">خرید</td>';
                                              }elseif($rows['type'] == "sell"){
                                                  $type_status = '<td class = "send_money">فروش</td>';
                                              }
                                       
                                              echo '
                                              <tr class="active">
                                                  <td class = "">' . ($count++) . ' </td>
                                                  <td class = ""><span class="h4 mb-0 togg priv">******</span><span class="togg">' . get_column_value('currencies',$rows['currency_from_id'],'name') . ' - <span class="CurNumDiv currSign" dir="ltr">'.$rows['currency_from_amount'].'</span></span></td>
                                                  <td class = ""><span class="h4 mb-0 togg priv">******</span><span class="togg">' . get_column_value('currencies',$rows['currency_to_id'],'name') . '  - <span class="CurNumDiv currSign" dir="ltr">'.$rows['currency_to_amount'].'</span></span></td>
                                                  <td class = "">'.$rows['rate']. ' </td>
                                                  '.$type_status.'
                                                  <td class = "">'.$rows['date'].'</td>
                                                  <td class = "">' . $rows['note'] . ' </td>
                                                  <td class = ""> ' . get_user_name($rows['user_id']) . ' </td>
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
                              </div>
                              <div class="d-flex justify-content-center mt-3">
                                 <?php
                                    $pagination->records($record);
                                    $pagination->records_per_page($records_per_page);
                                    
                                                // render the pagination links
                                    if($record>50){
                                        $pagination->render();
                                    }
                                    ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-12 mt-4">
                     
                     <?php 

                     if (!empty($condition) AND !empty($_POST['start_date'])) {
                              $view_data_pdate = $db->query("SELECT * FROM `buy_sell` WHERE deleted = 0 $condition ");

                     }else{
                              $view_data_pdate = $db->query("SELECT * FROM `buy_sell` WHERE deleted = 0 AND `date` = '$PDATE' $condition");
                    }
                    
                     if($view_data_pdate ->rowCount()>0){

                      ?>

                     <div class="card">
                        <div class="card-body">
                           <div class="row mt-2">
                              <h5 class="text-start lalezar text-muted mb-5 ms-3">گذارشات عمومی</h5>
                              <div class="row mt-2">
                                 <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <table id="datatable" class="table table-striped dt-responsive nowrap w-100">
                                       <thead>
                                          <tr>
                                             <th>شماره</th>
                                             <th>واحد پول</th>
                                             <th>خرید </th>
                                             <th>فروش </th>
                                             <th>موجودی فعلی</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          
                                       <?php

                                    $data_row = $view_data_pdate->fetch();

                                    if ($data_row['date'] == $PDATE) {

                                      foreach ($MIAN_CURRENCIES as $key => $value) {

                                          $master_blance_amount = $db->query("SELECT * FROM `master_balance` where id = '$key' ")->fetch()['amount'];
                                          
                                          echo '
                                             <tr>
                                                <td>'.$key.'</td>
                                                <td>'.$MIAN_CURRENCIES[$key].' </td>
                                                <td><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv recive_money currSign" dir="ltr"> '.get_amount_of_currency_pdate( 'buy' , $key , $condition ).'</span> </td>
                                                <td><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv send_money currSign" dir="ltr"> '.get_amount_of_currency_pdate( 'sell' ,$key , $condition ).'</span> </td>
                                                <td><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr"> '.$master_blance_amount.'</span> </td>
                                             </tr>
                                          ';
                                       }
                                      
                                    }else{

                                         foreach ($MIAN_CURRENCIES as $key => $value) {


                                          $master_blance_amount = $db->query("SELECT * FROM `master_balance` where id = '$key' ")->fetch()['amount'];
                                          
                                          echo '
                                             <tr>
                                                <td>'.$key.'</td>
                                                <td>'.$MIAN_CURRENCIES[$key].' </td>
                                                <td><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv recive_money currSign" dir="ltr"> '.get_amount_of_currency( 'buy' , $key , $condition ).'</span> </td>
                                                <td><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv send_money currSign" dir="ltr"> '.get_amount_of_currency( 'sell' ,$key , $condition ).'</span> </td>
                                                <td><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr"> '.$master_blance_amount.'</span> </td>
                                             </tr>
                                          ';
                                       }
                                     }

                                       
                                       ?>


                                       </tbody>
                                    </table>
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-center">
                                    <img src="./assist/img/report.png" height="210rem" alt="">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <?php }?>

                  </div>
                  <?php require_once "_footer.php" ?>
               </div>
            </div>
         </section>
      </div>
      <?php require_once "_script.php"  ?>
      <script type="text/javascript">
         function startDateEndDate(start_date , end_date){
                    $("#start_date").val(''); 
                    $("#end_date").val(''); 
            }
            setTimeout(startDateEndDate, 10);
      </script>
   </body>
</html>