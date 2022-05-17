<?php

    require_once("_config.php");
    
    if(!isset($_GET['id'])){
        header("location: transcation.php?error");
        exit(); 
    }

    $row_id  = base64_decode($_GET['id']);
    $row     = select_one('account_transaction',$row_id);

    if(!is_array($row)){
        header("location: transcation.php?error");
        exit();
    }


?>

<!doctype html>
<html lang="pe" dir="rtl">

<head>
    <?php 
    $title = "گزارش";
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
                                            <h5 class="text-start lalezar text-muted mt-2 mb-2">ویرایش  رسید و برد </h5>
                                            <div class="row mt-4 mb-4">
                                                <!-- buy form start -->
                                                <div class="col-xl-12 col-md-8 col-sm-12">
                                                    <div class="row g-3 p-3">
                                                        <div class="tab-content" id="nav-tabContent">
                                                            
                                                        <!-- start buy from   -->
                                                            <div class="tab-pane ms-4 me-4 mt-3 show active" id="nav-buy" role="tabpanel" aria-labelledby="nav-buy-tab">
                                                                
                                                                <form action="action_transcation.php" method="POST" class="currency_validate trade-form row g-3">
                                                                        
                                                                    <input type="hidden" value="1" name="edit" >
                                                                    <input type="hidden" value="<?php echo base64_encode($row_id)?>" name="row_id" >
                                                            
                                                                    <div class="row">

                                                                        <label class="form-check-label text-muted required">
                                                                            نوعیت
                                                                        </label>
                                                                        
                                                                        <div class="col-md-2 mt-2">       
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" value="credit" type="radio" name="type" id="credit" <?php if($row['type'] == "credit")  echo "checked" ?> >
                                                                                <label class="form-check-label" for="buy_type">
                                                                                    رسید     
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-10 mt-2">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" value="debt" type="radio" name="type" id="debt" <?php if($row['type'] == "debt")  echo "checked" ?>>
                                                                                <label class="form-check-label" for="sell_type">
                                                                                    برد
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12 mt-4">
                                                                        <label class="form-label text-muted required" for="note" > حساب </label>
                                                                        <select name="account_id" id="account_id" required class="form-control select2">
                                                                            <option value=""> انتخاب نمایید. </option> 
                                                                                <?php 
                                                                                    $account_id = $db->query("SELECT * FROM `accounts` WHERE `deleted` = '0'");
                                                                                    foreach ($account_id as $rows){
                                                                                        if($row['account_id'] == $rows['id'])
                                                                                            echo '<option selected value="'.$rows['id'].'"> '.$rows['first_name'].' '.$rows['last_name'].' - '.$rows['account_code'].' </option>';
                                                                                        else 
                                                                                            echo '<option value="'.$rows['id'].'"> '.$rows['first_name'].' '.$rows['last_name'].' - '.$rows['account_code'].' </option>';
                                                                                    }
                                                                                ?>
                                                                        </select>
                                                                    </div>
                                                            
                                                                    <div class="col-12 mt-4">
                                                                        <label class="form-label text-muted required"> واحد / مقدار   </label>
                                                                        <div class="input-group">
                                                                            <select id="currency_id" name="currency_id" required  class="form-control">
                                                                                <option value=""> یکی از گذینه های ذیل را انتخاب نمایید. </option> 
                                                                                <?php
                                                                                    foreach (get_currency_options() as  $value) {
                                                                                        if ( $value['id'] == $row['currency_id'] )
                                                                                            echo '<option selected value="'.$value['id'].'"> '.$value['name'].' </option>';
                                                                                        else 
                                                                                            echo '<option value="'.$value['id'].'"> '.$value['name'].' </option>';
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        <input type="text" step="any" value="<?php if(isset($row['amount'])) echo $row['amount'] ?>" name="amount" required id="amount" placeholder="0.0" class="form-control num-f " autocomplete="off"></div>
                                                                    </div>

                                                                    <div class="col-12 mt-4">
                                                                        <div class="row mt-3">
                                                                            <div class="col-md-2"><label class="form-label text-muted required"> توسط </label></div>
                                                                            <div class="col-md-10">
                                                                                <input type="text" value="<?php if(isset($row['by_person'])) echo $row['by_person'] ?>"  name="by_person" required id="by_person" placeholder="0.0" class="form-control" autocomplete="off">
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mt-4">
                                                                            <div class="col-md-2"><label class="form-label text-muted required">تاریخ</label></div>
                                                                            <div class="col-md-10">
                                                                                <input type="text" required name="date" id="date" value="<?php if(isset($row['date'])) echo $row['date'] ?>" class="form-control text-end" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12 mt-4">
                                                                        <label class="form-label text-muted" for="note" >توضیحات</label>
                                                                        <textarea name="note" id="note"  class="form-control" autocomplete="off"><?php  if(isset($row['note'])) echo $row['note'] ?></textarea>
                                                                    </div>

                                                                    <button type="submit" class="btn btn-dark btn-block border p-3 mb-2 mshadow"> ویرایش</button>

                                                                    <div class="position-relative">
                                                                        <div class="position-absolute top-50 start-50 translate-middle">
                                                                            <a href="transcation.php">بازگشت <i class="fas fa-undo-alt"></i></a>
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