<?php

    require_once("_config.php");
    
    if(!isset($_GET['id'])){
        header("location: buy_sell.php?error");
        exit(); 
    }


    $row_id  = base64_decode($_GET['id']);
    $row     = select_one('buy_sell',$row_id);

    if(!is_array($row)){
        header("location: buy_sell.php?error");
        exit();
    }

    $currency_from_id = $row['currency_from_id'];
    $currency_to_id = $row['currency_to_id'];
    $amount_transaction = $db->query("SELECT amount_transaction FROM currency_rate WHERE currency_from_id = $currency_from_id AND currency_to_id = $currency_to_id ORDER BY id DESC LIMIT 1 ");

    $amount_transaction  = ($amount_transaction->rowCount() > 0 ) ? $amount_transaction->fetch()['amount_transaction'] : 1;
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
                                            <h5 class="text-start lalezar text-muted mt-2 mb-2">ویرایش خرید و فروش</h5>
                                            <div class="row mt-4 mb-4">
                                                <!-- buy form start -->
                                                <div class="col-xl-12 col-md-8 col-sm-12">
                                                    <div class="row g-3 p-3">
                                                        <div class="tab-content" id="nav-tabContent">
                                                            
                                                        <!-- start buy from   -->
                                                            <div class="tab-pane ms-4 me-4 mt-3 show active" id="nav-buy" role="tabpanel" aria-labelledby="nav-buy-tab">
                                                                
                                                                <form action="action_buy_sell.php" method="POST" class="currency_validate trade-form row g-3">
                                                                        
                                                                    <input type="hidden" value="1" name="edit" >
                                                                    <input type="hidden" value="<?php echo base64_encode($row_id)?>" name="row_id" >
                                                            
                                                                    <div class="row">

                                                                        <label class="form-check-label text-muted required">
                                                                            نوعیت
                                                                        </label>
                                                                        
                                                                        <div class="col-md-2 mt-2">       
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" value="buy" type="radio" name="type" id="buy_type" <?php if($row['type'] == "buy")  echo "checked" ?> >
                                                                                <label class="form-check-label" for="buy_type">
                                                                                    خرید    
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-10 mt-2">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" value="sell" type="radio" name="type" id="sell_type" <?php if($row['type'] == "sell")  echo "checked" ?>>
                                                                                <label class="form-check-label" for="sell_type">
                                                                                    فروش
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                            

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
                                                                            <?php
                                                                                foreach (get_currency_options() as  $value) {
                                                                                    if ( $value['id'] == $row['currency_from_id'] )
                                                                                        echo '<option selected value="'.$value['id'].'"> '.$value['name'].' </option>';
                                                                                    else 
                                                                                        echo '<option value="'.$value['id'].'"> '.$value['name'].' </option>';
                                                                                }
                                                                            ?>
                                                                            </select>
                                                                            <input type="text" dir="ltr" step="any" onkeyup="calculate_rate(currency_from_amount.value,'#currency_to_amount',rate.value,'amount_transaction','buy');" name="currency_from_amount" id="currency_from_amount" value="<?php if(isset($row['currency_from_amount'])) echo $row['currency_from_amount'] ?>" required="" class="form-control num-f " autocomplete="off">
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
                                                                                <?php
                                                                                    foreach (get_currency_options() as  $value) {
                                                                                        if ( $value['id'] == $row['currency_to_id'] )
                                                                                            echo '<option selected value="'.$value['id'].'"> '.$value['name'].' </option>';
                                                                                        else 
                                                                                            echo '<option value="'.$value['id'].'"> '.$value['name'].' </option>';
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        <input type="text" required dir="ltr" step="any" value="<?php if(isset($row['currency_to_amount'])) echo $row['currency_to_amount'] ?>" name="currency_to_amount" id="currency_to_amount" placeholder="0.0" class="form-control num-f" autocomplete="off"></div>
                                                                    </div>

                                                                    <div class="col-12 mt-4">
                                                                        <div class="row mt-3">
                                                                            <div class="col-md-2"><label class="form-label text-muted required">نرخ</label></div>
                                                                            <div class="col-md-10">
                                                                                <input type="number" onkeyup="calculate_rate(currency_from_amount.value,'#currency_to_amount',rate.value,'amount_transaction','buy');" value="<?php if(isset($row['rate'])) echo $row['rate'] ?>" step="any" required name="rate" id="rate" placeholder="0.0" class="form-control" autocomplete="off">
                                                                                <input type="hidden" id="amount_transaction" value="<?php echo $amount_transaction ?>" >
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
                                                                            <a href="buy_sell.php">بازگشت <i class="fas fa-undo-alt"></i></a>
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
                                                                                    

</body>

</html>