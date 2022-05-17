<?php
require_once("_config.php");

$condition = '';

if(!empty($_POST['search'])){

    if(!empty($_POST['search_currecy'])){
        $search_currecy = VD($_POST['search_currecy']);
        $condition .= " AND  currency_id = '$search_currecy' ";
    }

     if(!empty($_POST['search_type_transcation']) OR !empty($_POST['search_type_buy_sell'])){
        @$search_type_transcation  = VD($_POST['search_type_transcation']);
        @$search_type_buy_sell    = VD($_POST['search_type_buy_sell']);
        $condition  .= " AND (page = '$search_type_transcation' OR page = '$search_type_buy_sell') ";
    }


    if(!empty($_POST['start_date']) && !empty($_POST['end_date']) ){
        $start_date = VD($_POST['start_date']);
        $end_date   = VD($_POST['end_date']);
        
        $condition .= " AND `date` BETWEEN  '$start_date' AND '$end_date' ";
    }

}

$view_data = $db->query("SELECT * FROM `intent` WHERE deleted = '0' AND `type` = 'credit' $condition ORDER BY id DESC LIMIT $to OFFSET $from ");

$list_data  = $db->query("SELECT count(id) as record FROM intent WHERE deleted = 0 $condition ")->fetch();
$record     = $list_data['record'];


?>
<!DOCTYPE html>
  <html lang="pe" dir="rtl">

  <head>
    <?php
    $title = "گزارش  مفاد";
     require_once "_head.php" ?>
  </head>
  <?php require_once('alert.php');?>
  <body>
  <div class="container-fluid">
    <?php require_once "_header.php" ?>

    
            <section class="row">
              <?php 

                $menu    = "report";
                $submenu = "report_benefit";
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
                     <h5 class="text-start lalezar text-muted mb-3 ms-3">گزارش  مفاد</h5>
                     <div class="col-12">
                        <form method="post" action="" class="row" enctype="multipart/form-data">
                              <input type="hidden" name="search" value="1">

                              <div class="col-xs-12 col-md-6 col-lg-3 mb-3">
                                 <label for="exampleInputEmail1" class="form-label text-muted">نوعیت</label>
                                 <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-5 form-check">
                                      <input class="form-check-input" type="checkbox" value="transcation" name="search_type_transcation" id="flexCheckDefault">
                                      <label class="form-check-label" for="flexCheckDefault">
                                        رسید و برد
                                      </label>
                                    </div>
                                    <div class="col-5 form-check">
                                      <input class="form-check-input" type="checkbox" value="buy_sell" name ="search_type_buy_sell" id="flexCheckChecked">
                                      <label class="form-check-label" for="flexCheckChecked">
                                        خرید و فروش
                                      </label>
                                    </div>
                                 </div>
                                 
                                 
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
                              <div class="col-xs-12 col-md-6 col-lg-3 mb-3">
                                  <div class="text-white pt-2 ">s</div>
                                  <div class="d-grid gap-2">
                                     <a href="../tcpdf/benefit_pdf.php" class="btn btn-secondary btn-block border p-2">  چاپ گزارش  </a>
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
                  <h5 class="text-start lalezar text-muted mb-3 ms-3">لیست  مفاد</h5>
                  <div class="overflow-auto">
                  <table id="datatable2" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th class="">شماره</th>
                                <th class="">درک مفاد</th>
                                <th class="">واحد پول</th>
                                <th class="">مقدار</th>
                                <th class="">مقدار به دالر </th>
                                <th class="">تاریخ</th>
                                <th class="">توضیحات</th>
                            </tr>
                        </thead>
                    <tbody>
                      
                         <?php
                             if( $view_data->rowCount() > 0  ) {
                                foreach ($view_data as $rows) {

                                    $currency_id = $rows['currency_id'];
                                    $currency_data = $db->query("SELECT * FROM `currencies` WHERE `id`='$currency_id'");
                                    $currency_row = $currency_data->fetch();

                                    $page_id = $rows['page_id'];
                                    $account_transactions = $db->query("SELECT * FROM `account_transaction` WHERE `id` = '$page_id' AND `deleted` = '0' AND `account_type` = 'special'");
                                    $account_transactions_row = $account_transactions->fetch();

                                    $account_id  = $account_transactions_row['account_id'];
                                    $acount_name = $db->query("SELECT * FROM `accounts` WHERE `id` = '$account_id' AND `deleted` = '0' AND `type` = 'special'")->fetch(); 

                                    if ($rows['page'] == "transcation") {
                                        $type_status = '<td>'.$acount_name['first_name'].'</td>';
                                    }elseif($rows['page'] == "buy_sell"){
                                        $type_status = '<td>خرید و فروش</td>';
                                    }

                                echo '
                                <tr class="active">
                                    <td class = "">' . ($count++) . ' </td>
                                    '.$type_status.'
                                    <td class = "">' . $currency_row['name'] . ' </td>
                                    <td class = ""><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr">'.$rows['amount'].'</span></td>
                                    <td class = ""><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv  currSign" dir="ltr">'.$rows['final_amount'].'</span></td>
                                    <td class = ""> '.$rows['date']. ' </td>
                                    <td class = ""> ' . $rows['note'] . ' </td>
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
                  <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                    <table id="datatable" class="table table-striped dt-responsive nowrap w-100">
                        
                        <tbody>
                          <th>موجودی فعلی :  </th>
                            <?php
                            
                            $view_data =  $db->query("SELECT * FROM `intent` WHERE deleted = 0 AND `type` = 'credit' $condition");
                            
                            
                            if( $view_data->rowCount() > 0){
                              $total_currecny_blance = 0;
                              foreach ($view_data as $key => $row) {
                                
                                $total_currecny_blance += $row['final_amount'];
                                
                              }

                              echo '
                                        <th><span class="h4 mb-0 togg priv">******</span><span class="togg CurNumDiv currSign" dir="ltr" style="font-size:18px;">'.$total_currecny_blance .' </span></th>
                                ';

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