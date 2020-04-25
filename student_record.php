<?php require_once 'processor.php';
$obj = new processor();

/* select the active academic year*/
$academic_year_details = $obj->selectFromAnyTable("SELECT * FROM academic_year WHERE status = 'active'");
$academic_year = $academic_year_details[0]->academic_year;

$unique_id = $_GET['user_id'];
//print_r($unique_id);

$student_detail = $obj->selectOneUserDetail("user_tb", $unique_id);

//selecting the courses registered by the student
$select = $obj->selectFromAnyTable("select * from course_reg_tb where student_unique_id = '$unique_id' and academic_year = '$academic_year'");

?>

<?php $admin_details = $obj->selectOneAdminDetail('admin_tb', $_SESSION['admin_unique_id']); ?>
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
                            <h6 class="mt-n2">Current Session: <span><?php echo $academic_year ?></span></h6>
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

            <div class="col-xs-6 col-sm-6 col-md-9 offset-md-3 col-lg-9 offset-lg-3 mb-5">
                <div class="row">

                    <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-12 offset-lg-0 mt-5 p-4 bg-light border-primary border text-dark">
                        <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-12 offset-lg-0 p-4 ">
                            <h5 class="font-weight-bold font-italic">STUDENT RECORD</h5>
                        <div class="row">

                            <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-3 offset-lg-0 p-4 img">
                                <img src="img/passport/<?php echo $student_detail[0]->passport ?>" class="img-fluid rounded-circle border-dark border">
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-9 offset-lg-0 p-4">
                            <div class="row">

                            <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-5 offset-lg-0 mt-3">
                                <h5 class="font-weight-bold">Name</h5>
                                <p><?php echo $student_detail[0]->lastname.', '.$student_detail[0]->first_name.' '.$student_detail[0]->middle_name ?></p>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-3 offset-lg-0 mt-3">
                                <h5 class="font-weight-bold">Reg Number</h5>
                                <p><?php echo $student_detail[0]->reg_no ?></p>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-3 offset-lg-0 mt-3">
                                <h5 class="font-weight-bold">Email Address</h5>
                                <p><?php echo $student_detail[0]->email ?></p>
                            </div>

                                <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-5 offset-lg-0 mt-4">
                                    <h5 class="font-weight-bold">Phone Number</h5>
                                    <p><?php echo $student_detail[0]->phone ?></p>
                                </div>

                            <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-3 offset-lg-0 mt-4">
                                <h5 class="font-weight-bold">Gender</h5>
                                <p><?php echo $student_detail[0]->gender ?></p>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-3 offset-lg-0 mt-4">
                                <h5 class="font-weight-bold">Date of Birth</h5>
                                <p><?php echo $student_detail[0]->dob ?></p>
                            </div>
                            </div>

                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-10 offset-md-2 col-lg-12 offset-lg-0 alert alert-success mt-5">
                                <h4 class="font-weight-bold text-center">Registered Courses</h4>
                            <table class="table">


                                <tbody>

                                <tr>
                                    <th>S/N</th>
                                    <th>Course Title</th>
                                    <th>Course Code</th>
                                    <th>Course Description</th>
                                    <th></th>
                                </tr>
                                <?php
                            if($select < 1){
                             
                             echo '<div class="col-12 p-5 flex-column">
                             <h3 class="text-center">NO COURSES HAVE BEEN REGISTERED</h1>
                             <h5 class="text-center">Please <a href="course_reg.php">Register Courses</a></h1>
                         </div>';
                             ?>       
                                

                                <?php
                            }else{
                                $x = 1;

                                for ($i =0; $i < count($select); ){
                                $detail = $select[$i]->course_unique_id;
                                $i++;
                                $select_courses = $obj->selectFromAnyTable("select * from course_tb where course_unique_id = '$detail'");
                                foreach ($select_courses as $key => $value){

                                ?>


                                <tr >
                                    <td >
                                        <?php echo $x++; ?>
                                    </td>

                                    <td >
                                        <?php  echo $value->course_name; ?>
                                    <td >
                                        <?php  echo $value->course_code; ?>
                                    </td>

                                    <td>
                                        <?php  echo $value->course_desc; ?>
                                    </td>
                                </tr>

                                <?php }?>
                                <?php }}?>

                                </tbody>

                            </table>
                        </div>

                            <a class="btn btn-primary col-4 offset-4 mt-5" href="update_student_profile.php?user_id=<?php echo $student_detail[0]->unique_id;?>">Edit Student Details</a>

                        </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>


<footer>
    <div class="container-fluid col-12 offset-0 mb-0 bg-dark footer">
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