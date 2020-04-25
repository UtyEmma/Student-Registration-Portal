<?php require_once 'processor.php'?>
<?php /*check for login*/
$obj = new processor();
$obj->checkLogin('admin_login.php');
?>


<?php $admin_unique_id = $_SESSION['admin_unique_id'];   ?>
<?php /* select the active academic year*/ $academic_year_details = $obj->selectFromAnyTable("SELECT * FROM academic_year WHERE status = 'active'");   ?>
<?php $academic_year = $academic_year_details[0]->academic_year;?>

<?php $details = $obj->selectFromAnyTable("SELECT * FROM admin_tb where admin_unique_id = '$admin_unique_id'")?>
<?php $admin_details = $obj->selectOneAdminDetail('admin_tb', $_SESSION['admin_unique_id']); ?>
<?php /*print_r($admin_details) */?>
<?php $year = $obj->selectYear(); ?>
<?php $course_details = $obj->selectFromAnyTable('SELECT * FROM course_tb'); ?>

<?php $student_detail = $obj->selectFromAnyTable("select * from user_tb");
//print_r($student_detail);

$unique_id = $_GET['user_id'];
$_SESSION['get_user_id'] = $unique_id;

$student_detail = $obj->selectOneUserDetail("user_tb", $unique_id);
/*
print_r($student_detail);*/

$registered_courses = $obj->selectFromAnyTable("select * from course_reg_tb where student_unique_id = '$unique_id' and academic_year = '$academic_year'");

//print_r($registered_courses);
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

    <title>Admin Dashboard</title>
</head>
<body style="background-image: none;">

<?php require_once ('admin_side_bar.php') ; ?>

<?php require_once ('admin_head.php') ; ?>

<div class="row">
    <div class="container col-xs-12 col-sm-12 col-md-12 offset-md-0 col-lg-12  ml-0 mt-5 ">
         <div class="col-xs-6 col-sm-6 col-md-9 offset-md-3 col-lg-9 offset-lg-3 mt-5">

                <div class="row">

                    <div class="col-xs-6 col-sm-6 col-md-1 offset-md-0 col-lg-2 offset-lg-0">
                        <img src="img/englishuk-south-logo-square.jpg" class="img-fluid">
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-1 offset-md-0 col-lg-5 offset-lg-0 mt-5">
                        <h2 class="font-weight-bold text-primary">Administrator Dashboard</h2>
                        <h6 class="mt-n2">Current Session: <span><?php echo $academic_year ;?></span></h6>
                    </div>
                </div>
         </div>
    </div>
</div>

<div class="col-xs-6 col-sm-6 col-md-9 offset-md-3 col-lg-9 offset-lg-3 ">
    <div class="row">

        <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-12 offset-lg-0 mt-3 p-4 font-italic bg-light border-primary border text-dark">

            <form class="p-3" action="processor.php?action_to_perform=update_student_profile" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-5">
                        <h4 class="text-black-50 font-weight-bold ">Update Student Profile</h4>
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

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mt-4 form-group ">
                        <i class="mdi mdi-account"></i>
                        <label>First Name</label>
                        <input name="firstName" class="form-control bg-transparent border-bottom border-primary" type="text" placeholder="Full Name" value="<?php echo $student_detail[0]->first_name ?>">
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mt-4 form-group ">
                        <i class="mdi mdi-account"></i>
                        <label> Middle Name</label>
                        <input name="middleName" class="form-control bg-transparent border-bottom border-primary " type="text" placeholder="Middle Name" value="<?php echo $student_detail[0]->middle_name ?>">
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mt-4 form-group ">
                        <i class="mdi mdi-account"></i>
                        <label>Last Name</label>
                        <input name="lastName" class="form-control bg-transparent border-bottom border-primary " type="text" placeholder="Last Name" value="<?php echo $student_detail[0]->lastname ?>" >
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 form-group ">
                        <i class="mdi mdi-email"></i>
                        <label>Email</label>
                        <input name="email" class="form-control bg-transparent border-bottom border-primary" type="text" placeholder="Email" value="<?php echo $student_detail[0]->email?>">
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 form-group ">
                        <i class="mdi mdi-phone"></i>
                        <label>Phone Number</label>
                        <input name="phoneNumber" class="form-control bg-transparent border-bottom border-primary " type="text" placeholder="Phone Number" value="<?php echo $student_detail[0]->phone?>">
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 form-group ">
                        <i class="mdi mdi-account-circle"></i>
                        <label>Gender</label>
                        <select name="gender" class="form-control bg-transparent border-bottom border-primary">
                            <option>Select Gender</option>
                                <option selected value="<?php echo $student_detail[0]->gender ?>">
                                    <?php echo $student_detail[0]->gender ?></option>

                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-group ">
                        <i class="mdi mdi-calendar"></i>
                        <label>Date of Birth</label>
                        <input name="dob" class="form-control bg-transparent border-bottom  border-primary" type="date" placeholder="Date of Birth" value="<?php echo $student_detail[0]->dob ?>">
                    <hr>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-group">
                        <i class="mdi mdi-textbox-password"></i>
                        <label>Password</label>
                        <input name="password" class="form-control bg-transparent border-bottom border-primary" type="password" placeholder="Input New Password">
                        <hr>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 offset-lg-2 form-group mt-5">
                        <input name="submit" type="submit" class="btn-primary form-control"  value="Update">
                    </div>
                </div>
            </form>
        </div>

            <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-12 offset-lg-0 mt-3 p-4 font-italic bg-light border-primary border text-dark">
            <form class="p-3" action="processor.php?action_to_perform=change_student_courses" method="post" enctype="multipart/form-data">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 form-group p-3">
                        <h4 class="font-weight-bold text-center">Edit Registered Courses</h4>


                        <table class="table mt-5">

                        <tbody>

                        <tr class="text-center mt-5">
                            <th>Course Title</th>
                            <th>Course Code</th>
                            <th>Course Description</th>
                            <th></th>
                        </tr>

                        <?php foreach($course_details as $key => $value){?>

<!--                            --><?php // = $_SESSION['course_unique_id']?>
                            <tr class="text-center">


                                <td>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4 form-group">
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

                                <td>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4 form-group ">
                                        <input name="academic_year" type="hidden" value="<?php echo $academic_year_details[0]->academic_year; ?>" >
                                        <button href="update_student_profile.php?action_to_perform=update_student_profile&user_id=<?php echo $unique_id; ?>" name="add_courses[]" type="submit" class="btn alert alert-success p-1 shadow" value="<?php echo $value->course_unique_id ?>">Add</button>
                                        <button href="update_student_profile.php?action_to_perform=remove_a_course?user_id=<?php echo $unique_id; ?>" name="remove_courses[]" type="submit" class="btn alert alert-success p-1 shadow" value="<?php echo $value->course_unique_id ?>">Remove</button>

                                    </div>
                                </td>

                            </tr>
                        <?php } ?>


                        </tbody>
                    </table>
                        </div>
                    </div>

                </div>
            </form>

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