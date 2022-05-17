<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>ورود</title>
</head>
<?php require '../view/alert.php'; ?>
<body>
    <div class="container-fluid pt-2">
        <div class="row pt-3">
            <div class="col-xs-12 col-sm-2 col-md-3 col-lg-4"></div>
            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
                <div class="container">
                    <div class="row pt-5">
                        <div class="col-md-12 mt-3 mb-1 text-center">
                            <img src="images/Login.png" alt="">
                            <h2 class="mt-3 lalezar mt-5 mb-3">
                                ورود
                            </h2>
                            <p class="text-muted">برای ورود به سیستم نام کاربری و رمز کاربری خود را وارد نمایید</p>
                        </div>

                        <div class="col-md-12 mt-3">
                            <form class="p-5" action="is_login.php" method="post"  >
                                <div class="mb-3">
                                  <label for="exampleInputEmail1" class="form-label h5 text-muted lalezar">نام کاربری</label>
                                  <input type="text" name="username" class="form-control pt-2 pb-2 " id="exampleInputEmail1" aria-describedby="emailHelp" autofocus>
                                  <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                                </div>
                                <div class="mb-3">
                                  <label for="exampleInputPassword1" class="form-label h5 text-muted lalezar">رمز کاربری</label>
                                  <input type="password" name="password" class="form-control pt-2 pb-2" id="exampleInputPassword1">
                                </div>
                                <div class="mb-3 form-check">
                                  <!-- <input type="checkbox" class="form-check-input" id="exampleCheck1"> -->
                                  <!-- <label class="form-check-label" for="exampleCheck1">مرا به خاطر بسپار</label> -->
                                </div>
                                <div class="mt-5">
                                    <button type="submit" class="btn btn-primary lalezar w-100 pe-auto font1 pointer">ورود</button>
                                </div>
                              </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                        <a href="novavteam.tech" target="blanck">
                            <div class="mt-6 lalezar mt-12 mb-3 text-center">
                                    <span class="text-muted h4" style="font-weight: bold;">NovaVTeam 2022 &copy 
                                    </span>
                            </div>
                        </a>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-xs-12 col-sm-2 col-md-3 col-lg-4"></div>

            <!-- <div class="d-none d-md-block d-lg-block col-7 bg-dark bg-login" style="height: 100vh;">
            </div> -->
        </div>
    </div>
</body>
</html>