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
      $title = "رسید و برد";
      require_once "_head.php" ?>
   </head>
   <?php require_once('alert.php');?>
   <body>
      <div class="container-fluid">
         <?php require_once "_header.php" ?>
         <section class="row">
            <?php 
               $menu    = "transaction";
               $submenu = "account_transaction";
               require_once "_sidebar.php";
            ?>
            <div class="col-md-10 ps-4 pe-4 mt-4 ">
               <div class="row">
               <?php 
                        $header_title = 'روزنامچه';
                        require_once "_eye_icon.php";
                        ?>
                        
                  <div class="col-md-12 mt-3 pe-4 ps-4">
                     <div class="row">
                        <div class="card">
                           <div class="card-body">
                              <div class="align-items-center row">
                                 <div class="col">
                                 <div class="row">
                                                <div class="col-6"><h5 class="text-start lalezar text-muted mb-2 scroll">رسید و برد</h5></div>
                                                <div class="col-6 d-xs-block d-sm-none  d-md-none  d-lg-none  text-muted text-end"> <?php echo $PDATE ?> </div>
                                            </div>
                                    <div class="row mt-2 mb-4">
                                       <!-- buy form start -->
                                       <div class="col-xl-6 col-md-7 col-sm-12">
                                          <div class="row g-3 p-3">
                                             <nav>
                                                <!-- <div class="nav d-flex justify-content-center nav-tabs" id="nav-tab" role="tablist"> -->
                                                <div class="nav nav-tabs bg-light p-2 rounded-3 d-flex bd-highlight" id="nav-tab"
                                                   role="tablist">
                                                   <button class="nav-link active nav-tabs-succ" id="nav-buy-tab" data-bs-toggle="tab"
                                                      data-bs-target="#nav-buy" type="button" role="tab" aria-controls="nav-buy"
                                                      aria-selected="true" style="
                                                      border-radius: 0.3rem 1rem 0.3rem 1rem;
                                                      ">رسید</button>
                                                   <button class="nav-link" id="nav-sell-tab" data-bs-toggle="tab"
                                                      data-bs-target="#nav-sell" type="button" role="tab" aria-controls="nav-sell"
                                                      aria-selected="false" style="
                                                      border-radius:  1rem 0.3rem 1rem 0.3rem;
                                                      ">برد</button>
                                                   <button
                                                      class="d-none d-md-block nav-link text-muted text-end flex-grow-1 bd-highlight p-0 me-2"> <?php echo $PDATE ?> </button>
                                                </div>
                                             </nav>
                                             <div class="tab-content" id="nav-tabContent">
                                                <div class="tab-pane ms-4 me-4 mt-3 show active" id="nav-buy" role="tabpanel"
                                                   aria-labelledby="nav-buy-tab">
                                                   
                                                   <form action="action_transcation.php" method="post" class="currency_validate trade-form row g-3">

                                                      <input type="hidden" value="1" name="insert" >
                                                      <input type="hidden" value="credit" name="type">     
                                                   
                                                      <div class="col-12 mt-4">
                                                         <div class="row mt-3">
                                                            <div class="col-md-2">
                                                               <label class="form-label text-muted required"> حساب  </label>
                                                            </div>
                                                            <div class="col-md-10">

                                                               <select name="account_id" class="form-control select2" required id="account_id" onchange="getAccountAmountDetails(this.value)" >
                                                                  <option value=""> حساب را انتخاب کنید </option> 
                                                                     <?php 
                                                                        $account_id = $db->query("SELECT * FROM `accounts` WHERE `deleted` = '0' order by id desc  ");
                                                                        foreach ($account_id as $rows){
                                                                              echo '<option value="'.$rows['id'].'"> '.$rows['first_name'].' '.$rows['last_name'].' - '.$rows['account_code'].' </option>';
                                                                        }
                                                                     ?>
                                                               </select>

                                                            </div>
                                                         </div>
                                                      </div>

                                                      
                                                      <div class="col-12 mt-4">
                                                         <div class="row mt-3">
                                                            <div class="col-md-2">
                                                               <label class="form-label text-muted required">واحد / مقدار</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                               <div class="input-group">
                                                                  <select name="currency_id" required id="currency_id"  required="required" class="form-control">
                                                                     <option value=""> پول را انتخاب کنید </option> 
                                                                        <?php 
                                                                           $currency_id = $db->query("SELECT * FROM `currencies` WHERE `deleted` = '0'");
                                                                           foreach ($currency_id as $rows){
                                                                                 echo '<option value="'.$rows['id'].'"> '.$rows['name'].' </option>';
                                                                           }
                                                                        ?>
                                                                  </select>
                                                                  <input type="text" dir="ltr"  required id="amount" name="amount" onkeyup="frm(this.value,'#amount')" class="form-control num-f" autocomplete="off">
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>

                                                      <div class="col-12 mt-2">

                                                         <div class="row mt-3">
                                                            <div class="col-md-2">  <label class="form-label text-muted required" for="by_person" >توسط</label></div>
                                                            <div class="col-md-10"> <input type="text" id="by_person" name="by_person" required class="form-control"></div>
                                                         </div>

                                                         <div class="row mt-4">
                                                            <div class="col-md-2"><label class="form-label text-muted required" for="date">تاریخ</label></div>
                                                            <div class="col-md-10"><input type="text" name="date" placeholder="<?php echo $PDATE ?>" required class="form-control date" autocomplete="off"></div>
                                                         </div>
                                                      </div>

                                                      <div class="col-12 mt-4">
                                                         <label class="form-label text-muted">توضیحات</label>
                                                         <textarea  name="note" class="form-control" autocomplete="off"></textarea>
                                                      </div>
                                                      <button type="submit" class="btn btn btn-success btn-block border p-2"> رسید
                                                      </button>
                                                   </form>

                                                </div>
                                                <div class="tab-pane ms-4 me-4 mt-3" id="nav-sell" role="tabpanel"
                                                   aria-labelledby="nav-sell-tab">

                                                   <form action="action_transcation.php" method="POST" class="currency_validate trade-form row g-3">
                                                      
                                                      <input type="hidden" value="1" name="insert" >
                                                      <input type="hidden" value="debt" name="type">

                                                      <div class="col-12 mt-4">
                                                         <div class="row mt-3">
                                                            <div class="col-md-2"><label class="form-label text-muted required">  حساب  </label></div>
                                                            <div class="col-md-10">
                                                               <select name="account_id" required id="account_debt_id" onchange="getAccountAmountDetails(this.value)"  class="form-control select2">
                                                                 <option value=""> حساب را انتخاب کنید </option> 
                                                                     <?php 
                                                                        $account_id = $db->query("SELECT * FROM `accounts` WHERE `deleted` = '0' order by id desc  ");
                                                                        foreach ($account_id as $rows){
                                                                              echo '<option value="'.$rows['id'].'"> '.$rows['first_name'].' '.$rows['last_name'].' - '.$rows['account_code'].' </option>';
                                                                        }
                                                                     ?>
                                                               </select>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      
                                                      <div class="col-12 mt-4">
                                                         <div class="row mt-3">
                                                            <div class="col-md-2">
                                                               <label class="form-label text-muted required">واحد / مقدار</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                               <div class="input-group">
                                                                  <select name="currency_id" id="currency_id"  required="required" class="form-control">
                                                                     <option value=""> پول را انتخاب کنید </option> 
                                                                        <?php 
                                                                           $currency_id = $db->query("SELECT * FROM `currencies` WHERE `deleted` = '0'");
                                                                           foreach ($currency_id as $rows){
                                                                                 echo '<option value="'.$rows['id'].'"> '.$rows['name'].' </option>';
                                                                           }
                                                                        ?>
                                                                  </select>
                                                                  <input type="text" required dir="ltr" id="debt_amount" name="amount" onblur ="get_amount_account(this.value , account_id.value , currency_id.value)" onkeyup="frm(this.value,'#debt_amount')" class="form-control num-f" autocomplete="off">
                                                               </div>
                                                               <p class="required" id="amount_is_not_exsist" style="font-size: 18px;display: none;color:#a71414; margin-top: 8px;margin-bottom:-30px; " >این حساب بیشتر از موجودی خود برداشت میکند !</p>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="col-12 mt-2">
                                                         <div class="row mt-3">
                                                            <div class="col-md-2"><label class="form-label text-muted required" for="debt_by_person" >توسط</label></div>
                                                            <div class="col-md-10"><input type="text" name="by_person" id="debt_by_person" required class="form-control"></div>
                                                         </div>
                                                         <div class="row mt-4">
                                                            <div class="col-md-2"><label class="form-label text-muted required" for="debt_date" >تاریخ</label></div>
                                                            <div class="col-md-10"><input type="text" name="date" id="debt_date" required placeholder="<?php echo $PDATE ?>" class="form-control date" autocomplete="off"></div>
                                                         </div>
                                                      </div>

                                                      <div class="col-12 mt-4">
                                                         <label class="form-label text-muted" for="debt_note">توضیحات</label>
                                                         <textarea  name="note" class="form-control" id="debt_note" autocomplete="off"></textarea>
                                                      </div>
                                                      <button type="submit" class="btn btn btn-danger btn-block border p-2"> برد </button>
                                                   </form>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <!-- buy form end -->
                                       <div class="col-xl-6 mt-3 col-md-5 col-sm-12 " >
                                          <div class="row mshadow p-3 "  style="display:none" id="details_tbale" >
                                             <div class="col-6">
                                                <h5 class="col-md-12 text-start lalezar text-muted mt-3 mb-4" > بیلانس عمومی   </h5>   
                                             </div>
                                     
                                             <div class="col-6 text-end">
                                                <h5 class=" mt-3 mb-4">
                                                   <span class="h5 mb-1 togg CurNumDiv DollarSign2 currSign" id="account_master_blanse_div" dir="ltr">0</span>
                                                   <span class="h4 mb-0 togg priv">******</span>
                                                   <i class="fas fa-wallet ms-2"></i>
                                                </h5>
                                             </div>
                                             <table class="table table-striped dt-responsive nowrap w-100">
                                                <thead>
                                                   <tr>
                                                      <th style="font-size:12px" > افغانی  </th>
                                                      <th style="font-size:12px" > دالر  </th>
                                                      <th style="font-size:12px" > تومان  </th>
                                                      <th style="font-size:12px" > کلدار </th>
                                                      <th style="font-size:12px" > یورو  </th>
                                                   </tr>
                                                </thead>
                                                <tbody >
                                                  <tbody>
                                                     <tr id="tr_blanse_file">

                                                     </tr>
                                                  </tbody>
                                                </tbody>
                                             </table>
                                             <div class="col-6">
                                                <h5 class="col-md-12 text-start lalezar text-muted mt-3 mb-4">انتقالات اخیر</h5>
                                             </div>
                                             
                                             <table class="table table-striped dt-responsive nowrap w-100">
                                                <thead>
                                                   <tr>
                                                      <th style="font-size:12px" >شماره</th>
                                                      <th style="font-size:12px" >نوعیت</th>
                                                      <th style="font-size:12px" >توسط</th>
                                                      <th style="font-size:12px" >مقدار</th>
                                                      <th style="font-size:12px" >واحد پول</th>
                                                      <th style="font-size:12px" >تاریخ</th>
                                             
                                                   </tr>
                                                </thead>
                                                <tbody id="add_tr_id">
                                                  
                                                   
                                                </tbody>
                                             </table>
                                             <div class="d-grid gap-2" id="short_account_report">
                                                
                                             </div>
                                          </div>

                                          <div class="row mshadow p-3" id="empty_img" >
                                             <img src="./assist/img/em.png" alt="">
                                          </div>

                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="col-xl-12 mt-4">
                        <div class="mshadow bg-white p-2">
                            
                            <div class="row mt-2">
                                <h5 class="text-start lalezar text-muted mb-3 ms-3">جستجو</h5>
                                <div class="col-12">
                                    <form method="post" action="" class="row">
                                        <input type="hidden" name="search" value="1">
                                        <div class="col-xs-12 col-md-6 col-lg-4 mb-3">
                                            <label for="exampleInputEmail1" class="form-label text-muted">حساب</label>
                                            <select class="form-control select2" name="search_account">
                                                <option  value="">حساب را انتخاب کنید</option>
                                                <?php 
                                                      $search_account = $db->query("SELECT * FROM `accounts` WHERE `deleted` = '0' order by id desc  ");
                                                      foreach ($search_account as $rows){
                                                            echo '<option value="'.$rows['id'].'"> '.$rows['first_name'].' '.$rows['last_name'].' - '.$rows['account_code'].' </option>';
                                                      }
                                                   ?>
                                             </select>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                            <label for="exampleInputPassword1" class="form-label text-muted">واحد پول</label>
                                            <select class="form-control" name="search_currecy">
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
                                            <input type="text" id="start_date" onload ="startDateEndDate(this.value , end_date.value)" autocomplete="off" name="start_date" value="" class="form-control date" >
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                            <label for="exampleInputPassword1" class="form-label text-muted">الی تاریخ</label>
                                            <input type="text" id="end_date" autocomplete="off" name="end_date" value="" class="form-control date" >
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
                              <h5 class="text-start lalezar text-muted mb-3 ms-3">معاملات</h5>
                              <div class="overflow-auto">
                                 <table id="datatable2" class="table table-striped dt-responsive nowrap w-100">
                                    <thead>
                                       <tr>
                                          <th>شماره</th>
                                          <th>نام و تخلص</th>
                                          <th>نوعیت</th>
                                          <th>واحد پول</th>
                                          <th>مقدار</th>
                                          <th>تاریخ</th>
                                          <th>توسط</th>
                                          <th>توضیحات</th>
                                          <th>کاربر</th>
                                          <th>عملیات</th>
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
                                             <tr>
                                                   <td>' . ($count++) . ' </td>
                                                   <td>' . $account_row['first_name'] . ' ' . $account_row['last_name'] . ' - ' . $account_row['account_code'] . ' </td>
                                                   '.$type_status.'
                                                   <td>' . $currency_row['name'] . ' </td>
                                                   <td><span class ="label label-info togg '.$CURRENCY_ICON[$currency_id].' CurNumDiv" dir="ltr"> '.$rows['amount']. '</span> <span class="h4 mb-0 togg priv">******</span> </td>
                                                   <td> '.$rows['date']. ' </td>
                                                   <td>' . $rows['by_person'] . ' </td>
                                                   <td> ' . $rows['note'] . ' </td>
                                                   <td> ' . get_user_name($rows['user_id']) . ' </td>
                                                   <td class="tab-cen center">
                                                      <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                            <a href="edit_transcation.php?id='.base64_encode($rows['id']).'" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit">
                                                               <i class="fa fa-edit"></i>
                                                            </a>
                                                               <a href="action_transcation.php?delete&id='.base64_encode($rows['id']).'" class="btn btn-xs btn-bricky tooltips deleted" data-placement="top" data-original-title="Delete">
                                                                     <i class=" fa fa-trash"></i>
                                                               </a>
                                                         </div>

                                                   </td>
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
                  <?php require_once "_footer.php" ?>
               </div>
            </div>
      </div>
      </section>
      </div>
      <?php require_once "_script.php" ?>
      <script> 
            // Get Account Details
            function getAccountAmountDetails(account_id){
               if(account_id != ''){
                  $.ajax({
                     url:"ajax.php",
                     method:"post",
                     data:{
                        account_id:account_id,
                        type:'getDetailsAccountBalance'
                     },
                     success:function(response){
                        var datas = response.split('##');
                        $("#details_tbale").show('slow');
                        $("#add_tr_id").html(datas[0]);
                        $("#tr_blanse_file").html(datas[2]);
                        $("#account_master_blanse_div").html(datas[1]);
                        $("#short_account_report").html(datas[3]);
                        $("#empty_img").hide();

                        let x = document.querySelectorAll(".CurNumDiv_a");
                        for (let i = 0, len = x.length; i < len; i++) {
                           let num = Number(x[i].innerHTML)
                              .toLocaleString('en');
                           x[i].innerHTML = num;
                        }

                     }
                  });
               }
         }

         function get_amount_account(debt_amount , account_id , currency_id){

                if(debt_amount == '' || account_id == '' || currency_id == '' )
                    return '';

                $.ajax({
                    url:'ajax.php',
                    method: "post",
                    data : {
                        account_id  :account_id, 
                        debt_amount :debt_amount, 
                        currency_id :currency_id,
                        type        :"is_bigger"
                    },success:function (data){
                        if(data == "true"){
                            $("#amount_is_not_exsist").show('slow');
                        }else {
                            $("#amount_is_not_exsist").hide('slow');
                        }
                    }
                })
            }

      </script>

   <script type="text/javascript">
         function startDateEndDate(start_date , end_date){
                    $("#start_date").val(''); 
                    $("#end_date").val(''); 
            }
            setTimeout(startDateEndDate, 10);
    </script>

   </body>
</html>