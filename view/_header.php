<!-- top bar -->
<?php 
    require_once ('_config.php');
    $user_row = $db->query("SELECT * FROM users where id  = $user_id")->fetch();

?>
<div class="row"> 
    <div class="col-md-12 bg-white">
        <header class="row">
            <div class="d-none d-md-block col-md-4 ps-5 mt-6 ">
                <div class="dropdown text-muted ps-3 pe-3 pt-2 pb-2 rounded-3">
                    <a class="currency_rate.php" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="bg-light rounded-3 text-muted ps-3 pe-3 pt-1 pb-1 AfgSign">
                            <?php
                                $usd_irr = $db->query("SELECT * FROM currency_rate WHERE `currency_from_id` = '2' AND `currency_to_id` = '1' AND `deleted` = '0' limit 1")->fetch();

                            if ($usd_irr) {
                                    echo $usd_irr['sell_price'];   
                                }else{
                                    echo 0;
                                            }
                                ?> 
                        </span>
                        <img class="ps-2" src="./assist/img/img1.png" width="40rem" alt="dollar-afghani">   
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li>
                            <a href="index.php">
                                <div class="d-flex justify-content-between ps-1 pe-1">
                                    <span class=" text-muted  pt-1 pb-1 TomanSign">
                                        <?php
                                                $usd_irr = $db->query("SELECT * FROM currency_rate WHERE `currency_from_id` = '2' AND `currency_to_id` = '3' AND `deleted` = '0' limit 1")->fetch();

                                            if ($usd_irr) {
                                                    echo $usd_irr['sell_price'];   
                                                }else{
                                                    echo 0;
                                                            }
                                            ?> 
                                    </span>
                                    <img class="ps-2" src="./assist/img/img3.png" width="60rem"  alt="dollar-afghani"> 
                                </div>
                            </a>
                        </li>
                        
                        <li>
                        <a href="index.php">
                            <div class="d-flex justify-content-between ps-1 pe-1">
                                <span class=" text-muted  pt-1 pb-1 AfgSign">
                                    <?php
                                            $usd_irr = $db->query("SELECT * FROM currency_rate WHERE `currency_from_id` = '3' AND `currency_to_id` = '1' AND `deleted` = '0' limit 1")->fetch();

                                        if ($usd_irr) {
                                                echo $usd_irr['sell_price'];   
                                            }else{
                                                echo 0;
                                                        }
                                        ?> 
                                </span>
                                <img class="ps-2" src="./assist/img/img4.png" width="60rem" alt="dollar-afghani">
                            </div>
                            </a>
                        </li>
                        
                        <li>
                        <a href="index.php">
                            <div class="d-flex justify-content-between ps-1 pe-1">
                                <span class=" text-muted pt-1 pb-1 AfgSign">
                                    <?php
                                            $usd_irr = $db->query("SELECT * FROM currency_rate WHERE `currency_from_id` = '4' AND `currency_to_id` = '1' AND `deleted` = '0' limit 1")->fetch();

                                        if ($usd_irr) {
                                                echo $usd_irr['sell_price'];   
                                            }else{
                                                echo 0;
                                                        }
                                        ?> 
                                </span>
                                <img class="ps-2" src="./assist/img/img5.png" width="60rem" alt="dollar-afghani">
                            </div>
                            </a>
                        </li>
                        
                        <li>
                        <a href="index.php">
                            <div class="d-flex justify-content-between ps-1 pe-1">
                                <span class=" text-muted pt-1 pb-1 AfgSign">
                                    <?php
                                            $usd_irr = $db->query("SELECT * FROM currency_rate WHERE `currency_from_id` = '5' AND `currency_to_id` = '1' AND `deleted` = '0' limit 1")->fetch();

                                        if ($usd_irr) {
                                                echo $usd_irr['sell_price'];   
                                            }else{
                                                echo 0;
                                                        }
                                        ?>
                                </span>
                                <img class="ps-2" src="./assist/img/img6.png" width="60rem" alt="dollar-afghani">  
                            </div>
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                <img src="./assist/img/img2.png" alt=""></div>
            <div class="d-none d-md-block col-md-4 pe-5 mt-6">
                <div class="dropdown bg-light text-muted ps-3 pe-3 pt-2 pb-2 rounded-3 float-end">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                      <?php if (!empty($user_row['username'])) {
                          echo $user_row['username'];  
                        } ?>
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="edit_user.php?id=<?php
                        if(!empty($user_row['id'])){
                         echo base64_encode(@$user_row['id']);
                        } ?>">تنظیمات</a></li>
                        <li><a class="dropdown-item" href="logout.php">خروج</a></li>
                    </ul>
                </div>
            </div>
        </header>
        <div class="d-block d-sm-none d-md-none d-lg-none col-12">
            <dov class="row">
                <div class="col-4">
                <nav class="navbar navbar-expand-lg navbar-light ">
                    <div class="container-fluid">
                        <button class="navbar-toggler bg-light border-0 pt-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent2">
                            <ul class="mt-5 pt-5 pb-5 pe-0 ps-0">
                                
                                    <div class="sidebar-border ">
                                        <a href="index.php">
                                            <li class="<?php echo ( !empty($menu) && $menu == "index" ) ? "onpage" : '' ?>">
                                                 خانه
                                            </li>
                                        </a>
                                    </div>

                                    <div class="sidebar-border">
                                        <li class="ulpr <?php echo ( !empty($menu) && $menu == "transaction" ) ? "onpage" : '' ?> ">
                                             روزنامچه
                                        </li>

                                        <ul class="ps-4 pt-2 nstul <?php echo ( !empty($menu) && $menu == "transaction" ) ? '' : 'd-none' ?> ">
                                            <a href="buy_sell.php">
                                                <li class="mb-2  <?php echo ( !empty($submenu) && $submenu == "buy_sell" ) ? 'bg-light dark' : '' ?> ">
                                                     خرید و فروش
                                                </li>
                                            </a>
                                            <a href="transcation.php">
                                                <li class="mb-2 <?php echo ( !empty($submenu) && $submenu == "account_transaction" ) ? 'bg-light dark' : '' ?> ">
                                                     رسید و برد
                                                </li>
                                            </a>
                                        </ul>

                                    </div>


                                    <div class="sidebar-border">
                                        <li class="ulpr2 <?php echo ( !empty($menu) && $menu == "constant" ) ? "onpage" : '' ?> ">
                                             ثابت ها
                                        </li>

                                        <ul class="ps-4 pt-2 nstul2  <?php echo ( !empty($menu) && $menu == "constant" ) ? "" : 'd-none' ?> ">
                                            <a href="currency_rate.php">
                                                <li class="mb-2 <?php echo ( !empty($submenu) && $submenu == "currency_rate" ) ? "bg-light dark" : '' ?> ">
                                                     ثبت   نرخ اسعار
                                                </li>
                                            </a>
                                            <a href="add_account.php">
                                                <li class="mb-2 <?php echo ( !empty($submenu) && $submenu == "add_account" ) ? "bg-light dark" : '' ?> ">
                                                     ثبت حساب
                                                </li>
                                            </a>
                                        </ul>

                                    </div>

                                    <div class="sidebar-border">

                                        <li class="ulpr3 <?php echo ( !empty($menu) && $menu == "report" ) ? "onpage" : '' ?> ">
                                             گزارشات
                                        </li>

                                        <ul class="ps-4 pt-2 nstul3 <?php echo ( !empty($menu) && $menu == "report" ) ? "" : 'd-none' ?> ">
                                            <a href="report_buy_sell.php">
                                                <li class="mb-2 <?php echo ( !empty($submenu) && $submenu == "buy_sell_report" ) ? "bg-light dark" : '' ?> ">
                                                     خرید و فروش
                                                </li>
                                            </a>
                                            <a href="report_transcation.php">
                                                <li class="mb-2 <?php echo ( !empty($submenu) && $submenu == "transaction_report" ) ? "bg-light dark" : '' ?> ">
                                                     رسید و برد
                                                </li>
                                            </a>
                                        </ul>

                                    </div>

                                    <div class="sidebar-border">
                                    <a href="add_user.php">
                                        <li class="<?php echo ( !empty($menu) && $menu == "users" ) ? "onpage" : '' ?>">
                                             مدیریت کاربران
                                        </li>
                                    </a>

                                    </div>

                            </ul>
                        </div>
                    </div>
                </nav>
                </div>
                <div class="col-4">
                    <div class="dropdown text-muted ps-3 pe-3 pt-2 pb-2 rounded-3">
                        <a class="currency_rate.php" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="bg-light rounded-3 text-muted ps-3 pe-3 pt-1 pb-1 AfgSign">
                                <?php
                                    $usd_irr = $db->query("SELECT * FROM currency_rate WHERE `currency_from_id` = '2' AND `currency_to_id` = '1' AND `deleted` = '0' limit 1")->fetch();

                                if ($usd_irr) {
                                        echo $usd_irr['sell_price'];   
                                    }else{
                                        echo 0;
                                                }
                                    ?> 
                            </span>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li>
                                <div class="d-flex justify-content-between ps-1 pe-1">
                                    <span class=" text-muted  pt-1 pb-1 TomanSign">
                                        <?php
                                                $usd_irr = $db->query("SELECT * FROM currency_rate WHERE `currency_from_id` = '2' AND `currency_to_id` = '3' AND `deleted` = '0' limit 1")->fetch();

                                            if ($usd_irr) {
                                                    echo $usd_irr['sell_price'];   
                                                }else{
                                                    echo 0;
                                                            }
                                            ?> 
                                    </span>
                                    <img class="ps-2" src="./assist/img/img3.png" width="60rem"  alt="dollar-afghani"> 
                                </div>
                            </li>
                            
                            <li>
                                <div class="d-flex justify-content-between ps-1 pe-1">
                                    <span class=" text-muted  pt-1 pb-1 AfgSign">
                                        <?php
                                                $usd_irr = $db->query("SELECT * FROM currency_rate WHERE `currency_from_id` = '3' AND `currency_to_id` = '1' AND `deleted` = '0' limit 1")->fetch();

                                            if ($usd_irr) {
                                                    echo $usd_irr['sell_price'];   
                                                }else{
                                                    echo 0;
                                                            }
                                            ?> 
                                    </span>
                                    <img class="ps-2" src="./assist/img/img4.png" width="60rem" alt="dollar-afghani">
                                </div>
                            </li>
                            
                            <li>
                                <div class="d-flex justify-content-between ps-1 pe-1">
                                    <span class=" text-muted pt-1 pb-1 AfgSign">
                                        <?php
                                                $usd_irr = $db->query("SELECT * FROM currency_rate WHERE `currency_from_id` = '4' AND `currency_to_id` = '1' AND `deleted` = '0' limit 1")->fetch();

                                            if ($usd_irr) {
                                                    echo $usd_irr['sell_price'];   
                                                }else{
                                                    echo 0;
                                                            }
                                            ?> 
                                    </span>
                                    <img class="ps-2" src="./assist/img/img5.png" width="60rem" alt="dollar-afghani">
                                </div>
                            </li>
                            
                            <li>
                                <div class="d-flex justify-content-between ps-1 pe-1">
                                    <span class=" text-muted pt-1 pb-1 AfgSign">
                                        <?php
                                                $usd_irr = $db->query("SELECT * FROM currency_rate WHERE `currency_from_id` = '5' AND `currency_to_id` = '1' AND `deleted` = '0' limit 1")->fetch();

                                            if ($usd_irr) {
                                                    echo $usd_irr['sell_price'];   
                                                }else{
                                                    echo 0;
                                                            }
                                            ?>
                                    </span>
                                    <img class="ps-2" src="./assist/img/img6.png" width="60rem" alt="dollar-afghani">  
                                </div>
                            </li>
                            
                        </ul>
                    </div>
                </div>
                <div class="col-4">
                    <div class="dropdown bg-light text-muted ps-3 pe-3 pt-2 pb-2 rounded-3 float-end">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if (!empty($user_row['username'])) {
                          echo $user_row['username'];  
                        } ?>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="edit_user.php?id=<?php echo base64_encode(@$user_row['id']); ?>">تنظیمات</a></li>
                            <li><a class="dropdown-item" href="logout.php">خروج</a></li>
                        </ul>
                    </div>
                </div>
            </dov>
        </div>
    </div>
</div>
<!-- top bar -->