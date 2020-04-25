<?php

session_start();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link  type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
    <link  type="text/css" rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome.min.css">
    <link rel="stylesheet" type="text/css" href="MaterialDesign-Webfont-master/MaterialDesign-Webfont-master/css/materialdesignicons.min.css">

    <title>Admin Login</title>
</head>
<body>

<div class="container-fluid">
    <div class="row ">

        <div class="container col-xs-12 col-sm-12 col-md-7 offset-1 col-lg-7 offset-1 flex-column mt-5">
            <form class="p-3" method="post" action="processor.php?action_to_perform=login_admin">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3 offset-md-5 col-lg-4 offset-lg-4 text-center mt-5">
                        <img src="img/englishuk-south-logo-square.jpg" class="img-fluid rounded-circle mt-5 ">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 offset-2 mt-5 mb-4">
                        <h3 class="text-white font-weight-bold ">ADMIN LOGIN</h3>
                    </div>

                    <?php if(isset($_SESSION['error_array'])){ ?>
                        <div class="col-xs-12 offset-xs-0 col-sm-12 offset-sm-0 col-md-12 col-lg-12 alert alert-danger text-center mt-5">
                            <?php //print_r($_SESSION['error_array']); ?>
                            <?php foreach($_SESSION['error_array'] as $k => $error){ ?>

                                <p><?php echo $error; ?></p>

                            <?php } ?>
                        </div>
                    <?php } ?>

                    <?php if(isset($_GET['success'])){ ?>
                        <div class="col-xs-12 offset-xs-0 col-sm-12 offset-sm-0 col-md-12 col-lg-12 alert alert-success text-center mt-5">

                            <p><?php echo $_GET['success']; ?></p>

                        </div>
                    <?php } ?>

                    <?php if(isset($_GET['error'])){ ?>
                        <div class="col-xs-12 offset-xs-0 col-sm-12 offset-sm-0 col-md-12 col-lg-12 alert alert-danger text-center mt-5">

                            <p><?php echo $_GET['error']; ?></p>

                        </div>
                    <?php } ?>

                    <div class="col-xs-12 col-sm-12 col-md-8 offset-md-2 col-lg-8 offset-lg-2 form-group text-white ">
                        <i class="mdi mdi-email"></i>
                        <label>Email</label>
                        <input name="login_email" class="form-control text-white bg-transparent border-bottom border-primary" type="text" placeholder="Email">
                    </div>



                    <div class="col-xs-12 col-sm-12 col-md-8 offset-md-2 col-lg-8 offset-lg-2form-group text-white ">
                        <i class="mdi mdi-textbox-password"></i>
                        <label>Password</label>
                        <input name="login_password" class="form-control bg-transparent border-bottom border-primary text-white " type="password" placeholder="Password">
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 text-right mt-3">
                        <a href="register.php" class="text-white">Not an Admin? Register</a>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-8 offset-md-2 col-lg-8 offset-lg-2 form-group mt-5">
                        <button name="login_submit"  type="submit" class="btn-primary form-control" >Login</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 bg-primary pt-5 side_bar">

            <div class="col-xs-12 col-sm-12 col-md-6 offset-md-3 col-lg-6 offset-lg-3 text-center mt-5">
                <img src="img/englishuk-south-logo-square.jpg" class="img-fluid rounded-circle mt-5 ">
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center mt-5">
                <h5 class="text-white font-weight-bold ">SOUTH ENGLISH SCHOOL</h5>
                <h6 class="text-white">Qualitative education for all</h6>

                <button type="button" class="mt-3 bg-transparent border-white rounded-pill text-white">Visit our Website</button>
            </div>


        </div>
    </div>
</div>


</body>
<script type="text/javascript" src="js/jquery_3_4_1.js"></script>

<script type="text/javascript" src="js/bootstrap.min.js"></script>
</html>
