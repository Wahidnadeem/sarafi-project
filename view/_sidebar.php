<div class="d-none d-lg-block col-lg-2 bg-white p-0 sidebar">
    <ul class="mt-5 pt-5 pb-5 pe-0 ps-0">
        
            <div class="sidebar-border ">
                <a href="index.php">
                    <li class="<?php echo ( !empty($menu) && $menu == "index" ) ? "onpage" : '' ?>">
                        <i class="fas fa-home me-3"></i> خانه
                    </li>
                </a>
            </div>

            <div class="sidebar-border">
                <li class="ulpr <?php echo ( !empty($menu) && $menu == "transaction" ) ? "onpage" : '' ?> ">
                    <i class="fas fa-poll-h me-3"></i> روزنامچه
                </li>

                <ul class="ps-4 pt-2 nstul <?php echo ( !empty($menu) && $menu == "transaction" ) ? '' : 'd-none' ?> ">
                    <a href="buy_sell.php">
                        <li class="mb-2  <?php echo ( !empty($submenu) && $submenu == "buy_sell" ) ? 'bg-light dark' : '' ?> ">
                            <i class="fas fa-credit-card me-3"></i> خرید و فروش
                        </li>
                    </a>
                    <a href="transcation.php">
                        <li class="mb-2 <?php echo ( !empty($submenu) && $submenu == "account_transaction" ) ? 'bg-light dark' : '' ?> ">
                            <i class="fas fa-sync-alt me-3"></i> رسید و برد
                        </li>
                    </a>
                </ul>

            </div>


            <div class="sidebar-border">
                <li class="ulpr2 <?php echo ( !empty($menu) && $menu == "constant" ) ? "onpage" : '' ?> ">
                    <i class="fas fa-pen-nib me-3"></i> ثابت ها
                </li>

                <ul class="ps-4 pt-2 nstul2  <?php echo ( !empty($menu) && $menu == "constant" ) ? "" : 'd-none' ?> ">
                    <a href="currency_rate.php">
                        <li class="mb-2 <?php echo ( !empty($submenu) && $submenu == "currency_rate" ) ? "bg-light dark" : '' ?> ">
                            <i class="fas fa-money-bill me-3"></i> ثبت   نرخ اسعار
                        </li>
                    </a>
                    <a href="add_account.php">
                        <li class="mb-2 <?php echo ( !empty($submenu) && $submenu == "add_account" ) ? "bg-light dark" : '' ?> ">
                            <i class="fas fa-user-plus me-3"></i> ثبت حساب
                        </li>
                    </a>

                    <a href="add_special_account.php">
                        <li class="mb-2 <?php echo ( !empty($submenu) && $submenu == "addـspecial_account" ) ? "bg-light dark" : '' ?> ">
                        <i class="fas fa-user-tie me-3"></i>  ثبت حساب خاص
                        </li>
                    </a>
                    
                </ul>

            </div>

            <div class="sidebar-border">

                <li class="ulpr3 <?php echo ( !empty($menu) && $menu == "report" ) ? "onpage" : '' ?> ">
                    <i class="fas fa-chart-pie me-3"></i> گزارشات
                </li>

                <ul class="ps-4 pt-2 nstul3 <?php echo ( !empty($menu) && $menu == "report" ) ? "" : 'd-none' ?> ">
                    <a href="report_buy_sell.php">
                        <li class="mb-2 <?php echo ( !empty($submenu) && $submenu == "buy_sell_report" ) ? "bg-light dark" : '' ?> ">
                            <i class="fas fa-money-check-alt me-3"></i> خرید و فروش
                        </li>
                    </a>
                    <a href="report_transcation.php">
                        <li class="mb-2 <?php echo ( !empty($submenu) && $submenu == "transaction_report" ) ? "bg-light dark" : '' ?> ">
                            <i class="fas fa-share-square me-3"></i> رسید و برد
                        </li>
                    </a>
                    <a href="report_benefit.php">
                        <li class="mb-2 <?php echo ( !empty($submenu) && $submenu == "report_benefit" ) ? "bg-light dark" : '' ?> ">
                            <i class="fas fa-comment-dollar me-3"></i> مفاد
                        </li>
                    </a>
                    <a href="report_customer.php">
                        <li class="mb-2 <?php echo ( !empty($submenu) && $submenu == "report_customer" ) ? "bg-light dark" : '' ?> ">
                        <i class="fas fa-address-card me-3"></i>   بیلانس  مشتریان 
                        </li>
                    </a>
                    <a href="report_general_account.php">
                        <li class="mb-2 <?php echo ( !empty($submenu) && $submenu == "general_account" ) ? "bg-light dark" : '' ?> ">
                        <i class="fas fa-chart-area me-3"></i>  خلاصه بیلانس کل
                        </li>
                    </a>
                </ul>

            </div>

            <div class="sidebar-border">
            <a href="add_user.php">
                <li class="<?php echo ( !empty($menu) && $menu == "users" ) ? "onpage" : '' ?>">
                    <i class="fas fa-user-edit me-3"></i> مدیریت کاربران
                </li>
            </a>

            </div>

    </ul>
</div>
