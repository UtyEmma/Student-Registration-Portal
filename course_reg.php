<?php require_once('processor.php'); ?>
<?php $obj = new processor(); ?>
<?php $course_details = $obj->selectFromAnyTable('SELECT * FROM course_tb'); ?>
<?php $academic_year_details = $obj->selectFromAnyTable("SELECT * FROM academic_year WHERE status = 'active'");   ?>

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

    <title>Course Registration</title>
</head>
<body style="background-image: none;">

<?php require_once('sidebar.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 offset-md-0 col-lg-12 offset-lg-0 ml-0 bg-dark top_bar text-white mr-0">

<!--            <div class="row">-->
<!--                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 text-white text-right mr-0 mt-2">-->
<!--                    <p class="welcome_text">Welcome Utibe-Abasi</p>-->
<!--                </div>-->
<!---->
<!--                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-white">-->
<!--                    <ul class="navbar-nav flex-row mt-1">-->
<!--                        <li class="nav-item mr-4"><a href="#"><i class="mdi mdi-facebook facebook text-white" style="font-size: 24px"></i></a></li>-->
<!--                        <li class="nav-item mr-4"><a href="#"><i class="mdi mdi-twitter twitter text-white" style="font-size: 24px"></i></a></li>-->
<!--                        <li class="nav-item mr-4"><a href="#"><i class="mdi mdi-instagram instagram text-white" style="font-size: 24px"></i></a></li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->
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
                            <h2 class="font-weight-bold text-primary">Course Registration</h2>
                            <h6 class="mt-n2">Current Session: <?php echo $academic_year_details[0]->academic_year; ?></h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-9 offset-md-3 col-lg-9 offset-lg-3 ">
                <div class="row">


                    <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-12 offset-lg-0 mt-5 p-4 font-italic bg-light border-primary border text-dark">
                        <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-12 offset-lg-0 p-4 font-italic ">
                            <h5 class="font-weight-bold">Register Courses</h5>
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

                        <form class="p-3" action="processor.php?action_to_perform=register_courses" method="post">
                            <div class="row">

                                <table class="table">

                                    <tbody>

                                    <tr class="text-center">
                                        <th></th>
                                        <th>Course Title</th>
                                        <th>Course Code</th>
                                        <th>Course Description</th>
                                    </tr>

                                   <?php foreach($course_details as $key => $value){?>
                                    <tr class="text-center">

                                        <td>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4 form-group ">
                                   <input name="academic_year" type="hidden" value="<?php echo $academic_year_details[0]->academic_year; ?>" >
                                   <input name="course_name[]" type="hidden" value="<?php echo $value->course_name ?>" >
                                   <input name="course_id[]" class="form-control bg-transparent border-bottom border-primary text-white " type="checkbox" value="<?php echo $value->course_unique_id; ?>">
                                </div>
                                        </td>
                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4 form-group ">
                                                <p><?php echo ucwords($value->course_name) ?></p>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4 form-group ">
                                                <p><?php echo $value->course_code; ?></p>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4 form-group ">
                                                <p><?php echo $value->course_desc; ?></p>
                                            </div>
                                        </td>
                                    </tr>
									<?php } ?>


                                    </tbody>
                                </table>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right mt-3">
                                    <a href="dashboard.php#reg_course" class="">View registered Courses</a>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-4 offset-md-4 col-lg-4 offset-lg-4 form-group mt-5">
                                    <input name="submit" type="submit" class="btn-primary form-control"  value="Register">
                                </div>

                            </div>
                        </form>


    </div>
</div>
            </div>
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