<?php

require_once("_config.php");
     
$condition = '';

if(isset($_POST['search'])){

    if(!empty($_POST['s_account_code'])){
        $s_account_code = VD($_POST['s_account_code']);
        $condition  .= " AND account_code = '$s_account_code' ";
    }

    if(!empty($_POST['s_first_name'])){
        $s_first_name = VD($_POST['s_first_name']);
        $condition  .= " AND first_name = '$s_first_name' " ;
    }

    if(!empty($_POST['s_start_date']) && !empty($_POST['s_end_date']) ){
        $s_start_date = VD($_POST['s_start_date']);
        $s_end_date   = VD($_POST['s_end_date']);

        $condition .= " AND `date` BETWEEN  '$s_start_date' AND '$s_end_date' ";
    }
       
}


$view_data = $db->query("SELECT * FROM `accounts` WHERE `deleted` = '0' AND type = 'special' $condition ORDER BY id DESC LIMIT $to OFFSET $from ");

$list_data  = $db->query("SELECT count(id) as record FROM `accounts` WHERE deleted = 0 AND type = 'special' $condition ")->fetch();
$record     = $list_data['record'];


    // genrate code customer
    $value = $db->query("SELECT account_code FROM `accounts` ORDER BY id DESC LIMIT 1")->fetch();
    $account_code = (!empty($value['account_code'])) ?  $value['account_code']+1 : 1;
    // end  
    

?>
<!DOCTYPE html>
<html lang="pe" dir="rtl">

<head>
    <?php 
    $title = " ثبت حساب خاص ";
    require_once "_head.php" ?>
</head>

<?php require_once('alert.php');?>
<body>
  <div class="container-fluid">
    <?php require_once "_header.php" ?>

    <section class="row">
      <?php 

          $menu    = "constant";
          $submenu = "addـspecial_account";
          require_once "_sidebar.php";
        ?>


      <div class="col-md-10 ps-4 pe-4 mt-4 ">
        <div class="row">
          
        <?php 
          $header_title = 'ثابت ها ';
          require_once "_eye_icon.php";
          ?>

       


          <div class="col-md-12 mt-3 pe-4 ps-4">
            <div class="row">
              <div class="card">
                <div class="card-body">
                  <div class="align-items-center row">
                    <div class="col">
                      <h5 class="text-start lalezar text-muted mb-2">ثبت حساب خاص</h5>
                      <div class="row mb-4">
                        <!-- buy form start -->
                        <div class="col-2"></div>
                        <div class="col-xl-8 col-md-8 col-sm-12">
                          <div class="row g-3 p-3">
                           
                            <div class="tab-content" id="nav-tabContent">
                              <div class="tab-pane ms-4 me-4 mt-1 show active" id="nav-buy" role="tabpanel"
                                aria-labelledby="nav-buy-tab">
                                <form action="action_account.php" method="POST" enctype="multipart/form-data" class="currency_validate trade-form row g-3">

                                  <input type="hidden" name="insert" value="1">
                                  <input type="hidden" name="type"   value="special">
                                  <input type="hidden" name="page"   value="add_special_account">
                                
                                  <div class="col-12 mt-4">

                                    <div class="row mt-3">
                                        <div class="col-md-2"><label class="form-label text-muted required">شماره حساب</label>
                                        </div>
                                        <div class="col-md-10">
                                        <fieldset disabled>
                                            <input type="text" required value="<?php echo $account_code;?>" name="account_code"
                                            class="form-control" autocomplete="off">
                                        </fieldset>
                                    </div>
                                  </div>

                                  <div class="row mt-3">
                                      <div class="col-md-2"><label class="form-label text-muted required">نام</label></div>
                                      <div class="col-md-10">
                                        <input type="text" required name="first_name" class="form-control" autocomplete="off">
                                      </div>
                                  </div>
                                
                                  <div class="row mt-3">
                                      <div class="col-md-2"><label class="form-label text-muted required" for="account_type"> نوعیت  </label></div>
                                      <div class="col-md-10">
                                            <select class="form-control" id="account_type" required name="account_type" >
                                                <option value=""> انتخاب نماید  </option>
                                                <option value="credit" > افزاینده  </option>
                                                <option value="debt" > کاهنده  </option>
                                            </select>
                                      </div>
                                  </div>

                                  <div class="row mt-4">
                                      <div class="col-md-2"><label class="form-label text-muted required"> تاریخ  </label></div>
                                      <div class="col-md-10">
                                        <input type="text" required name="date" class="form-control date" autocomplete="off"></div>
                                  </div>

                                  </div>

                                  <div class="col-12 mt-4">
                                    <label class="form-label text-muted">توضیحات</label>
                                    <textarea type="text" name="note" class="form-control"
                                      autocomplete="off"></textarea>
                                  </div>


                                  <button type="submit" class="btn btn btn-secondary btn-block border p-2"> ثبت حساب
                                  </button>

                                </form>
                              </div>
                            
                            </div>
                          </div>
                        </div>
                        <div class="col-2"></div>

                        <!-- buy form end -->

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
                        <form method="post" action="" role="form" class="row">
                            <input type="hidden" name="search" value="1">
                            <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                            <label for="exampleInputEmail1" class="form-label text-muted"> شماره حساب</label>
                            <input type="number" autocomplete="off" id="s_account_code" name="s_account_code" value="" onload ="" class="form-control " >

                            </div>
                            <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                <label for="exampleInputPassword1" class="form-label text-muted">نام</label>
                                <input type="text" autocomplete="off" id="s_first_name" name="s_first_name" value="" onload ="" class="form-control " >
                            </div>
                            <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                <label for="exampleInputPassword1" class="form-label text-muted">از تاریخ</label>
                                <input type="text" id="start_date" onload ="startDateEndDate(this.value , end_date.value)" autocomplete="off" name="s_start_date" value="" class="form-control date" >
                            </div>
                            <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                <label for="exampleInputPassword1" class="form-label text-muted">الی تاریخ</label>
                                <input type="text" id="end_date" autocomplete="off" name="s_end_date" value="" class="form-control date" >
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
                  <h5 class="text-start lalezar text-muted mb-3 ms-3">حسابات خاص </h5>
                  <div class="overflow-auto">
                    <table id="datatable2" class="table table-striped dt-responsive nowrap w-100">
                      <thead>
                        <tr>
                            <th>شماره</th>
                            <th> شماره حساب </th>
                            <th> نام  </th>
                            <th> نوعیت   </th>
                            <th> تاریخ </th>
                            <th> توضیحات  </th>
                            <th>کاربر  </th>
                            <th>عملیات</th>
                        </tr>
                      </thead>


                      <tbody>
                      <?php
                          if($view_data->rowCount() > 0 ) {
                            foreach ($view_data as $rows) {

                                echo '
                                    <tr class="active">
                                        <td class = ""> ' . ($count++) . ' </td>
                                        <td class = ""> ' . $rows['account_code'] . ' </td>
                                        <td class = ""> ' . $rows['first_name'] . ' </td>
                                        <td class = ""> ' . $ACCOUNT_TYPE[$rows['account_type']] . ' </td>
                                        <td class = ""> '.$rows['date']. ' </td>
                                        <td class = ""> ' . $rows['note'] . ' </td>
                                        <td class = ""> ' . get_user_name($rows['user_id']) . ' </td>
                                        <td class="tab-cen center">
                                            <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                <a href="edit_special_account.php?id='.base64_encode($rows['id']).'" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="action_account.php?delete&id='.base64_encode($rows['id']).'&pagename=add_special_account" class="btn btn-xs btn-bricky tooltips deleted" data-placement="top" data-original-title="Delete">
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
        </div>
        <?php require_once "_footer.php" ?>
      </div>

  </div>

  </section>

  </div>

   <?php require_once "_script.php" ?>

   <script type="text/javascript">
         function startDateEndDate(start_date , end_date){
                    $("#start_date").val(''); 
                    $("#end_date").val(''); 
            }
            setTimeout(startDateEndDate, 10);
    </script>

</body>

</html>