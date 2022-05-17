<?php

    require_once("_config.php");
    
    if(!isset($_GET['id'])){
        header("location: add_user.php?error");
        exit(); 
    }

    $row_id  = base64_decode($_GET['id']);
    $row     = select_one('users',$row_id);

?>

<!doctype html>
<html lang="pe" dir="rtl">

<head>
    <?php 
    $title = "ویرایش";
    require_once "_head.php" ?>
</head>

<body>
    <div class="container-fluid">
        

        <section class="row">
            
            <div class="col-md-2"></div>
            <div class="col-md-8 ps-4 pe-4 mt-2 ">
                <div class="row">
                    

                    <div class="col-md-12 mt-3 pe-4 ps-4">
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <div class="align-items-center row">

                                        <div class="col">
                                            <h5 class="text-start lalezar text-muted mb-2">ویرایش  کاربر</h5>
                                            <div class="row mt-4 mb-4">
                                                <!-- buy form start -->
                                                <div class="col-xl-12 col-md-8 col-sm-12">
                                                    <div class="row g-3 p-3">
                                                        <div class="tab-content" id="nav-tabContent">
                                                            
                                                        <!-- start buy from   -->
                                                            <div class="tab-pane ms-4 me-4 mt-3 show active" id="nav-buy" role="tabpanel" aria-labelledby="nav-buy-tab">
                                                                
                                                                <form action="action_user.php" method="POST" class="currency_validate trade-form row g-3">
                                                                        
                                                                    <input type="hidden" value="1" name="edit" >
                                                                    <input type="hidden" value="<?php echo base64_encode($row_id)?>" name="row_id" >

                                                                    <div class="col-12 mt-4">
                                                                        <div class="row mt-3">
                                                                            <div class="col-md-2"><label class="form-label text-muted required">نام کامل</label></div>
                                                                            <div class="col-md-10">
                                                                                <input type="text" required value="<?php if(isset($row['full_name'])) echo $row['full_name'] ?>" name="full_name" id="full_name" class="form-control" autocomplete="off">
                                                                            </div>
                                                                        </div>

                                                                         <div class="row mt-3">
                                                                            <div class="col-md-2"><label class="form-label text-muted">نام پدر</label></div>
                                                                            <div class="col-md-10">
                                                                                <input type="text" value="<?php if(isset($row['father_name'])) echo $row['father_name'] ?>" name="father_name" id="father_name" class="form-control" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                     <div class="col-12 mt-4">
                                                                        <div class="row mt-3">
                                                                            <div class="col-md-2"><label class="form-label text-muted required">شماره تماس</label></div>
                                                                            <div class="col-md-10">
                                                                                <input type="text" value="<?php if(isset($row['phone'])) echo $row['phone'] ?>" step="any" required name="phone" id="phone" class="form-control" autocomplete="off">
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mt-4">
                                                                            <div class="col-md-2"><label class="form-label text-muted required">اسم کاربری</label></div>
                                                                            <div class="col-md-10">
                                                                                <input type="text"  name="username" required id="username" value="<?php if (isset($row['username'])) echo $row['username'] ?>" class="form-control" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                     <div class="col-12 mt-4">
                                                                        <div class="row mt-3">
                                                                            <div class="col-md-2"><label class="form-label text-muted required">رمز کاربری</label></div>
                                                                            <div class="col-md-10">
                                                                                <input type="text" value="<?php if(isset($row['password'])) echo $row['password'] ?>" step="any" name="password" required id="password" class="form-control" autocomplete="off">
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mt-4">
                                                                            <div class="col-md-2"><label class="form-label text-muted required">تاریخ</label></div>
                                                                            <div class="col-md-10">
                                                                                <input type="text" required name="date" value="<?php if(isset($row['date'])) echo $row['date'] ?>" id="date" class="form-control" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12 mt-4">
                                                                        <label class="form-label text-muted" for="note" >توضیحات</label>
                                                                        <textarea name="note" id="note"  class="form-control" autocomplete="off"><?php  if(isset($row['note'])) echo $row['note'] ?></textarea>
                                                                    </div>

                                                                    <button type="submit" class="btn btn btn-dark btn-block border p-2"> ویرایش</button>

                                                                     <div class="position-relative">
                                                                        <div class="position-absolute top-50 start-50 translate-middle">
                                                                            <a href="add_user.php">بازگشت <i class="fas fa-undo-alt"></i></a>
                                                                        </div>
                                                                    </div>

                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- buy form end -->

                                        
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-md-2"></div>

    </div>
    </section>
    </div>

    <?php require_once "_script.php" ?>                                                                           

</body>

</html>