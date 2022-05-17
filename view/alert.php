
 <span class="fixed-top mt-1 ms-5">
    <?php if(isset($_GET['deleted'])) {?>
        <div class="row fadeout">
            <div class="col-3">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>تبریک</strong> حذف انجام شد
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <?php } if(isset($_GET['edit'])) {?>
        <div class="row fadeout">
            <div class="col-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>تبریک</strong> ویرایش انجام شد
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <?php } if(isset($_GET['error'])) {?>
        <div class="row fadeout">
            <div class="col-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>متاسفانه</strong>  عملیه انجام نشد
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
         <?php } if(isset($_GET['saved'])) {?>
        <div class="row fadeout">
            <div class="col-3">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>تبریک</strong> ذخیره انجام شد
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php } if(isset($_GET['has_account'])) { ?>

        <div class="row fadeout">
            <div class="col-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>متاسفم</strong> حسابات پولی دارد !
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php } ?>

<?php if(isset($_GET['users'])) { ?>

        <div class="row fadeout">
            <div class="col-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>متاسفم</strong> با این کاربر لاگین هستید !
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if(isset($_GET['notuser'])) { ?>

        <div class="row fadeout">
            <div class="col-4" style="position: relative;right: 10px;top:10px">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>متاسفم</strong> نام کاربری و یا رمز کاربری اشتباه میباشد !
                </div>
            </div>
        </div>
    <?php } ?>

    </span>
