<?php
require_once("_config.php");

$condition = '';

if(!empty($_POST['search'])){


    if(!empty($_POST['search_account'])){
        $search_account = VD($_POST['search_account']);
        $condition .= " AND account_id = '$search_account' ";
    }

    if(!empty($_POST['account_type'])){
        $account_type = VD($_POST['account_type']);
        $condition .= " AND account_type = '$account_type' ";
    }

    if(!empty($_POST['search_currecy'])){
        $search_currecy = VD($_POST['search_currecy']);
        $condition .= " AND  currency_id = '$search_currecy' ";
    }

     if(!empty($_POST['search_type_credit']) OR !empty($_POST['search_type_debt'])){
        @$search_type_credit  = VD($_POST['search_type_credit']);
        @$search_type_debt    = VD($_POST['search_type_debt']);
        $condition  .= " AND (type = '$search_type_credit' OR type = '$search_type_debt') ";
    }


    if(!empty($_POST['start_date']) && !empty($_POST['end_date']) ){
        $start_date = VD($_POST['start_date']);
        $end_date   = VD($_POST['end_date']);
        
        $condition .= " AND `date` BETWEEN  '$start_date' AND '$end_date' ";
    }

     if(!empty($_POST['account_code'])){
        $account_code = VD($_POST['account_code']);

        $account_data = $db->query("SELECT id FROM `accounts` WHERE deleted = '0' AND `account_code` = '$account_code' LIMIT 1");

        $search_account = ($account_data->rowCount() > 0) ? $account_data->fetch()['id'] : 0;
        $condition .= " AND account_id = '$search_account' ";
    }
}

$view_data = $db->query("SELECT * FROM `account_transaction` WHERE deleted = '0' $condition ORDER BY id DESC LIMIT $to OFFSET $from ");

$list_data  = $db->query("SELECT count(id) as record FROM account_transaction WHERE deleted = 0 $condition ")->fetch();
$record     = $list_data['record'];


?>
<!DOCTYPE html>
  <html lang="pe" dir="rtl">

  <head>
    <?php
    $title = "گزارش رسید و برد";
     require_once "_head.php" ?>
  </head>
  <?php require_once('alert.php');?>
  <body>
  <div class="container-fluid">
    <?php require_once "_header.php" ?>

    
            <section class="row">
              <?php 

                $menu    = "report";
                $submenu = "transaction_report";
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
                     <h5 class="text-start lalezar text-muted mb-3 ms-3">گزارش رسید و برد</h5>
                     <div class="col-12">
                        <form method="post" action="" class="row" enctype="multipart/form-data">
                              <input type="hidden" name="search" value="1">
                              <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                 <label for="exampleInputEmail1" class="form-label text-muted">نوعیت</label>
                                 <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-5 form-check">
                                      <input class="form-check-input" type="checkbox" value="credit" name="search_type_credit" id="flexCheckDefault">
                                      <label class="form-check-label" for="flexCheckDefault">
                                        رسید
                                      </label>
                                    </div>
                                    <div class="col-5 form-check">
                                      <input class="form-check-input" type="checkbox" value="debt" name ="search_type_debt" id="flexCheckChecked">
                                      <label class="form-check-label" for="flexCheckChecked">
                                        برد
                                      </label>
                                    </div>
                                 </div>
                                 
                                 
                              </div>

                            <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                <label for="exampleInputPassword1" class="form-label text-muted">نوعیت حساب</label>
                              <select class="form-control select" name="account_type" data-placeholder="حساب را انتخاب کنید ">
                                 <option  value=""> نوعیت  را انتخاب کنید</option>
                                 <option  value="special">حسابات خاص</option>
                                 <option  value="public">حسابات مشتریان</option>     
                              </select>
                            </div>

                              <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                 <label for="exampleInputPassword1" class="form-label text-muted">نام حساب</label>
                                 <select class="form-control select2" name="search_account" data-placeholder="حساب را انتخاب کنید ">
                             <option  value="">حساب را انتخاب کنید</option>
                                <?php
                                $account_name = $db->prepare('SELECT * FROM `accounts` WHERE `deleted` =:deleted');
                                $account_name->execute(['deleted' => 0]);
                                foreach ($account_name as $account_rows){
                                    echo '<option value="'.$account_rows['id'].'"> '.$account_rows['first_name'].' '.$account_rows['last_name'].' - '.$account_rows['account_code'].' </option>';
                                }
                                ?>
                          </select>
                              </div>
                              <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                 <label for="exampleInputPassword1" class="form-label text-muted">واحد پول</label>
                                 <select class="form-control" name="search_currecy" data-placeholder="انتخاب ارز">
                             <option  value=""> پول را انتخاب کنید</option>
                                  <?php
                                  foreach (get_currency_options() as  $value) {
                                      echo '<option value="'.$value['id'].'"> '.$value['name'].' </option>';
                                  }
                              ?>
                          </select>
                                 </div>
                              <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                 <label for="exampleInputPassword1" class="form-label text-muted">از تاریخ</label>
                                 <input type="text" name="start_date" onload ="startDateEndDate(this.value , end_date.value)" id="start_date" autocomplete="off" class="form-control date">
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

                              <!-- <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                  <div class="text-white pt-2 ">s</div>
                                  <div class="d-grid gap-2">
                                     <a href="../tcpdf/transcation_pdf.php" class="btn btn-secondary btn-block border p-2">  چاپ گزارش  </a>
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
                  <h5 class="text-start lalezar text-muted mb-3 ms-3">لیست انتقالات</h5>
                  <div class="overflow-auto">
                  <table id="datatable2" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>شماره</th>
                                <th>نام  و تخلص</th>
                                <th>شماره حساب</th>
                                <th>نوعیت</th>
                                <th>واحد پول </th>
                                <th> مقدار  </th>
                                <th>تاریخ</th>
                                <th>توضیحات</th>
                                <th>کاربر</th>
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
                                        $type_status = '<td class = "recive_money">رسید</td>';
                                    }elseif($rows['type'] == "debt"){
                                        $type_status = '<td class = "send_money">برد</td>';
                                    }

                                echo '
                                <tr class="active">
                                    <td class = "">' . ($count++) . ' </td>
                                    <td class = "">' . $account_row['first_name'] . ' ' . $account_row['last_name'] . ' </td>
                                    <td class = ""> <span class="h4 mb-0 togg priv">***</span><span class="togg CurNumDiv  currSign" dir="ltr"> ' . $account_row['account_code'] . ' </span> </td>
                                    '.$type_status.'
                                    <td class = "">' . $currency_row['name'] . ' </td>
                                    <td class = ""><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr">'.$rows['amount'].'</span></td>
                                    <td class = ""> '.$rows['date']. ' </td>
                                    <td class = ""> ' . $rows['note'] . ' </td>
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
                              $view_data_pdate = $db->query("SELECT * FROM `account_transaction` WHERE deleted = 0 $condition ");

                     }else{
                              $view_data_pdate = $db->query("SELECT * FROM `account_transaction` WHERE deleted = 0 AND `date` = '$PDATE' $condition");
                    }
                    
                     if($view_data_pdate ->rowCount()>0){

                      ?>
          <div class="card">
            <div class="card-body">
              <div class="row mt-2">
                <h5 class="text-start lalezar text-muted mb-5 ms-3"> گذارشات عمومی <span style = ""> تاریخ <?php echo persionData($PDATE)?></span></h5>
                <div class="row mt-2">
                  <div class="col-xs-12 col-sm-12 col-md-6 col-6">
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
                            
                          $data_row = $view_data_pdate->fetch();

                          if ($data_row['date'] == $PDATE) {

                            $view_data =  $db->query("SELECT id FROM `account_transaction` WHERE date = '$PDATE' AND deleted = 0 $condition LIMIT 1  ");
                            
                            if( $view_data->rowCount() > 0){
                              $reprot_count = 1;
                              
                              $currency_data = select_all('currencies');

                              foreach ($currency_data as $key => $row) {

                                $currency_id = $row['id'];

                                $debt_amount = $db->query("SELECT SUM(amount) as amount FROM `account_transaction` WHERE deleted = 0 and type = 'debt'  and currency_id = '$currency_id' AND `date` = '$PDATE' $condition LIMIT 1 ")->fetch();
                                $credit_amount = $db->query("SELECT SUM(amount) as amount FROM `account_transaction` WHERE deleted = 0 and type = 'credit' and currency_id = '$currency_id' AND `date` = '$PDATE' $condition LIMIT 1 ")->fetch();
                                
                                if($debt_amount == 0 && $credit_amount == 0 ){
                                  continue;
                                }
                                
                                $total_currecny_blance = (($credit_amount['amount'] - $debt_amount['amount']) + 0);
                                $total_currecny_color  = ( $total_currecny_blance < 0  ) ? 'send_money' : '';  

                                echo '
                                    <tr>
                                        <th>'.$reprot_count++.'</th>
                                        <th>'.$row['name'].' </th>
                                        <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" >'.($credit_amount['amount'] + 0).' </span></th>
                                        <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" >'.($debt_amount['amount'] + 0) .'</span></th>
                                        <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv '.$total_currecny_color.' currSign" dir="ltr" >'.(($credit_amount['amount'] - $debt_amount['amount']) + 0) .' </span></th>
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
                          }else{

                             $view_data =  $db->query("SELECT id FROM `account_transaction` WHERE deleted = 0 $condition LIMIT 1  ");
                            
                            if( $view_data->rowCount() > 0){
                              $reprot_count = 1;
                              
                              $currency_data = select_all('currencies');

                              foreach ($currency_data as $key => $row) {

                                $currency_id = $row['id'];

                                $debt_amount = $db->query("SELECT SUM(amount) as amount FROM `account_transaction` WHERE deleted = 0 and type = 'debt'  and currency_id = '$currency_id' $condition LIMIT 1 ")->fetch();
                                $credit_amount = $db->query("SELECT SUM(amount) as amount FROM `account_transaction` WHERE deleted = 0 and type = 'credit' and currency_id = '$currency_id' $condition LIMIT 1 ")->fetch();
                                
                                if($debt_amount == 0 && $credit_amount == 0 ){
                                  continue;
                                }
                                
                                $total_currecny_blance = (($credit_amount['amount'] - $debt_amount['amount']) + 0);
                                $total_currecny_color  = ( $total_currecny_blance < 0  ) ? 'send_money' : '';  

                                echo '
                                    <tr>
                                        <th>'.$reprot_count++.'</th>
                                        <th>'.$row['name'].' </th>
                                        <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" >'.($credit_amount['amount'] + 0).' </span></th>
                                        <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr" >'.($debt_amount['amount'] + 0) .'</span></th>
                                        <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv '.$total_currecny_color.' currSign" dir="ltr" >'.(($credit_amount['amount'] - $debt_amount['amount']) + 0) .' </span></th>
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


                          }
                            
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
<?php }?>
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