<?php

   require_once("_config.php");


   $date = $PDATE;
   if(!empty($_POST['search'])){
        if(!empty($_POST['date'])){
            $date = VD($_POST['date']);
        }
   }


    // get debt and credit data 
   $view_data = $db->query("SELECT  SUM(amount) as amount , currency_id , `type`  FROM `account_transaction` WHERE `date` = '$date' GROUP BY currency_id , `type` ");

   $array_temp_debt    = [1=> 0,2=>0,3=>0,4=>0,5=>0];
   $array_temp_credit  = [1=> 0,2=>0,3=>0,4=>0,5=>0];

   foreach ($view_data as $key => $row) {
        
        if($row['type']  == "debt"){
            $array_temp_debt[$row['currency_id']] = $row['amount'];
        }else if ($row['type']  == "credit"){
            $array_temp_credit[$row['currency_id']] = $row['amount'];
        }
    }
    // end get debt and credit data 

    
    // get master balance data
    $master_balance_data    = select_all('master_balance');
    $array_master_balance   = [1=> 0,2=>0,3=>0,4=>0,5=>0];
    
    foreach ($master_balance_data as $key => $master_balance_row) {
        $array_master_balance[$master_balance_row['currency_id']] = $master_balance_row['amount'];
    }
    // end get master balance data

    // get currency rate 
    $array_currency_rate = [1=> 'قیمت گذاری نماید' ,2=>' 1 ',3=>'قیمت گذاری نماید',4=>'قیمت گذاری نماید',5=>'قیمت گذاری نماید'];

    foreach ($array_currency_rate as $key => $array_currency_row) {
    
        $row_data = $db->query("SELECT `sell_price` FROM `currency_rate` WHERE currency_from_id = '2' and currency_to_id = $key AND `date` = '$date' ");
        if($row_data->rowCount() > 0){
            $row = $row_data->fetch();
            $array_currency_rate[$key] = $row['sell_price'];
        }else {
         $array_currency_rate[$key] = 1;
        }
    }
    
    // end  get currency rate 


?>

<!DOCTYPE html>
<html lang="pe" dir="rtl">
   <head>
      <?php
         $title = " گزارش  عمومی  ";
          require_once "_head.php" ?>
   </head>
   <?php require_once('alert.php');?>
   <body>
      <div class="container-fluid">
         <?php require_once "_header.php" ?>
         <section class="row">
            <?php 
               $menu    = "report";
               $submenu = "general_account";
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
                                <h5 class="text-start lalezar text-muted mb-3 ms-3">  جستجو گزارش  عمومی   </h5>
                                <div class="col-12">
                                    <form method="post" action="report_general_account.php" class="row">
                                        <input type="hidden" name="search" value="1">
                                      
                                        <div class="col-xs-12 col-md-6 col-lg-2 mb-3 ms-3">
                                            <label for="date" class="form-label text-muted"  > تاریخ  </label>
                                            <input type="text" name="date"  id="date" autocomplete="off" class="form-control date">
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-lg-3 mb-3">
                                          <div class="text-white pt-2 ">s</div>
                                          <div class="d-grid gap-2">
                                             <button type="submit" class="btn btn-secondary btn-block border p-2"> جستجو</button>
                                          </div>
                                       </div>

                                       <div class="col-xs-12 col-md-6 col-lg-3 mb-3">
                                          <div class="text-white pt-2 ">s</div>
                                          <div class="d-grid gap-2">
                                             <a href="../tcpdf/general_account_pdf.php" class="btn btn-secondary btn-block border p-2">  چاپ گزارش  </a>
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
                              <h5 class="text-start lalezar text-muted mb-3 ms-3"> لیست بیلانس عمومی    </h5>
                              <div class="overflow-auto">
                              <table  class="table table-striped dt-responsive nowrap w-100">
                                 <thead>
                                    <tr>
                                       <th>حسابات </th>
                                       <th>دالر</th>
                                       <th>تومان</th>
                                       <th>افغانی</th>
                                       <th>کلدار</th>
                                       <th>یورو</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php

                                        echo '
                                            <tr> 
                                                <td>  مجموعه رسید مشتریان   </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp_credit[2].' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp_credit[3].' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp_credit[1].' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp_credit[4].' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp_credit[5].' </span> </td>
                                            </tr>

                                            <tr> 
                                                <td>  مجموعه برد مشتریان   </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp_debt[2].' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp_debt[3].' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp_debt[1].' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp_debt[4].' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.$array_temp_debt[5].' </span> </td>
                                            </tr>

                                            <tr> 
                                                <td>  مجموعه بلانس  مشتریان   </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.( $array_temp_credit[2] - $array_temp_debt[2] ).' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.( $array_temp_credit[3] - $array_temp_debt[3] ).' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.( $array_temp_credit[1] - $array_temp_debt[1] ).' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.( $array_temp_credit[4] - $array_temp_debt[4] ).' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.( $array_temp_credit[5] - $array_temp_debt[5] ).' </span> </td>
                                            </tr>

                                            <tr> 
                                                <td>  خزانه موجود صرافی   </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '. $array_master_balance[2] .' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '. $array_master_balance[3] .' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '. $array_master_balance[1] .' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '. $array_master_balance[4] .' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '. $array_master_balance[5] .' </span> </td>
                                            </tr>

                                            <tr> 
                                                <td>  مجموعه کل      </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.( (($array_temp_credit[2] - $array_temp_debt[2]) * -1 ) + $array_master_balance[2]  ).' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.( (($array_temp_credit[3] - $array_temp_debt[3]) * -1 ) + $array_master_balance[3]  ).' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.( (($array_temp_credit[1] - $array_temp_debt[1]) * -1 ) + $array_master_balance[1]  ).' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.( (($array_temp_credit[4] - $array_temp_debt[4]) * -1 ) + $array_master_balance[4]  ).' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '.( (($array_temp_credit[5] - $array_temp_debt[5]) * -1 ) + $array_master_balance[5]  ).' </span> </td>
                                            </tr>

                                            <tr> 
                                                <td>  نرخ تبدیل پول دالر   </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '. $array_currency_rate[2] .' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '. $array_currency_rate[3] .' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '. $array_currency_rate[1] .' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '. $array_currency_rate[4] .' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '. $array_currency_rate[5] .' </span> </td>
                                            </tr>

                                            <tr> 
                                                <td>  مجموعه دالر       </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '. ( ( (($array_temp_credit[2] - $array_temp_debt[2]) * -1 ) + $array_master_balance[2] ) / $array_currency_rate[2]   ) .' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '. ( ( (($array_temp_credit[3] - $array_temp_debt[3]) * -1 ) + $array_master_balance[3] ) / $array_currency_rate[3]   ) .' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '. ( ( (($array_temp_credit[1] - $array_temp_debt[1]) * -1 ) + $array_master_balance[1] ) / $array_currency_rate[1]   ) .' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '. ( ( (($array_temp_credit[4] - $array_temp_debt[4]) * -1 ) + $array_master_balance[4] ) / $array_currency_rate[4]   ) .' </span> </td>
                                                <td> <span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" > '. ( ( (($array_temp_credit[5] - $array_temp_debt[5]) * -1 ) + $array_master_balance[5] ) / $array_currency_rate[5]   ) .' </span> </td>
                                            </tr>


                                        ';

                                       ?>
                                 </tbody>
                              </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                        
                  <?php require_once "_footer.php" ?>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
      <?php require_once "_script.php"  ?>
      <script type="text/javascript">
         function startDateEndDate(start_date , end_date){
                    $("#date").val(''); 
                    // $("#end_date").val(''); 
            }
            setTimeout(startDateEndDate, 10);
      </script>
     
   </body>
</html>