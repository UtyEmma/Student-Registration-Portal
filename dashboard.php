<?php require_once('processor.php'); ?>
<!--instatiate the class-->
<?php $student_unique_id = $_SESSION['user_unique_id']; ?>
<?php $obj = new processor(); ?>

<?php /*check for login*/
$obj->checkLogin('login.php'); ?>

<?php /* select the active academic year*/ $academic_year_details = $obj->selectFromAnyTable("SELECT * FROM academic_year WHERE status = 'active'");   ?>

<?php /* select the registered course for the active academic year*/

$academic_year = $academic_year_details[0]->academic_year;

$user_details = $obj->selectOneUserDetail('user_tb', $_SESSION['user_unique_id']); ?>

<?php $registered_course_details = $obj->selectFromAnyTable("SELECT * FROM course_reg_tb WHERE student_unique_id = '$student_unique_id' AND academic_year = '$academic_year'");
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

    <title>Student Dashboard</title>
</head>
<body style="background-image: none;">

<?php require_once('sidebar.php'); ?>

<div class="container-fluid">
    <?php require_once('head.php'); ?>

    <div class="row">
        <div class="container col-xs-12 col-sm-12 col-md-12 offset-md-0 col-lg-12  ml-0 mt-5 ">
            <div class="row ">
            <div class="col-xs-6 col-sm-6 col-md-9 offset-md-3 col-lg-9 offset-lg-3 mt-5">
<div class="row">
                <div class="col-xs-6 col-sm-6 col-md-1 offset-md-0 col-lg-2 offset-lg-0">
                <img src="img/englishuk-south-logo-square.jpg" class="img-fluid">
                </div>

                <div class="col-xs-6 col-sm-6 col-md-1 offset-md-0 col-lg-5 offset-lg-0 mt-5">
                    <h2 class="font-weight-bold text-primary">Student Dashboard</h2>
                    <h6 class="mt-n2">Current Session: <span><?php echo $academic_year ;?></span></h6>
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
                
			</div>
            </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-9 offset-md-3 col-lg-9 offset-lg-3 ">
                <div class="row">


                   <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-12 offset-lg-0 mt-5 p-4 font-italic bg-light border-primary border text-dark">
                        <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-12 offset-lg-0 p-4 font-italic ">
                            <h5 class="font-weight-bold">Student Personal Details</h5>
                        </div>
                         
<?php foreach($user_details as $key => $value){ ?>
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Full Name</th>
                                <td><?php echo $value->lastname.', '.$value->first_name.' '.$value->middle_name ?></td>
                            </tr>
                            <tr>
                                <th>Registration Number</th>
                                <td><?php echo $value->reg_no ?></td>
                            </tr>
                            <tr>
                                <th>Email Address</th>
                                <td><?php echo $value->email ?></td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td>
                                <?php echo $value->phone ?></td>
                            </tr>
                            </tbody>

                        </table>
                        
                        <?php } ?>
                       <a href="profileUpdate.php">
                        <button type="button" class="border-primary rounded-pill">Update Profile</button>
                       </a>
                   </div>

                    <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-12 offset-lg-0 mt-5 p-4 font-italic alert-info border-info border text-dark">
                    <a name="reg_course">
                        <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-12 offset-lg-0 p-4 font-italic ">
                            <h5 class="font-weight-bold">Registered Courses</h5>
                        </div>

                        <table class="table">
                            <tbody>
                            <tr>
                                <th>S/N</th>
                                <th>Course Name</th>
                                <th>Course Code</th>
                                <th>Course Description</th>
                            </tr>
                            
                        <?php
                            if($registered_course_details < 1){
                             
                             echo '<div class="col-12 p-5 flex-column">
                             <h3 class="text-center">NO COURSES HAVE BEEN REGISTERED</h1>
                             <h5 class="text-center">Please <a href="course_reg.php">Register Courses</a></h1>
                         </div>';
                             ?>       
                                

                                <?php
                            }else{
							$no = 0;
							foreach($registered_course_details as $key => $value){
							    $no++; ?>

                        
                            
                            <tr>
                                <td><?php echo $no; ?></td>
                                
                                <td><?php echo $obj->selectAColumnFromAnyTable('course_tb', 'course_unique_id', $value->course_unique_id, 'course_name'); ?></td>
                                <td>
                                	<?php echo $obj->selectAColumnFromAnyTable('course_tb', 'course_unique_id', $value->course_unique_id, 'course_code'); ?>
                                </td>
                                <td>
                                	<?php echo $obj->selectAColumnFromAnyTable('course_tb', 'course_unique_id', $value->course_unique_id, 'course_desc'); ?>
                                </td>
                            </tr>
                            <?php }} ?>
                            
                            </tbody>

                        </table>
                        <a href="course_reg.php">
                        <button type="button" class="border-primary rounded-pill">Change Courses</button>
                    </a>
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