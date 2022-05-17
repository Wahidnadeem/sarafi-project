<?php 
require_once("_config.php");

    $user_data = $db->prepare("SELECT * FROM `users` WHERE `deleted` =:deleted ORDER BY id DESC");
    $user_data->execute(['deleted' => 0]);

?>
<!DOCTYPE html>
<html lang="pe" dir="rtl">

<head>
    <?php 
    $title = "ثبت کاربر";
    require_once "_head.php" ?>
</head>
<?php require_once('alert.php');?>
<body>
  <div class="container-fluid">
    <?php require_once "_header.php" ?>

    
            <section class="row">
              <?php 
                $menu    = "users";
                require_once "_sidebar.php";
                ?>
            


      <div class="col-md-10 ps-4 pe-4 mt-4 ">
        <div class="row">
        <?php 
          $header_title = 'مدیریت کاربران  ';
          require_once "_eye_icon.php";
          ?>
          
          <div class="col-md-12 mt-3 pe-4 ps-4">
            <div class="row">
              <div class="card">
                <div class="card-body">
                  <div class="align-items-center row">
                    <div class="col">
                      <h5 class="text-start lalezar text-muted mb-2 ">ثبت   کاربر</h5>
                      <div class="row mb-4">
                        <!-- buy form start -->
                        <div class="col-2"></div>
                        <div class="col-xl-8 col-md-8 col-sm-12">
                          <div class="row g-3 p-3">
                           
                            <div class="tab-content" id="nav-tabContent">
                              <div class="tab-pane ms-4 me-4 mt-1 show active" id="nav-buy" role="tabpanel"
                                aria-labelledby="nav-buy-tab">
                                <form action="action_user.php" method="POST" enctype="multipart/form-data" name="myform">
                                
                                <input type="hidden" name="insert">

                                  <div class="col-12 mt-4">

                                  <div class="row mt-3">
                                      <div class="col-md-2"><label class="form-label text-muted required">نام کامل</label>
                                      </div>
                                        <div class="col-md-10">
                                            <input type="text" required name="full_name"class="form-control" autocomplete="off">
                                        </div>
                                  </div>
                                
                                  <div class="row mt-3">
                                      <div class="col-md-2"><label class="form-label text-muted">نام  پدر</label></div>
                                      <div class="col-md-10">
                                        <input type="text" name="father_name"class="form-control" autocomplete="off">
                                      </div>
                                  </div>

                                  <div class="row mt-3">
                                      <div class="col-md-2"><label class="form-label text-muted required">شماره تماس</label></div>
                                      <div class="col-md-10">
                                        <input type="text" required name="phone"class="form-control" autocomplete="off">
                                        </div>
                                  </div>

                                    <div class="row mt-3">
                                      <div class="col-md-2"><label class="form-label text-muted required">اسم کاربری</label></div>
                                      <div class="col-md-10">
                                        <input type="text" required name="username"class="form-control" autocomplete="off">
                                      </div>
                                    </div>

                                    <div class="row mt-3">
                                      <div class="col-md-2"><label class="form-label text-muted required">رمز کاربری</label></div>
                                      <div class="col-md-10">
                                        <input type="text" name="password"class="form-control" required autocomplete="off"></div>
                                    </div>

                                    <div class="row mt-4">
                                      <div class="col-md-2"><label class="form-label text-muted required">تاریخ</label></div>
                                      <div class="col-md-10">
                                        <input type="text" name="date" required class="form-control date " autocomplete="off"></div>
                                    </div>

                                  </div>

                                  <div class="col-12 mt-4">
                                    <label class="form-label text-muted">توضیحات</label>
                                    <textarea type="text" name="note" class="form-control"
                                      autocomplete="off"></textarea>
                                  </div>


                                    <div class="d-grid gap-2 mt-3">
                                        <button class="btn btn-secondary btn-block border p-2" type="submit">ثبت  کاربر</button>
                                    </div>

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
            <div class="card">
              <div class="card-body">
                <div class="row mt-2">
                  <h5 class="text-start lalezar text-muted mb-3 ms-3">کاربران</h5>
                  <div class="overflow-auto">
                  <table id="datatable2" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th class="">شماره</th>
                                <th class="">نام کامل</th>
                                <th class="">نام کاربری</th>
                                <th class="">شماره تماس</th>
                                <th class="">تاریخ </th>
                                <th class="">توضیحات</th>
                                <th class="">عملیات</th>
                                
                            </tr>
                        </thead>
                    <tbody>
                      <?php
                         $count = "1";
                            if($user_data->rowCount() > 0) {
                                foreach ($user_data as $rows) {


                                    echo '
                                    <tr class="active">
                                        <td class = ""> ' . ($count++) . ' </td>
                                        <td class = ""> ' . $rows['full_name'] . ' </td>
                                        <td class = ""> ' . $rows['username'] . ' </td>
                                        <td class = ""> ' . $rows['phone'] . ' </td>
                                        <td class = ""> ' . $rows['date'] . ' </td>
                                        <td class = ""> ' . $rows['note'] . ' </td>
                                           <td class="tab-cen center">
                                                <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                    <a href="edit_user.php?id='.base64_encode($rows['id']).'" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                       <a href="action_user.php?delete&id='.base64_encode($rows['id']).'" class="btn btn-xs btn-bricky tooltips deleted" data-placement="top" data-original-title="Delete">
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

 <?php require_once "_script.php"  ?>

</body>

</html>