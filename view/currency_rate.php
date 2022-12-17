<?php 
require_once("_config.php");

    $view_data = $db->query("SELECT * FROM currency_rate WHERE deleted = '0' ORDER BY `date` DESC ");
?>
<!DOCTYPE html>
<html lang="pe" dir="rtl">


<head>
    <?php 
    $title = "ثبت اسعار";
    require_once "_head.php" ?>
</head>

<?php require_once('alert.php');?>
<body>
    <div class="container-fluid">
        
        <?php require_once "_header.php" ?>

        <section class="row">
        
            <?php 
                $menu = "constant";
                $submenu = 'currency_rate';
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
                                            <h5 class="text-start lalezar text-muted mb-2 ">ثبت   نرخ اسعار</h5>
                                            <div class="row mt-4 mb-4">
                                              <!-- buy form start -->

                            <div class="col-2"></div>
                            <div class="col-xl-8 col-md-8 col-sm-12">
                                <div class="row g-3 p-3">

                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane ms-4 me-4 mt-1 show active" id="nav-buy" role="tabpanel" aria-labelledby="nav-buy-tab">

                                            <form action="action_currency_rate.php" method="POST" enctype="multipart/form-data" name="myform">

                                                <input type="hidden" value="1" name="insert" >

                                                <div class="col-12 mt-4">

                                                    <div class="row mt-3">
                                                        <div class="col-md-2 required"><label class="form-label text-muted">از واحد پول</label></div>
                                                        <div class="col-md-10">
                                                            <select class="form-control" required="" onchange="get_currency_rate(currency_from_id.value,currency_to_id.value)" id="currency_from_id" name="currency_from_id">
                                                                <option  value=""> پول را انتخاب کنید</option>
                                                                    <?php
                                                                        foreach (get_currency_options() as  $value) {
                                                                            echo '<option value="'.$value['id'].'"> '.$value['name'].' </option>';
                                                                        }
                                                                    ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col-md-2 required"><label class="form-label text-muted">به واحد پول</label></div>
                                                        <div class="col-md-10">
                                                            <select class="form-control" required="" onchange="get_currency_rate(currency_from_id.value,currency_to_id.value)" id="currency_to_id" name="currency_to_id" >
                                                            <option  value=""> پول را انتخاب کنید</option>
                                                            <?php
                                                                foreach (get_currency_options() as  $value) {
                                                                    echo '<option value="'.$value['id'].'"> '.$value['name'].' </option>';
                                                                }
                                                            ?>
                                                        </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col-md-2 required"><label class="form-label text-muted">مقدار عددی واحد</label></div>
                                                        <div class="col-md-10">
                                                            <input type="text" dir="ltr" required="" value="1" class="form-control num-f " autocomplete="off" id="amount_transaction" name="amount_transaction">
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col-md-2 required"><label class="form-label text-muted">نرخ خرید</label></div>
                                                        <div class="col-md-10">
                                                            <input type="text" dir="ltr" required="" class="form-control num-f" autocomplete="off" id="buy_price" name="buy_price">
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col-md-2 required"><label class="form-label text-muted">نرخ فروش</label></div>
                                                        <div class="col-md-10">
                                                            <input type="text" dir="ltr" required="" class="form-control num-f" autocomplete="off" id="sell_price" name="sell_price">
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col-md-2 required"><label class="form-label text-muted">تاریخ</label></div>
                                                        <div class="col-md-10">
                                                            <input type="text" required="" id="date" name="date" class="form-control tooltips date" data-placement="top" title="" data-rel="tooltip" data-original-title="این فیلد لازمی هست" autocomplete="off">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-12 mt-4">
                                                    <label class="form-label text-muted">توضیحات</label>
                                                    <textarea type="text" name="note" class="form-control" autocomplete="off"></textarea>
                                                </div>

                                                <div class="d-grid gap-2 mt-3">
                                                    <button class="btn btn-secondary btn-block border p-2" type="submit">ثبت  نرخ اسعار</button>
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
                                    <h5 class="text-start lalezar text-muted mb-3 ms-3">نرخ اسعار</h5>
                                    <div class="overflow-auto">
                                    <table id="datatable2" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>شماره</th>
                                                <th>از واحد پول</th>
                                                <th>به واحد پول</th>
                                                <th>مقدار عددی واحد</th>
                                                <th>خرید </th>
                                                <th>فروش</th>
                                                <th>تاریخ</th>
                                                <th>توضیحات</th>
                                                <th>کاربر</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            <?php
                                                   if($view_data->rowCount() > 0 ) {
                                                    foreach ($view_data as $rows) {

                                                        echo '
                                                            <tr class="active">
                                                                <td class = ""> ' . ($count++) . ' </td>
                                                                <td class = ""> ' . get_column_value('currencies',$rows['currency_from_id'],'name') . ' </td>
                                                                <td class = ""> ' . get_column_value('currencies',$rows['currency_to_id'],'name') . ' </td>
                                                                <td class = ""> ' . $rows['amount_transaction'] . ' </td>
                                                                <td class = "recive_money"> ' . $rows['buy_price'] . ' </td>
                                                                <td class = "send_money"> ' . $rows['sell_price'] . ' </td>
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

        function get_currency_rate ( from_id , to_id ){
            if(from_id != '' && to_id != ''){

                $.ajax({
                    url      :"ajax.php",
                    method   : "post",
                    data     : {
                        from_id,
                        to_id,
                        type : "is_currncy_rate_exist"
                    },success:function (response) {
                        if ( response != 'false' ){
                            let data = JSON.parse(response);
                            $("#buy_price").val(data.buy_price);
                            $("#sell_price").val(data.sell_price);
                            $("#amount_transaction").val(data.amount_transaction);
                            $("#note").val(data.note);
                        }else {
                            $("#amount_transaction").val('');
                            $("#buy_price").val('');
                            $("#sell_price").val('');
                            $("#note").val('');
                        }
                    }
                });

            }

        }


    </script>

</body>

</html>