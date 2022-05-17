
<!DOCTYPE html>
<html lang="pe" dir="rtl">

<head>
    <?php require_once "_head.php" ?>
</head>
<?php require_once('alert.php');?>
<body>
  <div class="container-fluid">
    <?php require_once "_header.php" ?>

    
            <section class="row">
              <?php require_once "_sidebar.php" ?>
            


      <div class="col-md-10 ps-4 pe-4 mt-4 ">
        <div class="row">
          <div class="col-md-12">
            <h2 class="lalezar text-muted">گذارش خرید و فروش                 <i class="far pr fa-eye ms-2 h5 pointer togg"></i>
                <i class="far pr fa-eye-slash ms-2 h5 pointer priv togg"></i>
            </h2>
          </div>

          <div class="col-md-12 mt-3 pe-4 ps-4">
            <div class="row">
              <div class="card">
                <div class="card-body">
                  <div class="align-items-center row">
                    <div class="col">
                      <h5 class="text-start lalezar text-muted mb-2">گذارش</h5>
                      <div class="row mb-4">
                        <!-- buy form start -->
                        <div class="col-1">
                          <label class="mb-2">نوعیت</label>
                          <div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                              <label class="form-check-label" for="flexCheckDefault">
                                خرید
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
                              <label class="form-check-label" for="flexCheckChecked">
                                فروش
                              </label>
                            </div>
                            </div>
                          </div>
                        <div class="col">
                          <label class="mb-2" for="">از پول</label>
                          <select multiple data-placeholder="انتخاب ارز">
                            <option>افغانی</option>
                            <option selected>دالر</option>
                            <option>تومان</option>
                            <option>کلدار</option>
                            <option>یورو</option>
                          </select>
                        </div>
                        <div class="col">
                          <label class="mb-2" for="">به پول</label>
                          <select multiple2 data-placeholder="انتخاب ارز">
                            <option>افغانی</option>
                            <option>دالر</option>
                            <option>تومان</option>
                            <option>کلدار</option>
                            <option>یورو</option>
                          </select>
                        </div>
                        <div class="col">
                          <label class="mb-2" for="">از تاریخ</label>
                          <div>
                          <input type="text" autocomplete="off" class="form-control">
                          </div>
                        </div>
                        <div class="col">
                          <label class="mb-2" for="">از تاریخ</label>
                          <div>
                          <input type="text" autocomplete="off" class="form-control">
                          </div>
                        </div>
                        <div class="col" style="padding-top:2.3rem">
                            <button type="submit" class="pointer btn btn-secondary w-13 align-self-center">جستجو </button>
                        </div>
                      
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
                  <h5 class="text-start lalezar text-muted mb-3 ms-3">معاملات</h5>
                  <table id="datatable2" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th class="center bfont">شماره</th>
                                <th class="center bfont">نام کامل</th>
                                <th class="center bfont">نام کاربری</th>
                                <th class="center bfont">شماره تماس</th>
                                <th class="center bfont">توضیحات</th>
                                <th class="center bfont">تاریخ </th>
                                <th class="center bfont">عملیات</th>
                            </tr>
                        </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>حمید</td>
                        <td>افغانی</td>
                        <td>98</td>
                        <td>بابت خرید تومن</td>
                        <td>1400،عقرب 27</td>
                        <td>دالر</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>حمید</td>
                        <td>افغانی</td>
                        <td>98</td>
                        <td>بابت خرید تومن</td>
                        <td>1400،عقرب 27</td>
                        <td>دالر</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>حمید</td>
                        <td>افغانی</td>
                        <td>98</td>
                        <td>بابت خرید تومن</td>
                        <td>1400،عقرب 27</td>
                        <td>دالر</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>حمید</td>
                        <td>افغانی</td>
                        <td>98</td>
                        <td>بابت خرید تومن</td>
                        <td>1400،عقرب 27</td>
                        <td>دالر</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>حمید</td>
                        <td>افغانی</td>
                        <td>98</td>
                        <td>بابت خرید تومن</td>
                        <td>1400،عقرب 27</td>
                        <td>دالر</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>حمید</td>
                        <td>افغانی</td>
                        <td>98</td>
                        <td>بابت خرید تومن</td>
                        <td>1400،عقرب 27</td>
                        <td>دالر</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>حمید</td>
                        <td>افغانی</td>
                        <td>98</td>
                        <td>بابت خرید تومن</td>
                        <td>1400،عقرب 27</td>
                        <td>دالر</td>
                    </tr>
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
  </section>
  </div>
 <?php require_once "_script.php"  ?>
</body>

</html>