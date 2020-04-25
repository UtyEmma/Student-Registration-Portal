<?php require_once 'processor.php'?>
<?php /*check for login*/
$obj = new processor();
$obj->check_adminLogin('admin_login.php'); ?>

<?php $admin_unique_id = $_SESSION['admin_unique_id'];   ?>
<?php /* select the active academic year*/ $academic_year_details = $obj->selectFromAnyTable("SELECT * FROM academic_year WHERE status = 'active'");   ?>
<?php $academic_year = $academic_year_details[0]->academic_year;?>

<?php $details = $obj->selectFromAnyTable("SELECT * FROM admin_tb where admin_unique_id = '$admin_unique_id'")?>
    <?php $admin_details = $obj->selectOneAdminDetail('admin_tb', $_SESSION['admin_unique_id']); ?>
<?php /*print_r($admin_details) */?>
<?php $year = $obj->selectYear(); ?>
<?php //print_r($obj->selectYear()); ?>

<?php $student_detail = $obj->selectFromAnyTable("select * from user_tb");
//print_r($student_detail);
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
            <div class="row ">
                <div class="col-xs-6 col-sm-6 col-md-9 offset-md-3 col-lg-9 offset-lg-3 mt-5">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-1 offset-md-0 col-lg-2 offset-lg-0">
                            <img src="img/englishuk-south-logo-square.jpg" class="img-fluid">
                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-1 offset-md-0 col-lg-5 offset-lg-0 mt-5">
                            <h2 class="font-weight-bold text-primary">Administrator Dashboard</h2>
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


                    <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-12 offset-lg-0 mt-5 p-4 font-italic bg-light border-primary border text-dark" id="addCourses">
                        <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-12 offset-lg-0 p-4 font-italic ">
                            <h5 class="font-weight-bold">Add Courses</h5>
                            <form action="processor.php?action_to_perform=add_courses" method="POST">

                                <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-4 form-group text-dark">
                                    <i class="mdi mdi-textbox-password"></i>
                                    <label>Course Title</label>
                                    <input name="course_title" class="form-control bg-transparent border-bottom border-primary " type="text" placeholder="Course Title">
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-3 form-group text-dark">
                                    <i class="mdi mdi-textbox-password"></i>
                                    <label>Course Code</label>
                                    <input name="course_code" class="form-control bg-transparent border-bottom border-primary " type="text" placeholder="Course code">
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-5 form-group text-dark">
                                    <i class="mdi mdi-textbox-password"></i>
                                    <label>Course Description</label>
                                    <input name="course_desc" class="form-control bg-transparent border-bottom border-primary " type="text" placeholder="Course Description">
                                </div>

                                    <div class="col-xs-12 col-sm-12 col-md-8 offset-md-2 col-lg-8 offset-lg-2 form-group mt-5">
                                        <button name="add_courses"  type="submit" class="btn-primary form-control" >Add Courses</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-12 offset-lg-0 mt-5 p-4 font-italic bg-light border-primary border text-dark" id="academicYear">
                        <h5 class="font-weight-bold">Select the current Academic Year</h5>
                        <form action="processor.php?action_to_perform=academic_year" method="POST">

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-2 form-group text-dark ">
                                    <i class="mdi mdi-textbox-password"></i>
                                    <label>Academic Year</label>
                                        </div>
                                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-5 form-group text-dark ">

                                    <select class="form-control" name="academic_year">
                                        <option>Select Year</option>

                                        <?php if(isset($_SESSION['academic_year'])){?>
                                            <option selected value="<?php echo $_SESSION['academic_year']; ?>">
                                                <?php echo $_SESSION['academic_year']; ?></option>
                                        <?php } ?>

                                    <?php foreach($year as $key => $value){?>
                                        <?php $value2 = $value + 1;?>
                                        <option><?php echo $value.'/'.$value2; ?></option>
                                        <?php }?>
                                    </select>
                                            </div>

                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-4 form-group text-dark ">
                                            <button name="add_courses"  type="submit" class="btn-primary form-control" >Confrim</button>
                                        </div>
                                        </div>

                                </div>

                            </div>
                        </form>

                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-9 offset-lg-3  mt-5 p-4 font-italic  bg-light border-info border text-dark" id="regCourses">
                        <a name="reg_course">
                            <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-12 offset-lg-0 p-4 font-italic ">
                                <h5 class="font-weight-bold">View Student Details</h5>
                            </div>

                            <table class="table table-striped table-active table-hover text-center">
                                <tbody>
                                    <tr class="">
                                    <th>S/N</th>
                                    <th>STUDENT NAME</th>
                                    <th>REGISTRATION NUMBER</th>
                                    <th></th>
                                </tr>


                                    <?php $i = 0 ?>
                                    <?php foreach ($student_detail as $key => $value){?>
                                    <?php $i++ ?>
                                        <tr>
                                        <td class="col-2">
                                            <?php echo $i ?>
                                        </td>

                                        <td class="col-4">
                                            <?php echo $value->lastname.', '.$value->first_name.' '.$value->middle_name; ?>
                                        <td class="col-3 ">
                                            <?php echo $value->reg_no; ?>
                                        </td>
                                        <td class="col-3 ">
                                            <a href="student_record.php?user_id=<?php echo $value->unique_id; ?>" class="btn alert alert-success p-1">View Details</a>
                                        </td>
                                    </tr>
                                    <?php } ?>

                                </tbody>

                            </table>

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