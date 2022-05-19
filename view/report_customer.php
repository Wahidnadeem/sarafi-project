<?php
   require_once("_config.php");


   $condition = '';
   $currency_condition = '';

   if(!empty($_POST['search'])){
      

      if(!empty($_POST['account_code'])){
         $account_code = VD($_POST['account_code']);
         $condition  .= " AND account_code = '$account_code' ";
      }


      if(!empty($_POST['account_id'])){
         $account_id = VD($_POST['account_id']);
         $condition  .= " AND id = '$account_id' ";
      }
      if(!empty($_POST['search_currecny'][0]) and count( $_POST['search_currecny'] ) > 0 ){
        $string = implode(',',$_POST['search_currecny']);
         $currency_condition  .= " AND currency_id IN ( $string ) ";
      }

   }
   
   $view_data = $db->query("SELECT * FROM `accounts` WHERE `deleted` = '0' $condition ORDER BY id DESC LIMIT $to OFFSET $from ");
   
   $list_data  = $db->query("SELECT count(id) as record FROM accounts WHERE deleted = 0 $condition ")->fetch();
   $record     = $list_data['record'];
   
   
   ?>
<!DOCTYPE html>
<html lang="pe" dir="rtl">
   <head>
      <?php
         $title = "گزارش   مشتریان ";
          require_once "_head.php" ?>
   </head>
   <?php require_once('alert.php');?>
   <body>
      <div class="container-fluid">
         <?php require_once "_header.php" ?>
         <section class="row">
            <?php 
               $menu    = "report";
               $submenu = "report_customer";
               require_once "_sidebar.php";
                ?>
            <div class="col-md-10 ps-4 pe-4 mt-4 ">
               <div class="row">
                  <?php 
                     $header_title = 'گزارشات ';
                     require_once "_eye_icon.php";
                     ?>

                     <div class="col-xl-12 mt-4">
                        <div class="mshadow bg-white p-2">
                            
                            <div class="row mt-2">
                                <h5 class="text-start lalezar text-muted mb-3 ms-3"> گزارش   مشتریان   </h5>
                                <div class="col-12">
                                    <form method="post" action="report_customer.php" class="row">
                                        <input type="hidden" name="search" value="1">
                                        <div class="col-xs-12 col-md-6 col-lg-2 mb-3 ms-3">
                                            <label for="exampleInputEmail1" class="form-label text-muted">حساب</label>
                                            <input type="text" class="form-control" id="account_code_search" name="account_code" > 
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                            <label for="exampleInputPassword1" class="form-label text-muted">نام مشتری</label>
                                            <select class="form-control select2" name="account_id" id="account_id_search" data-placeholder="انتخاب ارز">
                                             <option  value="" >مشتری را انتخاب کنید</option>
                                             <?php

                                                $search_account = $db->query("SELECT * FROM `accounts` WHERE `deleted` = '0' order by id desc  ");
                                                foreach ($search_account as $rows){
                                                      echo '<option value="'.$rows['id'].'"> '.$rows['first_name'].' '.$rows['last_name'].' - '.$rows['account_code'].' </option>';
                                                }
                                             ?>
                                          </select>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                            <label  class="form-label text-muted">پول</label>
                                            <select multiple="multiple" name="search_currecny[]" class="form-control select2 ">
                                                <option  value=""> پول را انتخاب کنید</option>
                                                <?php
                                                    foreach (get_currency_options() as  $value) {
                                                        echo '<option value="'.$value['id'].'"> '.$value['name'].' </option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>


                                        <div class="col-xs-12 col-md-6 col-lg-3 mb-3">
                                          <div class="text-white pt-2 ">s</div>
                                          <div class="d-grid gap-2">
                                             <button type="submit" class="btn btn-secondary btn-block border p-2"> جستجو</button>
                                          </div>
                                       </div>

                                       <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                          <div class="text-white pt-2 ">s</div>
                                          <div class="d-grid gap-2">
                                             <a href="../tcpdf/report_customer_pdf.php?query=<?php echo $condition; ?>&currency_condition=<?php echo $currency_condition;?>" class="btn btn-secondary btn-block border p-2">  چاپ گزارش  </a>
                                          </div>
                                       </div>

                                        
                                        <!-- <div class="col-xs-12 col-md-6 col-lg-3 mb-3">
                                          <div class="text-white pt-2 ">s</div>
                                          <div class="d-grid gap-2">
                                             <button type="submit" class="btn btn-secondary btn-block border p-2"> جستجو</button>
                                          </div>
                                       </div> -->
                                    </form>
                                </div>
                            </div>
                        
                        </div>
                    </div>

              

                  <div class="col-xl-12 mt-4">
                     <div class="card">
                        <div class="card-body">
                           <div class="row mt-2">
                              <h5 class="text-start lalezar text-muted mb-3 ms-3">لیست  حسابات مشتریان</h5>
                              <div class="overflow-auto">
                              <table  class="table table-striped dt-responsive nowrap w-100">
                                 <thead>
                                    <tr>
                                       <th>شماره</th>
                                       <th>حساب</th>
                                       <th>نام</th>
                                       <th>افغانی</th>
                                       <th>دالر</th>
                                       <th>تومان</th>
                                       <th>کلدار</th>
                                       <th>یورو</th>
                                       <th>بیلانس</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                       if($view_data->rowCount() > 0  ){
                                       
                                            
                                            foreach ($view_data as $key => $row) {

                                                $array_temp     = [1=> 0,2=>0,3=>0,4=>0,5=>0];
                                                $total_balance_doller  = 0;
                                                $account_id = $row['id'];


                                                $account_balance_data = $db->query("SELECT amount, currency_id FROM `account_balance` WHERE `account_id`='$account_id' $currency_condition  ");
                                             
                                                foreach ($account_balance_data as $key => $account_balance_row) {
                                                   $array_temp[$account_balance_row['currency_id']] = $account_balance_row['amount'];                                
                                                }

                                                foreach ($array_temp as $key => $array_temp_row) {
                                                    
                                                    if($array_temp_row == 0 )
                                                        continue;

                                                    $currency_id = $key;
                                                    
                                                    $currency_rate  = $db->query("SELECT `sell_price` , `amount_transaction` FROM `currency_rate` WHERE currency_from_id = '2' AND currency_to_id = '$currency_id'  ");
                                                    $currency_rate_value    = 1;
                                                    $amount_transaction     = 1;
                                                    
                                                    if($currency_rate->rowCount() > 0 ){
                                                        
                                                        $currency_rate_row      = $currency_rate->fetch();
                                                        $currency_rate_value    = ($currency_rate_row['sell_price'] == 0 ) ? 1 : $currency_rate_row['sell_price'] ;
                                                        $amount_transaction     = ($currency_rate_row['amount_transaction'] == 0) ? 1 : $currency_rate_row['amount_transaction'];
                                                        
                                                    } 

                                                    if($currency_id == 2){
                                                        $temp = $array_temp_row;
                                                    }else {
                                                        $temp = $array_temp_row / ( $currency_rate_value * $amount_transaction );                
                                                    }

                                                    $total_balance_doller += $temp;
                                                }


                                                
                                                echo '
                                                    <tr> 
                                                        <td> '.($count++).'</td>
                                                        <td> '.$row['account_code'].' </td>
                                                        <td> '.$row['first_name'].' </td>
                                                        <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[1].' </span> </td>
                                                        <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[2].' </span> </td>
                                                        <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[3].' </span> </td>
                                                        <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[4].' </span> </td>
                                                        <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[5].' </span> </td>
                                                        <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" >  '.$total_balance_doller.'</span> </td>
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
                     
                     <div class="card">
                        <div class="card-body">
                           <div class="row mt-2">
                              <h5 class="text-start lalezar text-muted mb-5 ms-3">گذارشات عمومی</h5>
                              <div class="row mt-2">
                                 <div class="col-xs-12 col-sm-12 col-md-6 col-6 overflow-auto">
                                    <table id="datatable" class="table table-striped dt-responsive nowrap w-100">
                                       <thead>
                                          <tr>
                                             <th> مجموعه افغانی   </th>
                                             <th> مجموعه دالر </th>
                                             <th> مجموعه تومان </th>
                                             <th>مجموعه  کلدار</th>
                                             <th>مجموعه یورو</th>
                                             <th> مجموعه به دالر  </th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php


                                             $array_temp     = [1=> 0,2=>0,3=>0,4=>0,5=>0];
                                             $temp           = 0;

                                             if(empty($_POST['search'])){
                                                
                                                $total_balance = $db->query("SELECT SUM(amount) as amount , currency_id FROM `account_balance` $currency_condition  GROUP BY currency_id ");

                                                foreach ($total_balance as $key => $row) {
                                                   $array_temp[$row['currency_id']] = $row['amount'];
                                                }

                                             }else {

                                                $view_data = $db->query(" SELECT * FROM `accounts` WHERE `deleted` = '0' $condition ");

                                                foreach ($view_data as $key => $accounts_row ) {
                                                   $account_id = $accounts_row['id'];
                                                   $total_balance_customer = $db->query("SELECT SUM(amount) as amount , currency_id FROM `account_balance` WHERE account_id = $account_id $currency_condition  GROUP BY currency_id ");

                                                   foreach ($total_balance_customer as $key => $account_balance_row) {
                                                      $array_temp[$currency_id] += $account_balance_row['amount'];
                                                   }
                                                }

                                             }

                                             $temp           = 0;
                                             $total_balance_doller = 0;
                                             foreach ($array_temp as $key => $array_temp_row) {
                                                    
                                                if($array_temp_row == 0 )
                                                   continue;

                                                $currency_id = $key;
                                                
                                                $currency_rate  = $db->query("SELECT `sell_price` , `amount_transaction` FROM `currency_rate` WHERE currency_from_id = '2' AND currency_to_id = '$currency_id'  ");
                                                $currency_rate_value    = 1;
                                                $amount_transaction     = 1;
                                                
                                                if($currency_rate->rowCount() > 0 ){
                                                    
                                                   $currency_rate_row      = $currency_rate->fetch();
                                                   $currency_rate_value    = ($currency_rate_row['sell_price'] == 0 ) ? 1 : $currency_rate_row['sell_price'] ;
                                                   $amount_transaction     = ($currency_rate_row['amount_transaction'] == 0) ? 1 : $currency_rate_row['amount_transaction'];
                                                    
                                                } 

                                                if($currency_id == 2){
                                                   $temp = $array_temp_row;
                                                }else {
                                                   $temp = $array_temp_row / ( $currency_rate_value * $amount_transaction );                
                                                }

                                                $total_balance_doller += $temp;
                                             }

                                             echo '
                                                <tr>
                                                   <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[1].'  </span></th>
                                                   <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[2].'  </span></th>
                                                   <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[3].'  </span></th>
                                                   <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[4].'  </span></th>
                                                   <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp[5].'  </span></th>
                                                   <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$total_balance_doller.'  </span></th>
                                                </tr>
                                             ';

                                          ?>  
                                       </tbody>
                                    </table>
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-6 col-6 text-center">
                                    <img src="./assist/img/report.png" height="210rem" alt="">
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                     </div>
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