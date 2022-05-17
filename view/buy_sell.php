<?php
require_once("_config.php");

$condition = '';

if(isset($_POST['search'])){

    if(!empty($_POST['search_currecny_from_id']) && !empty($_POST['search_currecny_to_id']) ){

        $search_currecny_from_id = VD($_POST['search_currecny_from_id']);
        $search_currecny_to_id   = VD($_POST['search_currecny_to_id']);

        $condition .= " AND currency_from_id = '$search_currecny_from_id' AND currency_to_id = '$search_currecny_to_id'  ";
    }

    if(!empty($_POST['search_rate'])){
        $search_rate = VD($_POST['search_rate']);
        $condition  .= " AND rate = '$search_rate' ";
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

<!doctype html>
<html lang="pe" dir="rtl">

<head>
    <?php
    $title = "خرید و فروش";
    require_once "_head.php" ?>
</head>
<?php require_once('alert.php');?>
<body>
    <div class="container-fluid">

        <?php require_once "_header.php" ?>

        <section class="row">

            <?php
                $menu    = "transaction";
                $submenu = "buy_sell";
                require_once "_sidebar.php";
            ?>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 ps-4 pe-4 mt-4 ">
                <div class="row">

                <?php 
                    
                    $header_title = ' روزنامچه';
                    require_once "_eye_icon.php";
                    ?>

                    <div class="col-md-12 mt-3 pe-4 ps-4">
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <div class="align-items-center row">

                                        <div class="col">
                                            <div class="row">
                                                <div class="col-6"><h5 class="text-start lalezar text-muted mb-2 scroll">خرید و فروش</h5></div>
                                                <div class="col-6 d-xs-block d-sm-none  d-md-none  d-lg-none  text-muted text-end"> <?php echo $PDATE ?> </div>
                                            </div>
                                            
                                            <div class="row mt-3 mb-4">
                                                <!-- buy form start -->
                                                <div class="col-xl-8 col-md-8 col-sm-12">
                                                    <div class="row g-3 p-3">
                                                        <nav>
                                                            <!-- <div class="nav d-flex justify-content-center nav-tabs" id="nav-tab" role="tablist"> -->
                                                            <div class="nav nav-tabs bg-light p-2 rounded-3 d-flex bd-highlight" id="nav-tab" role="tablist">

                                                                <button class="nav-link active nav-tabs-succ" id="nav-buy-tab" data-bs-toggle="tab" data-bs-target="#nav-buy" type="button" role="tab" aria-controls="nav-buy" aria-selected="true" style="border-radius: 0.3rem 1rem 0.3rem 1rem;">خرید</button>
                                                                <!-- <button class="m-0 p-0 bg-light">
                                                                        <i class="fas fa-sort-down"></i>
                                                                    </button>
                                                                -->
                                                                <button class="nav-link" id="nav-sell-tab" data-bs-toggle="tab" data-bs-target="#nav-sell" type="button" role="tab" aria-controls="nav-sell" aria-selected="false" style="border-radius:  1rem 0.3rem 1rem 0.3rem;">فروش</button>
                                                                <button class="d-none d-md-block nav-link text-muted text-end flex-grow-1 bd-highlight p-0 me-2"> <?php echo $PDATE ?> </button>
                                                            </div>
                                                        </nav>
                                                        <div class="tab-content" id="nav-tabContent">

                                                        <!-- start buy from   -->
                                                            <div class="tab-pane ms-4 me-4 mt-3 show active" id="nav-buy" role="tabpanel" aria-labelledby="nav-buy-tab">

                                                                <form action="action_buy_sell.php" method="POST" class="currency_validate trade-form row g-3">

                                                                    <input type="hidden" value="1" name="insert" >
                                                                    <input type="hidden" value="buy" name="type">

                                                                    <div class="col-12">
                                                                        <div class="row">
                                                                            <div class="col-6">
                                                                                <label class="form-label text-muted required">واحد پول</label>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <label class="form-label text-muted required">مقدار</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="input-group">
                                                                            <select onchange="getCurrencyRate(currency_from_id.value,currency_to_id.value,'buy')" name="currency_from_id" id="currency_from_id" required="" class="form-control">
                                                                            <option  value=""> پول را انتخاب کنید</option>
                                                                              <?php
                                                                                foreach (get_currency_options() as  $value) {
                                                                                    echo '<option value="'.$value['id'].'"> '.$value['name'].' </option>';
                                                                                }
                                                                            ?>
                                                                            </select>
                                                                            <input type="text" dir="ltr" onkeyup="calculate_rate(currency_from_amount.value,'#currency_to_amount',rate.value,'amount_transaction','buy');frm(this.value,'#currency_from_amount')"  name="currency_from_amount" id="currency_from_amount" required=""  class="form-control num-f" placeholder="0" autocomplete="off">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12 mt-4">
                                                                    <div class="row">
                                                                            <div class="col-6">
                                                                                <label class="form-label text-muted required">واحد تبدیل</label>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <label class="form-label text-muted required">مقدار</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="input-group">
                                                                            <select onchange="getCurrencyRate(currency_from_id.value,currency_to_id.value,'buy')" id="currency_to_id" required name="currency_to_id"  class="form-control">
                                                                                <option  value=""> پول را انتخاب کنید</option>
                                                                                <?php
                                                                                    foreach (get_currency_options() as  $value) {
                                                                                        echo '<option value="'.$value['id'].'"> '.$value['name'].' </option>';
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        <input type="text" required  dir="ltr" name="currency_to_amount" id="currency_to_amount" placeholder="0" class="form-control num-f" autocomplete="off"></div>
                                                                    </div>

                                                                    <div class="col-12 mt-4">
                                                                        <div class="row mt-3">
                                                                            <div class="col-md-2"><label class="form-label text-muted required">نرخ</label></div>
                                                                            <div class="col-md-10">
                                                                                <input type="number" required step="any" onkeyup="calculate_rate(currency_from_amount.value,'#currency_to_amount',rate.value,'amount_transaction','buy')" name="rate" id="rate" placeholder="0" class="form-control " autocomplete="off">
                                                                                <inout type="hidden" id="amount_transaction" name="amount_transaction" >
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mt-4">
                                                                            <div class="col-md-2"><label class="form-label text-muted required">تاریخ</label></div>
                                                                            <div class="col-md-10">
                                                                                <input type="text"  name="date" id="date" required class="form-control date" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12 mt-4">
                                                                        <label class="form-label text-muted" for="note" >توضیحات</label>
                                                                        <textarea name="note" id="note"  class="form-control" autocomplete="off"></textarea>
                                                                    </div>

                                                                    <button type="submit" class="btn btn btn-success btn-block border p-2"> خرید</button>
                                                                </form>
                                                            </div>

                                                            <!-- start buy from   -->

                                                            <div class="tab-pane ms-4 me-4 mt-3" id="nav-sell" role="tabpanel" aria-labelledby="nav-sell-tab">
                                                                <form method="post" action="action_buy_sell.php" class="currency_validate trade-form row g-3">

                                                                <input type="hidden" value="1" name="insert" >
                                                                <input type="hidden" value="sell" name="type" >
                                                                <input type="hidden" value="buy_sell" name="page" >

                                                                    <div class="col-12">
                                                                        <div class="row">
                                                                            <div class="col-6">
                                                                                <label class="form-label text-muted required">واحد پول</label>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <label class="form-label text-muted required">مقدار</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="input-group">
                                                                            <select name="currency_from_id" required="" onchange="getCurrencyRate(currency_from_id_sell.value,currency_to_id_sell.value,'sell')" id="currency_from_id_sell" class="form-control">
                                                                                <option  value=""> پول را انتخاب کنید</option>
                                                                                <?php
                                                                                    foreach (get_currency_options() as  $value) {
                                                                                        echo '<option value="'.$value['id'].'"> '.$value['name'].' </option>';
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                            <input type="text" dir="ltr"  required onkeyup="calculate_rate(currency_from_amount_sell.value,'#currency_to_amount_sell',rate_sell.value,'amount_transaction_sell','sell')" name="currency_from_amount" id="currency_from_amount_sell" placeholder="0" class="form-control num-f" autocomplete="off">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12 mt-4">
                                                                    <div class="row">
                                                                            <div class="col-6">
                                                                                <label class="form-label text-muted required">واحد تبدیل</label>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <label class="form-label text-muted required">مقدار</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="input-group">
                                                                            <select id="currency_to_id_sell" onchange="getCurrencyRate(currency_from_id_sell.value,currency_to_id_sell.value,'sell')" required name="currency_to_id" class="form-control">
                                                                                <option  value=""> پول را انتخاب کنید</option>
                                                                                <?php
                                                                                    foreach (get_currency_options() as  $value) {
                                                                                        echo '<option value="'.$value['id'].'"> '.$value['name'].' </option>';
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                            <input type="text" required dir="ltr" id="currency_to_amount_sell" name="currency_to_amount" placeholder="0" class="form-control num-f" autocomplete="off">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12 mt-4">
                                                                        <div class="row mt-3">
                                                                            <div class="col-md-2">
                                                                                <label class="form-label text-muted required">نرخ</label>
                                                                            </div>
                                                                            <div class="col-md-10">
                                                                                <input type="number" onkeyup="calculate_rate(currency_from_amount_sell.value,'#currency_to_amount_sell',rate_sell.value,'amount_transaction_sell','sell')" step="any" id="rate_sell" required name="rate" placeholder="0" class="form-control" autocomplete="off">
                                                                                <inout type="hidden" id="amount_transaction_sell" name="amount_transaction_sell">
                                                                            </div>
                                                                        </div>

                                                                        <div class="row mt-4">
                                                                            <div class="col-md-2">
                                                                                <label class="form-label text-muted required">تاریخ</label>
                                                                            </div>
                                                                            <div class="col-md-10">
                                                                                <input type="text" required name="date" class="form-control date" autocomplete="off">
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="col-12 mt-4">
                                                                        <label class="form-label text-muted">توضیحات</label>
                                                                        <textarea  name="note" class="form-control" autocomplete="off"></textarea>
                                                                    </div>
                                                                    <button type="submit" class="btn btn btn-danger btn-block text-light border p-2"> فروش</button>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- buy form end -->


                                                <div class="col-xl-4 col-md-4 col-sm-12 ">
                                                    <div class="row mshadow p-3">
                                                        <h5 class="col-md-12 text-start lalezar text-muted mt-3 mb-4">معاملات امروز</h5>

                                                        <?php

                                                            foreach ($MIAN_CURRENCIES as $key => $value) {
                                                            
                                                                echo '
                                                                    <div class="col-12 mb-3">
                                                                        <h6 class="text-start lalezar text-muted mb-2"> '.$value.' </h6>
                                                                        <div class="row">
                                                                            <div class="col-6">
                                                                                <span class="mt-n1 me-2 pt-2 badge bg-success bg-opacity-75">خرید</span>
                                                                                <span class="h5 mb-0 togg '.$CURRENCY_ICON[$key].' CurNumDiv"> '.get_amount_of_daily_currency($key,'buy',$PDATE).' </span>
                                                                                <span class="h4 mb-0 togg priv">******</span>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <span class="mt-n1 me-2 pt-2 badge bg-danger bg-opacity-75">فروش</span>
                                                                                <span class="h5 mb-0 togg '.$CURRENCY_ICON[$key].' CurNumDiv"> '.get_amount_of_daily_currency($key,'sell',$PDATE) .' </span>
                                                                                <span class="h4 mb-0 togg priv">******</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                ';
                                                            }

                                                        ?>


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
                                    <form method="post" action="buy_sell.php" class="row">
                                        <input type="hidden" name="search" value="1">
                                        <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                            <label for="exampleInputEmail1" class="form-label text-muted">از پول</label>
                                            <select name="search_currecny_from_id" class="form-control">
                                                <option  value=""> پول را انتخاب کنید</option>
                                                <?php
                                                    foreach (get_currency_options() as  $value) {
                                                        echo '<option value="'.$value['id'].'"> '.$value['name'].' </option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                            <label for="exampleInputPassword1" class="form-label text-muted">به پول</label>
                                            <select name="search_currecny_to_id" class="form-control">
                                                <option  value=""> پول را انتخاب کنید</option>
                                                <?php
                                                    foreach (get_currency_options() as  $value) {
                                                        echo '<option value="'.$value['id'].'"> '.$value['name'].' </option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                            <label for="exampleInputPassword1" class="form-label text-muted">نرخ</label>
                                            <input type="number" step="any" name="search_rate" autocomplete="off"  class="form-control">
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                            <label for="exampleInputPassword1" class="form-label text-muted">از تاریخ</label>
                                            <input type="text" autocomplete="off" id="start_date" name="start_date"  onload ="startDateEndDate(this.value , end_date.value)" class="form-control date">
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-lg-2 mb-3">
                                            <label for="exampleInputPassword1" class="form-label text-muted">الی تاریخ</label>
                                            <input type="text" id="end_date" autocomplete="off" name="end_date"  class="form-control date">
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
                                    <table class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>شماره</th>
                                                <th>واحد پول</th>
                                                <th>واحد تبدیل</th>
                                                <th>نرخ </th>
                                                <th> نوعیت  </th>
                                                <th>تاریخ</th>
                                                <th>توضیحات</th>
                                                <th>کاربر</th>
                                                <th>عملیات</th>
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
                                                        <td class = ""><span class="togg">' . get_column_value('currencies',$rows['currency_from_id'],'name') . ' - '.''.$rows['currency_from_amount'].'</span> <span class="h4 mb-0 togg priv">*****</span>  '.' </td>
                                                        <td class = ""><span class="togg">' . get_column_value('currencies',$rows['currency_to_id'],'name') . '  - '.''.$rows['currency_to_amount'].'</span> <span class="h4 mb-0 togg priv">*****</span> '.' </td>
                                                        <td class = "">'.$rows['rate'].' </td>
                                                        '.$type_status.'
                                                        <td class = "">'.$rows['date'].'</td>
                                                        <td class = "">' . $rows['note'] . ' </td>
                                                        <td class = ""> ' . get_user_name($rows['user_id']) . ' </td>
                                                        <td>
                                                            <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                                <a href="edit_buy_sell.php?id='.base64_encode($rows['id']).'" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                   <a href="action_buy_sell.php?delete&id='.base64_encode($rows['id']).'" class="btn btn-xs btn-bricky tooltips deleted" data-placement="top" data-original-title="Delete">
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

            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">هشدار !</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            اطلاعات مورد نظر حذف خواهد شد ؟
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">خیر</button>
                            <button type="button" class="btn btn-danger">اجرا شود</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
</div>

    
    <?php require_once "_script.php" ?>
    <script>

    function getCurrencyRate(from_id,to_id,type_transaction){
            if(from_id != '' && to_id != ''){
                $.ajax({
                    url : "ajax.php",
                    method: 'post',
                    data : {
                        type: "getCurrencyRate",
                        from_id,
                        to_id,
                    },success:function(respose){
                        if(respose != 'false'){
                            let row = JSON.parse(respose);
                            if(type_transaction == "buy"){
                                $("#rate").val(row.buy_price);
                                $("#amount_transaction").val(row.amount_transaction);
                                let currency_from_amount =  $("#currency_from_amount").val();
                                currency_from_amount = (currency_from_amount.replaceAll(',','')) * 1 ;
                                var total = ((currency_from_amount / row.amount_transaction) * row.buy_price ).toFixed(2);
                                $("#currency_to_amount").val(total);
                            }else if (type_transaction ==  "sell"){
                                $("#rate_sell").val(row.sell_price);
                                $("#amount_transaction_sell").val(row.amount_transaction);
                                let currency_from_amount_sell =  $("#currency_from_amount_sell").val();
                                currency_from_amount_sell = (currency_from_amount_sell.replaceAll(',','')) * 1;
                                var total = ((currency_from_amount_sell * row.sell_price )  / row.amount_transaction  ).toFixed(2);
                                $("#currency_to_amount_sell").val( total );
                            }

                            easyNumberSeparator({
                                selector: '.num-f',
                                separator: ',',
                            });
                        }else {
                            if(type_transaction == "buy"){
                                $("#rate").val('');
                            }else if (type_transaction ==  "sell"){
                                $("#rate_sell").val('');
                            }
                        }
                    }
                })
            }
        }


        function calculate_rate( from_amount , to_id , rate_amount, amount_transaction , type  ){

            if(from_amount == '' || rate_amount == '')
                return '';
            var amount_transaction = $(`#${amount_transaction}`).val() * 1;
            amount_transaction = ( amount_transaction == '' ) ? 1 : amount_transaction;
            from_amount = (from_amount.replaceAll(',','')) * 1 ;
            if(type == 'buy'){
                var total = ((from_amount / amount_transaction) * rate_amount ).toFixed(2);
                $(to_id).val( total);
            }else if (type == 'sell'){
                var total = ((from_amount * rate_amount )  / amount_transaction  ).toFixed(2);
                $(to_id).val( total);
            }


            easyNumberSeparator({
                selector: '.num-f',
                separator: ',',
            });

        }



    </script>

      <script type="text/javascript">

         function startDateEndDate(start_date , end_date){
                    $("#start_date").val(''); 
                    $("#end_date").val(''); 
            }
            setTimeout(startDateEndDate, 2000);
    </script>

</body>

</html>
