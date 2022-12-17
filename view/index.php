<?php 
require_once("_config.php");
    
    $view_data = $db->query("SELECT * FROM `account_transaction` WHERE deleted = '0' ORDER BY id DESC LIMIT 5"); 

    $buy_data  = $db->query("SELECT * FROM `buy_sell` WHERE deleted =  '0' ORDER BY id DESC LIMIT 5");

        $each_currency_amount_string = '';
        $total_blance_in_usd = 0;
        $count = 1;     
        foreach (select_all('master_balance') as $value) {

            if($count == 6)
                break;

            $currency_to_id = $value['currency_id'];
            if($currency_to_id == '2' ){
                $total_blance_in_usd += $value['amount'];
            }else {
                $rate                   = $db->query("SELECT `sell_price` FROM `currency_rate`WHERE currency_from_id = '2' and currency_to_id = '$currency_to_id' limit 1 ");
                $rate                   = ( $rate->rowCount() > 0  ) ? $rate->fetch()['sell_price'] : 0;
                $amount_in_usd          = ( $rate != 0  ) ?  $value['amount'] / $rate : $value['amount'] / 1 ; 
                $total_blance_in_usd    += $amount_in_usd;
            }


            $each_currency_amount_string .='
             <div class="col-xl col-md-6 col-12 mb-1">
                <div class="card">
                    <div class="card-body bg'.$count++.'">
                        <div class="align-items-center text-end row">
                            <div class="col">
                            <h6 class="text-start lalezar text-muted mb-2">'.get_column_value('currencies',$value['currency_id'],'name').'</h6>
                                <span class="mt-n1 me-2 pt-2 badge bg-success bg-opacity-75 h7">+0%</span>
                                <span class="h5 mb-0 togg fw-bold CurNumDiv '.$CURRENCY_ICON[$currency_to_id].'" dir="ltr"> '.$value['amount'].'</span>
                                <span class="h4 mb-0 togg priv">******</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            ';
        }



?>
<!DOCTYPE html>
<html lang="pe" dir="rtl">

<head>
    <?php 
    $title = 'خانه' ;
    require_once "_head.php"; ?>
</head>

<body>
    <div class="container-fluid">

        <?php require_once "_header.php" ?>

      
        <section class="row">

            <?php 
            $menu    = "index";
            require_once "_sidebar.php"; ?>
    
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10 ps-4 pe-4 mt-4 ">
                <div class="row">

                    <?php 
                        
                        $header_title = 'خانه';
                        require_once "_eye_icon.php";
                        ?>

                    <div class="col-md-12 mt-3">
                        <div class="row pb-3">
                        <?php  echo $each_currency_amount_string?>                    
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="row">
                            <div class="col-xl-9 col-md-9 col-12 mb-3">
                                <div class="card">
                                    <div class="card-body h17">
                                        <div class="align-items-center row">

                                            <div class="col">
                                                <h5 class="text-start lalezar text-muted pb-4">آمار و ارقام</h5>
                                                <div class="row mt-5 mb-2" >
                                                    <div class="col-xl col-md-6 col-12 mb-3 border-end">
                                                        <div class="row align-items-center row">
                                                            <div class="col-auto">
                                                                <img src="./assist/img/assit.png" alt="..."></div>
                                                            <div class="ms-n2 col">
                                                                <span class="h5 mb-1 togg CurNumDiv DollarSign currSign <?php echo  ( $total_blance_in_usd < 0  ) ? 'send_money' : ''  ?> " dir="ltr"><?php echo $total_blance_in_usd?></span>
                                                                <span class="h4 mb-0 togg priv">******</span>
                                                                <p class="small text-muted card-text">کل سرمایه</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl col-md-6 col-12 mb-3 border-end">
                                                        <div class="row align-items-center row">
                                                            <div class="col-auto">
                                                                <img src="./assist/img/assit3.png" alt="..."></div>
                                                            <div class="ms-n2 col">

                                                                <span class="h5 mb-1 togg CurNumDiv">
                                                                <?php
                                                                    echo select_all('accounts')->rowCount() + 0 ;
                                                                ?>
                                                                </span>

                                                                <span class="h4 mb-0 togg priv">******</span>
                                                                <p class="small text-muted card-text">مشتری ها</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl col-md-6 col-12 mb-3">
                                                        <div class="row align-items-center row">
                                                            <div class="col-auto">
                                                                <img src="./assist/img/assit2.png" alt="..."></div>
                                                            <div class="ms-n2 col">
                                                                <span class="h5 mb-1 togg CurNumDiv DollarSign currSign"> <?php echo  get_column_value('master_balance',10,'amount') + 0 ;  ?> </span>
                                                                <span class="h4 mb-0 togg priv">******</span> 
                                                                <p class="small text-muted card-text">مفاد</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row ms-3 me-3 bg-light rounded-lg" style="border-radius: 0.6rem;">
                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-3 col-12 mb-1">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="align-items-center row">

                                            <div class="col">
                                                <h5 class="text-start lalezar text-muted ">توضیح دارایی</h5>
                                                <div class="row  mb-1">
                                                    <div id="cont2" style="width:100%; height: 217px;"></div>
                                                </div>
                                            </div>

                                            <?php
                                            
                                                $master_blanse_data = select_all('master_balance');
                                                $total_doller  = 0;
                                                $currency_array = [];

                                                foreach ($master_blanse_data as $key => $value) {

                                                    if($value['amount'] < 0 ){
                                                        continue;
                                                    }
                                                    
                                                    
                                                    $currency_id    = $value['currency_id'];
                                                    $currency_rate  = $db->query("SELECT `sell_price` , `amount_transaction` FROM `currency_rate` WHERE currency_from_id = '2' AND currency_to_id = '$currency_id'  ");
                                                    $currency_rate_value    = 1;
                                                    $amount_transaction     = 1;
                                                    
                                                    if($currency_rate->rowCount() > 0 ){
                                                        
                                                        $currency_rate_row      = $currency_rate->fetch();
                                                        $currency_rate_value    = $currency_rate_row['sell_price'];
                                                        $amount_transaction     = $currency_rate_row['amount_transaction'];
                                                        
                                                    } 


                                                    if($value['currency_id'] == 2){
                                                        $currency_array[$value['currency_id']] = $value['amount'];
                                                        $temp = $value['amount'];
                                                    }else {
                                                        $temp = $value['amount']  / ( $currency_rate_value * $amount_transaction );
                                                        $currency_array[$value['currency_id']] = $temp;
                                                    }

                                                    $total_doller += $temp;
                                                }


                                                $currency_persent = [];
                                                $total_doller = ($total_doller == 0 ) ? 1 : $total_doller;
                                                foreach ($currency_array as $key => $value) {

                                                    if ($total_doller > 0) {
                                                        $currency_persent[$key] = ( ( $value * 100 ) / $total_doller );
                                                    }else{
                                                        $currency_persent[$key] = ( ( $value * 100 ) / 1 );
                                                    }
                                                    
                                                }
                                                
                                                
                                            ?>

                                            <script>
                                                
                                                document.addEventListener("DOMContentLoaded", function() {
                                                var chart1 = new Highcharts.Chart({
                                                    chart: {
                                                    type: 'pie',
                                                    renderTo: 'cont2'
                                                    },
                                                    title: {
                                                    verticalAlign: 'middle',
                                                    floating: true,
                                                    text: ' '
                                                    },
                                                    plotOptions: {
                                                    pie: {
                                                        innerSize: '60%',
                                                        allowPointSelect: true,
                                                        cursor: 'pointer',
                                                        dataLabels: {
                                                        enabled: false
                                                        },
                                                        showInLegend: false
                                                    }
                                                    },

                                                    series: [{
                                                        data: [
                                                                ['دالر',    <?php echo ( !empty($currency_persent[2]) ) ? number_format($currency_persent[2],2) : 0 ?>],
                                                                ['افغانی',  <?php echo ( !empty($currency_persent[1]) ) ? number_format($currency_persent[1],2) : 0 ?>],
                                                                ['تومان',   <?php echo ( !empty($currency_persent[3]) ) ? number_format($currency_persent[3],2) : 0 ?>],
                                                                ['یورو',    <?php echo ( !empty($currency_persent[5]) ) ? number_format($currency_persent[5],2) : 0 ?>],
                                                                ['کالدار',  <?php echo ( !empty($currency_persent[4]) ) ? number_format($currency_persent[4],2) : 0 ?>]
                                                            ]
                                                        }]
                                                    });

                                                });

                                            </script>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 mt-4">

                                <div class="card ">
                                    <div class="card-body" >
                                        <div class="row pt-2 ">
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 lalezar text-muted h5" > <span id="account_name_div"> </span>  </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <select class="form-control select2" onchange="get_account_data()"  id="search_account_div" name="search_account_div">
                                                <option  value="">حساب را انتخاب کنید</option>
                                                <?php 
                                                    
                                                    $rand  = $db->query("SELECT id FROM `accounts` WHERE deleted = 0 ORDER BY RAND ( )LIMIT 1");
                                                    if($rand->rowCount() > 0 ){
                                                        $rand  = $rand->fetch()['id'];
                                                    }else {
                                                        $rand = 0;
                                                    }
                                                    
                                                    $search_account = $db->query("SELECT * FROM `accounts` WHERE `deleted` = '0' order by id desc  ");
                                                    foreach ($search_account as $rows){
                                                        if($rand == $rows['id']){
                                                            echo '<option selected value="'.$rows['id'].'"> '.$rows['first_name'].' '.$rows['last_name'].' - '.$rows['account_code'].' </option>';
                                                        }else {
                                                            echo '<option value="'.$rows['id'].'"> '.$rows['first_name'].' '.$rows['last_name'].' - '.$rows['account_code'].' </option>';
                                                        }
                                                    }

                                                   ?>
                                             </select>
                                            </div>
                                            <div class="col-4"></div>
                                        </div>
                                        <div class="row mt-3">
                                            <!-- <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 ">
                                                <div class="row p-3"  style='
                                                    background-image: url("assist/img/em.png");
                                                    background-repeat: no-repeat;
                                                    background-position: center center;
                                                    background-size: cover;
                                                    height: 35rem;
                                                    '>
                                                    
                                                </div>
                                            </div> -->

                                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 ">
                                                <div class="row p-3">
                                                    <div class="col-12 bg-light rounded-3 p-3">
                                                        <h5 class="text-start lalezar text-muted pb-3">آخرین معاملات</h5>
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
                                                            <tbody id="add_tr_id_div">
                                                            </tbody>
                                                        </table>
                                                        <div class="d-grid gap-2" id="short_account_report">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                                <div class="row p-3">

                                                    <div class="col-12 bg-light rounded-3 p-4">
                                                        <h5 class="text-start lalezar text-muted ">بالانس عمومی</h5>
                                                        <span id="total_blance">
                                                            
                                                        </span>
                                                    </div>

                                                </div>
                                            </div>

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
        <!-- side bar -->
        
    </div>
    
    <?php require_once "_script.php"  ?>

    <script>
         
        get_account_data();

        function get_account_data (){
            var account_id = $("#search_account_div").val();
            if(account_id != ''){
                $.ajax({
                    url:"ajax.php",
                    method:"post",
                    data:{
                        account_id:account_id,
                        type:'getDetailsAccountBalance_index'
                    },
                    success:function(response){
                        var datas = response.split('##');
                        $("#account_name_div").html(datas[0]);
                        $("#add_tr_id_div").html(datas[1]);
                        $("#total_blance").html(datas[2]);
                        

                        
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




    </script>
</body>

</html>