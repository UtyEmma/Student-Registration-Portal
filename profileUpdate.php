<?php require_once('processor.php'); ?>
<!--instatiate the class-->
<?php $obj = new processor(); ?>

<?php /*check for login*/ $obj->checkLogin('login.php'); ?>

<?php $user_details = $obj->selectOneUserDetail( 'user_tb', $_SESSION['user_unique_id']); ?>
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

    <title>Profile Update</title>
</head>
<body style="background-image: none;">

<?php require_once('sidebar.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 offset-md-0 col-lg-12 offset-lg-0 ml-0 bg-dark top_bar text-white mr-0">

            <?php require_once('head.php'); ?>

        </div>
    </div>

    <div class="row">
        <div class="container col-xs-12 col-sm-12 col-md-12 offset-md-0 col-lg-12  ml-0 mt-5 ">
            <div class="row ">
                <div class="col-xs-6 col-sm-6 col-md-9 offset-md-3 col-lg-9 offset-lg-3 mt-5">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-1 offset-md-0 col-lg-2 offset-lg-0">
                            <img src="img/englishuk-south-logo-square.jpg" class="img-fluid">
                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-1 offset-md-0 col-lg-5 offset-lg-0 mt-5">
                            <h2 class="font-weight-bold text-primary">Profile Update</h2>
                            <h6 class="mt-n2">Current Session: 2019/2020</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-9 offset-md-3 col-lg-9 offset-lg-3 ">
                <div class="row">


                    <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-12 offset-lg-0 mt-5 p-4 font-italic bg-light border-primary border text-dark">
                        <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-11 offset-lg-1 mt-4 font-italic ">
                            <h5 class="font-weight-bold">Update Profile</h5>
                        </div>
                        <hr>
                        <form class="p-3" method="post" action="processor.php?action_to_perform=update_profile">
                           <?php foreach($user_details as $key => $value ){?>
                            <div class="row">
                                
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

                                <div class="col-xs-12 col-sm-12 col-md-8 offset-md-2 col-lg-8 offset-lg-2 mt-2 form-group ">
                                    <i class="mdi mdi-account"></i>
                                    <label>First Name</label>
                                    <input value="<?php echo $value->first_name; ?>" name="ed_firstName" class="form-control bg-transparent border-bottom border-primary " type="text" placeholder="First Name">
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-8 offset-md-2 col-lg-8 offset-lg-2 form-group ">
                                    <i class="mdi mdi-account"></i>
                                    <label> Middle Name</label>
                                    <input value="<?php echo $value->middle_name; ?>" name="ed_middle_name" class="form-control bg-transparent border-bottom border-primary " type="text" placeholder="Middle Name">
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-8 offset-md-2 col-lg-8 offset-lg-2 form-group">
                                    <i class="mdi mdi-account"></i>
                                    <label>Last Name</label>
                                    <input name="ed_lastName" class="form-control bg-transparent border-bottom border-primary " type="text" value="<?php echo $value->lastname; ?>" placeholder="Last Name">
                                </div>

                      

                                <div class="col-xs-12 col-sm-12 col-md-8 offset-md-2 col-lg-8 offset-lg-2 form-group ">
                                    <i class="mdi mdi-phone"></i>
                                    <label>Phone Number</label>
                                    <input value="<?php echo $value->phone; ?>" name="ed_phone" class="form-control bg-transparent border-bottom border-primary " type="text" placeholder="Phone Number">
                                </div>

                                
                                <!--<div class="col-xs-12 col-sm-12 col-md-4 offset-md-0 col-lg-4 offset-lg-0  form-group">
                                    <i class="mdi mdi-calendar"></i>
                                    <label>Date of Birth</label>
                                    <input name="dob" class="form-control bg-transparent border-bottom  border-primary" type="date" placeholder="Date of Birth">
                                </div>-->

                                
                                <div class="col-xs-12 col-sm-12 col-md-8 offset-md-2 col-lg-8 offset-lg-2 form-group mt-0">
                                  
                                   <button class="btn-primary form-control" name="">Update Profile</button>
                                    
                                </div>

                            </div>
                            <?php } ?>
                        </form>


        </div>

    </div>
</div>


<footer>
    <div class="container-fluid col-12 offset-0 mt-5 bg-dark footer">
        <div class="col-4 offset-8 text-white text-right pt-3 pb-2">
            <h6>&copy <span><a href="#" class="company">Spring Pebbles</a></span> 2019</h6>
        </div>
    </div>
</footer>



</body>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/jquery_3_4_1.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

</html>