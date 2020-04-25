<?php session_start(); ?>
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

    <title>Student Registration</title>
</head>
<body>

<div class="container-fluid">
    <div class="row ">

        <div class="container col-xs-12 col-sm-12 col-md-7 offset-1 col-lg-7 offset-1 flex-column mt-5">
            <form class="p-3" action="processor.php?action_to_perform=register" method="post" >
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3 offset-md-5 col-lg-4 offset-lg-4 text-center mt-5">
                        <img src="img/englishuk-south-logo-square.jpg" class="img-fluid rounded-circle mt-5 ">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5">
                        <h3 class="text-white font-weight-bold ">STUDENT REGISTRATION</h3>
                    </div>
                    
                    
			<?php if(isset($_GET['success'])){ ?>
            <div class="col-xs-12 offset-xs-0 col-sm-12 offset-sm-0 col-md-12 col-lg-12 alert alert-success text-center mt-5">
                
                    <p><?php echo $_GET['success']; ?></p>
                    
            </div>
        	<?php } ?>
                
			<?php if(isset($_GET['db_error'])){ ?>
            <div class="col-xs-12 offset-xs-0 col-sm-12 offset-sm-0 col-md-12 col-lg-12 alert alert-danger text-center mt-5">
                
                    <p><?php echo $_GET['db_error']; ?></p>
                    
            </div>
        	<?php } ?>
                
			<?php if(isset($_SESSION['error_array'])){ ?>
            <div class="col-xs-12 offset-xs-0 col-sm-12 offset-sm-0 col-md-12 col-lg-12 alert alert-danger text-center mt-5">
                <?php //print_r($_SESSION['error_array']); ?>
                <?php foreach($_SESSION['error_array'] as $k => $error){ ?>

                    <p><?php echo $error; ?></p>

                <?php } ?>
            </div>
        	<?php } ?>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4 text-white form-group ">
                    <i class="mdi mdi-account"></i>
                    <label>First Name</label>
                <input name="firstName" class="form-control bg-transparent border-bottom border-primary text-white " type="text" placeholder="Full Name" value="<?php if(isset($_SESSION['firstName'])){ echo $_SESSION['firstName']; } ?>">
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group text-white ">
                    <i class="mdi mdi-account"></i>
                <label> Middle Name</label>
                <input name="middleName" class="form-control bg-transparent border-bottom text-white border-primary " type="text" placeholder="Middle Name" value="<?php if(isset($_SESSION['middleName'])){ echo $_SESSION['middleName']; } ?>">
                </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group text-white ">
                        <i class="mdi mdi-account"></i>
                        <label>Last Name</label>
                    <input name="lastName" class="form-control bg-transparent text-white border-bottom border-primary " type="text" placeholder="Last Name" value="<?php if(isset($_SESSION['lastName'])){ echo $_SESSION['lastName']; } ?>" >
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group text-white ">
                    <i class="mdi mdi-email"></i>
                    <label>Email</label>
                    <input name="email" class="form-control text-white bg-transparent border-bottom border-primary" type="text" placeholder="Email" value="<?php if(isset($_SESSION['email'])){ echo $_SESSION['email']; } ?>">
                </div>


                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group text-white ">
                    <i class="mdi mdi-phone"></i>
                    <label>Phone Number</label>
                    <input name="phoneNumber" class="form-control bg-transparent border-bottom text-white border-primary " type="text" placeholder="Phone Number" value="<?php if(isset($_SESSION['phoneNumber'])){ echo $_SESSION['phoneNumber']; } ?>">
                </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-group text-white ">
                        <i class="mdi mdi-account-circle"></i>
                        <label>Gender</label>
                        <select name="gender" class="form-control bg-transparent border-bottom text-white border-primary">
                            <option>Select Gender</option>
                            <?php if(isset($_SESSION['gender'])){?>
                            <option selected value="<?php echo $_SESSION['gender']; ?>">
                                <?php echo $_SESSION['gender']; ?></option>
                        	<?php } ?>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-group text-white">
                    <i class="mdi mdi-calendar"></i>
                    <label>Date of Birth</label>
                    <input name="dob" class="form-control bg-transparent border-bottom  border-primary text-white" type="date" placeholder="Date of Birth" value="<?php if(isset($_SESSION['dob'])){ echo $_SESSION['dob']; } ?>">
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-group text-white ">
                    <i class="mdi mdi-textbox-password"></i>
                    <label>Password</label>
                    <input name="password" class="form-control bg-transparent border-bottom border-primary text-white " type="password" placeholder="Password">
                </div>

                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-group text-white ">
                    <i class="mdi mdi-textbox-password"></i>
                    <label>Confirm Password</label>
                    <input name="conpassword" class="form-control bg-transparent border-bottom border-primary text-white " type="password" placeholder="Confirm Password">
                </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right mt-3">
                        <a href="login.php" class="text-white">Already registered</a>
                    </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group mt-5">
                <input name="submit" type="submit" class="btn-primary form-control"  value="Submit">
                </div>

                </div>
            </form>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 bg-primary pt-5 side_bar">

            <div class="col-xs-12 col-sm-12 col-md-12 offset-md-0 col-lg-12 offset-lg-0 text-center side_content">
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
</div>


</body>
<script type="text/javascript" src="js/jquery_3_4_1.js"></script>

<script type="text/javascript" src="js/bootstrap.min.js"></script>
</html>