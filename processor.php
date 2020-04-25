<?php

session_start();
require_once('library.php');

class processor extends library
{

    function __construct()
    {

        //calling the parent construct
        parent::__construct();

        //check if there is a action_to_perform key on the url
        if (isset($_GET['action_to_perform'])) {
            //use the switch to determine the method to be called for the value gotten from the url
            switch ($_GET['action_to_perform']) {

                case 'register':
                    $this->processRegistration();
                    break;
                case 'login':
                    $this->processLogin();
                    break;
                case 'upload_image':
                    $this->UploadImage();
                    break;
                case 'update_profile':
                    $this->updateProfile();
                    break;
                case 'register_courses':
                    $this->registerCourses();
                    break;
                case 'register-admin':
                    $this->processAdmin();
                    break;
                case 'login_admin':
                    $this->adminLogin();
                case 'add_courses':
                    $this->addCourses();
                case 'academic_year':
                    $this->addAcadYear();
                case 'update_student_profile':
                    $this->updateStudentProfile();
                case 'change_student_courses':
                    $this->change_student_courses();
                case 'remove_a_course':
                    $this->remove_a_course();
                default:
                    return 'page does not exists';

            }
        }


    }

    function processRegistration()
    {

        $firstName = $_SESSION['firstName'] = mysqli_real_escape_string(self::$db_connector, $_POST['firstName']);
        $middleName = $_SESSION['middleName'] = mysqli_real_escape_string(self::$db_connector, $_POST['middleName']);
        $lastName = $_SESSION['lastName'] = mysqli_real_escape_string(self::$db_connector, $_POST['lastName']);
        $email = $_SESSION['email'] = mysqli_real_escape_string(self::$db_connector, $_POST['email']);
        $phoneNumber = $_SESSION['phoneNumber'] = mysqli_real_escape_string(self::$db_connector, $_POST['phoneNumber']);
        $gender = $_SESSION['gender'] = mysqli_real_escape_string(self::$db_connector, $_POST['gender']);
        $dob = $_SESSION['dob'] = mysqli_real_escape_string(self::$db_connector, $_POST['dob']);
        $password = $_SESSION['password'] = mysqli_real_escape_string(self::$db_connector, $_POST['password']);
        $conpassword = $_SESSION['conpassword'] = mysqli_real_escape_string(self::$db_connector, $_POST['conpassword']);

        //form validation
        //build an associative array for the form validation
        $post_array = array("firstName" => $firstName, "middleName" => $middleName, "lastName" => $lastName, "email" => $email, "phoneNumber" => $phoneNumber, "gender" => $gender, "dob" => $dob, "password" => $password, "conpassword" => $conpassword);

        //create the field names for the different fields
        $field_name = array("First Name", "Middle Name", "Last Name", "Email", "Phone Number", "Gender", "Date of Birth", "Password", "Confirm Password");

        //unset the error session
        unset($_SESSION['error_array']);

        $this->registrationFormValidator($post_array, $field_name, 'register.php');

        //prepare data for insert to db

        //create unique id
        $unique_id = $this->createUniqueId('user_tb', 'unique_id');

        //create reg no
        $reg_no = rand(1000, 9999);
        $reg_no = self::ACADEMIC_YEAR . $reg_no;

        $h_password = $this->hasHer($password, self::SALT);

        $query = "INSERT INTO user_tb (id, unique_id, first_name, middle_name, lastname, email, password, phone, reg_no, gender, dob) VALUES (null,'" . $unique_id . "','" . $firstName . "','" . $middleName . "','" . $lastName . "','" . $email . "','" . $h_password . "','" . $phoneNumber . "','" . $reg_no . "','" . $gender . "','" . $dob . "')";
        if (mysqli_query(self::$db_connector, $query)) {

            //unset the sessions
            unset($_SESSION['firstName']);
            unset($_SESSION['middleName']);
            unset($_SESSION['lastName']);
            unset($_SESSION['email']);
            unset($_SESSION['phoneNumber']);
            unset($_SESSION['gender']);
            unset($_SESSION['password']);
            unset($_SESSION['conpassword']);
            unset($_SESSION['error_array']);


            header("location:login.php?success=Registration was successful!!!");

        } else {

            header("location:register.php?db_error=" . mysqli_error(self::$db_connector));

        }

    }


    function registrationFormValidator($post_array = array(), $field_name = array(), $page_name)
    {
        $i = 0;
        $error_array = array();
        $error_checker = 0;
        //check for empty
        foreach ($post_array as $key => $value) {

            if ($this->validateData($value, 'empty') == false) {

                $error_array[] = $field_name[$i] . ' is required!!!';
                $error_checker = 1;

            }
            $i++;
        }

        //ceheck for valid email
        if ($post_array['email'] != "") {
            if ($this->validateData($post_array['email'], 'valid_email') == false) {

                $error_array[] = 'Please supply a valid Email';
                $error_checker = 1;

            }
        }

        //check if phone is a number
        if ($post_array['phoneNumber'] != "") {
            if ($this->validateData($post_array['phoneNumber'], 'numeric') == false) {

                $error_array[] = 'Only numbers are required for phone field';
                $error_checker = 1;

            }
        }

        //check for password match
        if ($post_array['password'] != "" && $post_array['conpassword'] != "") {
            if ($this->validateData($post_array['password'], 'password_match', $post_array['conpassword']) == false) {

                $error_array[] = 'Password does not match!!!';
                $error_checker = 1;

            }
        }

        //validate birthday format
        if ($post_array['dob'] != "") {
            if ($this->validateData($post_array['dob'], 'birthday_format') == false) {

                $error_array[] = 'Please use the date picker to your birthday!';
                $error_checker = 1;

            }
        }

        //validate password lenght
        if ($post_array['password'] != "") {
            if ($this->validateData($post_array['password'], 'alphanumeric') == false) {

                $error_array[] = 'Password should contain numbers and alphabet!';
                $error_checker = 1;

            }
        }

        //validate password for alphanumeric
        if ($post_array['password'] != "") {
            if ($this->validateData($post_array['password'], 'password_len') == false) {

                $error_array[] = 'Password must be more than 8 or equal t 8 characters';
                $error_checker = 1;

            }
        }

        //validate password for alphanumeric
        if ($post_array['phoneNumber'] != "") {
            if ($this->validateData($post_array['phoneNumber'], 'phone_len') == false) {

                $error_array[] = 'phone must be be up to 11 characters';
                $error_checker = 1;

            }
        }
        //echo mysqli_num_rows($result); die();
        //validate password for alphanumeric
        if ($post_array['email'] != "") {
            if ($this->validateData($post_array['email'], 'unique_email', "", "user_tb") == false) {

                $error_array[] = 'Email address already exists';
                $error_checker = 1;

            }
        }

        //if the error checker is equal to 1, then there is an error
        if ($error_checker == 1) {

            $_SESSION['error_array'] = $error_array;
            //redirect the page to form and display errors
            header('location:' . $page_name);
            die();

        }

    }

    //login_password login_submit login_email
    function processLogin()
    {

        //get the form values
        $login_password = mysqli_real_escape_string(self::$db_connector, $_POST['login_password']);
        $login_email = mysqli_real_escape_string(self::$db_connector, $_POST['login_email']);

        //unset error session
        unset($_SESSION['error_array']);

        //run validation
        $this->loginValidator(array('email' => $login_email, 'password' => $login_password), $field_name = array('Email', 'Password'), 'login.php');

        //hash the pasword
        $h_password = $this->hasHer($login_password, self::SALT);

        //run a select to check if the values actually exists
        $query = "SELECT * FROM user_tb WHERE email = '$login_email' AND password = '$h_password'";

        //run the query
        if ($result = mysqli_query(self::$db_connector, $query)) {
            //print_r(mysqli_num_rows($result)); die();
            //check if one row
            if (mysqli_num_rows($result) == 1) {


                while ($row = mysqli_fetch_assoc($result)) {

                    $unique_id = $row['unique_id'];
                    $email = $row['email'];

                }

                //set the sessions using the values returned from the db
                $_SESSION['logged'] = TRUE;
                $_SESSION['user_unique_id'] = $unique_id;
                $_SESSION['user_email'] = $email;

                //redirect to the user dashboard
                header("location:dashboard.php");

            } else {

                header("location:login.php?error=Incorrect Email/Password");
            }


        } else {

            header("location:login.php?db_error=" . mysqli_error(self::$db_connector));

        }

    }

    function loginValidator($post_array = array(), $field_name = array(), $page_name)
    {

        $i = 0;
        $error_array = array();
        $error_checker = 0;
        //check for empty
        foreach ($post_array as $key => $value) {

            if ($this->validateData($value, 'empty') == false) {

                $error_array[] = $field_name[$i] . ' is required!!!';
                $error_checker = 1;

            }
            $i++;
        }

        //ceheck for valid email
        if ($post_array['email'] != "") {
            if ($this->validateData($post_array['email'], 'valid_email') == false) {

                $error_array[] = 'Please supply a valid Email';
                $error_checker = 1;

            }
        }


        //if the error checker is equal to 1, then there is an error
        if ($error_checker == 1) {

            $_SESSION['error_array'] = $error_array;
            //redirect the page to form and display errors
            header('location:' . $page_name);
            die();

        }

    }

    function checkLogin($page)
    {

        if (!isset($_SESSION['logged'])) {

            header("location:$page?error=please login first");
            die();
        }

    }

    function selectOneUserDetail($table_name, $unique_id)
    {

        $query = "SELECT * FROM $table_name WHERE unique_id = '$unique_id'";

        if ($result = mysqli_query(self::$db_connector, $query)) {

            if (mysqli_num_rows($result) > 0) {

                //decalre an array  to catch the values
                $value_to_returned = array();

                //loop through the result and rreturn each row
                while ($row = mysqli_fetch_object($result)) {

                    $value_to_returned[] = $row;

                }
                return $value_to_returned;
            } else {

                return 'No data was found';

            }

        } else {

            return 'An error occurred : ' . mysqli_error(self::$db_connector);

        }

    }


    function UploadImage()
    {

        //get the file
        $file_name = $_FILES['passport']['name'];
        $file_type = $_FILES['passport']['type'];
        $file_size = $_FILES['passport']['size'];
        $file_tmp = $_FILES['passport']['tmp_name'];

        unset($_SESSION['error_array']);

        //valdate the image being uploaded
        $this->imageValidator(
            array('file_name' => $file_name, 'file_type' => $file_type, 'file_size' => $file_size),
            array('File Name', 'File Type', 'File Size'),
            'dashboard.php'
        );

        //explode the extension
        $exploded_extention = explode('/', $file_type);

        //if validation is passed, we uplod image
        $new_name = 'reg_' . microtime() . '.' . $exploded_extention[1];

        $path = 'img/passport/' . $new_name;

        //do the upload
        if (move_uploaded_file($file_tmp, $path)) {

            //get the unique id
            $unique_id = $_SESSION['user_unique_id'];

            //update the db
            $query = "UPDATE user_tb SET passport = '$new_name' WHERE unique_id = '$unique_id'";
            mysqli_query(self::$db_connector, $query);

            header("location:dashboard.php?success=Image Upload was success");

        } else {
            header("location:dashboard.php?error=Image Upload failed");
        }
    }

    function imageValidator($post_array = array(), $field_name = array(), $page_name)
    {

        $i = 0;
        $error_array = array();
        $error_checker = 0;
        //check for empty
        foreach ($post_array as $key => $value) {

            if ($this->validateData($value, 'empty') == false) {

                $error_array[] = $field_name[$i] . ' is required!!!';
                $error_checker = 1;

            }
            $i++;
        }

        //ceheck for file size
        if ($post_array['file_size'] != "") {
            if ($this->validateData($post_array['file_size'], 'file_size') == false) {

                $error_array[] = 'Image must be less than 1mb';
                $error_checker = 1;

            }
        }


        //ceheck for file type
        if ($post_array['file_type'] != "") {
            if ($this->validateData($post_array['file_type'], 'file_type') == false) {

                $error_array[] = 'Please Upload an image';
                $error_checker = 1;

            }
        }


        //if the error checker is equal to 1, then there is an error  file_size
        if ($error_checker == 1) {

            $_SESSION['error_array'] = $error_array;
            //redirect the page to form and display errors
            header('location:' . $page_name);
            die();

        }

    }


    function updateProfile()
    {

        $ed_firstName = mysqli_real_escape_string(self::$db_connector, $_POST['ed_firstName']);
        $ed_lastName = mysqli_real_escape_string(self::$db_connector, $_POST['ed_lastName']);
        $ed_middle_name = mysqli_real_escape_string(self::$db_connector, $_POST['ed_middle_name']);
        $ed_phone = mysqli_real_escape_string(self::$db_connector, $_POST['ed_phone']);

        //unset error session
        unset($_SESSION['error_array']);

        //run validation
        $this->UpdateProfileValidator(array('first_name' => $ed_firstName, 'last_name' => $ed_lastName, 'phone' => $ed_phone), array('First Name', 'Last Name', 'Phone Number'), 'profileUpdate.php');


        //get the unique id
        $unique_id = $_SESSION['user_unique_id'];

        //runn our update
        $query = "UPDATE user_tb SET first_name = '$ed_firstName', middle_name = '$ed_middle_name', lastname = '$ed_lastName', phone = '$ed_phone' WHERE unique_id = '$unique_id'";

        if (mysqli_query(self::$db_connector, $query)) {

            header("location:profileUpdate.php?success=Update was successful");

        } else {

            header("location:profileUpdate.php?error=An error occurred, please try again: " . mysqli_error(self::$db_connector));

        }

    }

    private function UpdateProfileValidator($post_array = array(), $field_name = array(), $page_name)
    {

        $i = 0;
        $error_array = array();
        $error_checker = 0;
        //check for empty
        foreach ($post_array as $key => $value) {

            if ($this->validateData($value, 'empty') == false) {

                $error_array[] = $field_name[$i] . ' is required!!!';
                $error_checker = 1;

            }
            $i++;
        }

        //check if phone is a number
        if ($post_array['phone'] != "") {
            if ($this->validateData($post_array['phone'], 'numeric') == false) {

                $error_array[] = 'Only numbers are required for phone field';
                $error_checker = 1;

            }
        }

        //if the error checker is equal to 1, then there is an error
        if ($error_checker == 1) {

            $_SESSION['error_array'] = $error_array;
            //redirect the page to form and display errors
            header('location:' . $page_name);
            die();

        }

    }

    function registerCourses()
    {

        //unique_id 	student_unique_id 	course_unique_id 	academic_year
        if (isset($_POST['course_id'])) {
            //grab the array of course unique id values
            $course_unique_id = $_POST['course_id'];
            $course_name = $_POST['course_name'];
            $student_unique_id = $_SESSION['user_unique_id'];
            $academic_year = mysqli_real_escape_string(self::$db_connector, $_POST['academic_year']);

            //loop through the array and insert each value into the db
            unset($_SESSION['error_array']);
            $error_array = array();
            $error_checker = 0;
            $insert_checker = 0;
            for ($i = 0; $i < count($course_unique_id); $i++) {


                //check if this particular student has registered for this course before
                $query = "SELECT * FROM course_reg_tb WHERE student_unique_id = '$student_unique_id' AND course_unique_id = '$course_unique_id[$i]' AND academic_year = '$academic_year'";
                if ($result = mysqli_query(self::$db_connector, $query)) {

                    if (mysqli_num_rows($result) > 0) {
                        $error_checker = 1;
                        $error_array[] = $course_name[$i] . ' already exist and cant be registered again';
                        continue;
                    }

                }

                //create unique id on each iteration
                $unique_id = $this->createUniqueId('course_reg_tb', 'unique_id');

                //insert the values into the db
                $query = "INSERT INTO course_reg_tb (id, unique_id, student_unique_id, course_unique_id, academic_year) VALUES (null,'" . $unique_id . "','" . $student_unique_id . "','" . mysqli_real_escape_string(self::$db_connector, $course_unique_id[$i]) . "','" . $academic_year . "')";
                if (mysqli_query(self::$db_connector, $query)) {

                    //change the value to 1
                    $insert_checker = 1;

                }

            }

            if ($insert_checker == 1) {
                if ($error_checker == 1) {
                    $_SESSION['error_array'] = $error_array;
                }
                header("location:course_reg.php?success=Courses were registered successfully");
            } else {
                if ($error_checker == 1) {
                    $_SESSION['error_array'] = $error_array;
                }
                header("location:course_reg.php?error=Course registration failed");
            }


        } else {
            header('location:course_reg.php?error=Please select atleast a course');
        }

        //mysqli_real_escape_string(self::$db_connector, );

    }


//admin registration processing
    function processAdmin()
    {
        $fullName = $_SESSION['fullName'] = mysqli_real_escape_string(self::$db_connector, $_POST['fullName']);
        $username = $_SESSION['username'] = mysqli_real_escape_string(self::$db_connector, $_POST['username']);
        $email = $_SESSION['email'] = mysqli_real_escape_string(self::$db_connector, $_POST['email']);
        $phoneNumber = $_SESSION['phoneNumber'] = mysqli_real_escape_string(self::$db_connector, $_POST['phoneNumber']);
        $gender = $_SESSION['gender'] = mysqli_real_escape_string(self::$db_connector, $_POST['gender']);
        $password = $_SESSION['password'] = mysqli_real_escape_string(self::$db_connector, $_POST['password']);
        $conpassword = $_SESSION['conpassword'] = mysqli_real_escape_string(self::$db_connector, $_POST['conpassword']);
        $file_name = $_FILES['passport']['name'];
        $file_size = $_FILES['passport']['size'];
        $file_type = $_FILES['passport']['type'];
        $file_tmp = $_FILES['passport']['tmp_name'];

        //form validation
        //build an associative array for the form validation
        $post_array = array("fullName" => $fullName, "username" => $username, "email" => $email, "phoneNumber" => $phoneNumber, "gender" => $gender, "password" => $password, "conpassword" => $conpassword, "file_size" => $file_size, "file_type" => $file_type);

        //create the field names for the different fields
        $field_name = array("Full Name", "User Name", "Email", "Phone Number", "Gender", "Password", "Confirm Password", "Image Size", "Image Type");

        //unset the error session
        unset($_SESSION['error_array']);

        $this->adminFormValidator($post_array, $field_name, 'admin_reg.php');

        //prepare data for insert to db

        //create unique id
        $admin_unique_id = $this->createUniqueId('user_tb', 'unique_id');

        //create reg no
        $reg_no = rand(1000, 9999);
        $reg_no = self::ACADEMIC_YEAR . $reg_no;

        $h_password = $this->hasHer($password, self::SALT);

        //preparing the image for insertion into the database
        //exploding the image extension
        $exploded_extension = explode('/', $file_type);

        $newName = 'admin' . microtime() . '.' . $exploded_extension[1];

        $path = 'img/admin_passport/' . $newName;

        //moving the uploaded file
        move_uploaded_file($file_tmp, $path);

        //admin_unique_id 	admin_name
        $query = "INSERT INTO admin_tb (id, admin_unique_id, admin_name, admin_username, admin_gender, admin_phone, admin_email, admin_password, admin_passport) VALUES (null,'" . $admin_unique_id . "','" . $fullName . "','" . $username . "','" . $gender . "','" . $phoneNumber . "','" . $email . "','" . $h_password . "','" . $newName . "')";
        if (mysqli_query(self::$db_connector, $query)) {

            //unset the sessions
            unset($_SESSION['fullName']);
            unset($_SESSION['username']);
            unset($_SESSION['gender']);
            unset($_SESSION['phoneNumber']);
            unset($_SESSION['email']);
            unset($_SESSION['password']);
            unset($_SESSION['conpassword']);
            unset($_SESSION['error_array']);


            header("location:admin_login.php?success=Registration was successful!!!");

        } else {

            header("location:register.php?db_error=" . mysqli_error(self::$db_connector));

        }

    }


    function adminFormValidator($post_array = array(), $field_name = array(), $page_name)
    {
        $i = 0;
        $error_array = array();
        $error_checker = 0;
        //check for empty
        foreach ($post_array as $key => $value) {

            if ($this->validateData($value, 'empty') == false) {

                $error_array[] = $field_name[$i] . ' is required!!!';
                $error_checker = 1;

            }
            $i++;
        }

        //ceheck for valid email
        if ($post_array['email'] != "") {
            if ($this->validateData($post_array['email'], 'valid_email') == false) {

                $error_array[] = 'Please supply a valid Email';
                $error_checker = 1;

            }
        }

        //check if phone is a number
        if ($post_array['phoneNumber'] != "") {
            if ($this->validateData($post_array['phoneNumber'], 'numeric') == false) {

                $error_array[] = 'Only numbers are required for phone field';
                $error_checker = 1;

            }
        }

        //check for password match
        if ($post_array['password'] != "" && $post_array['conpassword'] != "") {
            if ($this->validateData($post_array['password'], 'password_match', $post_array['conpassword']) == false) {

                $error_array[] = 'Password does not match!!!';
                $error_checker = 1;

            }
        }


        //validate password lenght
        if ($post_array['password'] != "") {
            if ($this->validateData($post_array['password'], 'alphanumeric') == false) {

                $error_array[] = 'Password should contain numbers and alphabet!';
                $error_checker = 1;

            }
        }

        //validate password for alphanumeric
        if ($post_array['password'] != "") {
            if ($this->validateData($post_array['password'], 'password_len') == false) {

                $error_array[] = 'Password must be more than 8 or equal t 8 characters';
                $error_checker = 1;

            }
        }

        //validate password for alphanumeric
        if ($post_array['phoneNumber'] != "") {
            if ($this->validateData($post_array['phoneNumber'], 'phone_len') == false) {

                $error_array[] = 'phone must be be up to 11 characters';
                $error_checker = 1;

            }
        }
        //echo mysqli_num_rows($result); die();
        //validate password for alphanumeric
        if ($post_array['email'] != "") {
            if ($this->validateData($post_array['email'], 'unique_email', "", "admin_tb") == false) {

                $error_array[] = 'Email address already exists';
                $error_checker = 1;

            }
        }

        //ceheck for file size
        if ($post_array['file_size'] != "") {
            if ($this->validateData($post_array['file_size'], 'file_size') == false) {

                $error_array[] = 'Image must be less than 1mb';
                $error_checker = 1;

            }
        }


        //ceheck for file type
        if ($post_array['file_type'] != "") {
            if ($this->validateData($post_array['file_type'], 'file_type') == false) {

                $error_array[] = 'Please Upload an image';
                $error_checker = 1;

            }
        }

        //if the error checker is equal to 1, then there is an error
        if ($error_checker == 1) {

            $_SESSION['error_array'] = $error_array;
            //redirect the page to form and display errors
            header('location:' . $page_name);
            die();

        }
    }

//admin login
    function adminLogin()
    {

        //get the form values
        $login_password = mysqli_real_escape_string(self::$db_connector, $_POST['login_password']);
        $login_email = mysqli_real_escape_string(self::$db_connector, $_POST['login_email']);

        //unset error session
        unset($_SESSION['error_array']);

        //run validation
        $this->adminLoginValidator(array('email' => $login_email, 'password' => $login_password), $field_name = array('Email', 'Password'), 'login.php');

        //hash the pasword
        $h_password = $this->hasHer($login_password, self::SALT);

        //run a select to check if the values actually exists
        $query = "SELECT * FROM admin_tb WHERE admin_email = '$login_email' AND admin_password = '$h_password'";

        //run the query
        if ($result = mysqli_query(self::$db_connector, $query)) {
            //print_r(mysqli_num_rows($result)); die();
            //check if one row
            if (mysqli_num_rows($result) == 1) {


                while ($row = mysqli_fetch_assoc($result)) {

                    $admin_unique_id = $row['admin_unique_id'];
                    $email = $row['admin_email'];

                    /*print_r($admin_unique_id);
                         die();*/
                }

                //set the sessions using the values returned from the db
                $_SESSION['logged'] = TRUE;
                $_SESSION['admin_unique_id'] = $admin_unique_id;
                $_SESSION['admin_email'] = $email;

                //redirect to the user dashboard
                header("location:admin_dashboard.php");

            } else {

                header("location:admin_login.php?error=Incorrect Email/Password");
            }


        } else {

            header("location:admin_login.php?db_error=" . mysqli_error(self::$db_connector));

        }

    }

    function adminLoginValidator($post_array = array(), $field_name = array(), $page_name)
    {

        $i = 0;
        $error_array = array();
        $error_checker = 0;
        //check for empty
        foreach ($post_array as $key => $value) {

            if ($this->validateData($value, 'empty') == false) {

                $error_array[] = $field_name[$i] . ' is required!!!';
                $error_checker = 1;

            }
            $i++;
        }

        //ceheck for valid email
        if ($post_array['email'] != "") {
            if ($this->validateData($post_array['email'], 'valid_email') == false) {

                $error_array[] = 'Please supply a valid Email';
                $error_checker = 1;

            }
        }


        //if the error checker is equal to 1, then there is an error
        if ($error_checker == 1) {

            $_SESSION['error_array'] = $error_array;
            //redirect the page to form and display errors
            header('location:' . $page_name);
            die();

        }

    }

    function check_adminLogin($page)
    {

        if (!isset($_SESSION['logged'])) {

            header("location:$page?error=please login first");
            die();
        }

    }

    function selectOneAdminDetail($table_name, $unique_id)
    {

        $query = "SELECT * FROM $table_name WHERE admin_unique_id = '$unique_id'";

        if ($result = mysqli_query(self::$db_connector, $query)) {

            if (mysqli_num_rows($result) > 0) {

                //decalre an array  to catch the values
                $value_to_returned = array();

                //loop through the result and rreturn each row
                while ($row = mysqli_fetch_object($result)) {

                    $value_to_returned[] = $row;

                }
                return $value_to_returned;
            } else {

                return 'No data was found';

            }

        } else {

            return 'An error occurred : ' . mysqli_error(self::$db_connector);

        }

    }

    function addCourses()
    {
        //course_title course_code course_desc
        $course_title = mysqli_escape_string(self::$db_connector, $_POST['course_title']);
        $course_code = mysqli_real_escape_string(self::$db_connector, $_POST['course_code']);
        $course_desc = mysqli_real_escape_string(self::$db_connector, $_POST['course_desc']);

        //creating the course unique id;
        $unique_id = $this->createUniqueId('course_tb', 'course_unique_id');
        $course_unique_id = "COS/$unique_id";

        $this->courseValidator(array('course_title' => $course_title, 'course_code' => $course_code, 'course_desc' => $course_desc), array('Course Title', 'Course Code', 'Course Description'), 'admin_dashboard.php');

        $query = "insert into course_tb (id, course_unique_id, course_name, course_code, course_desc) values (null,'" . $course_unique_id . "','" . $course_title . "','" . $course_code . "','" . $course_desc . "')";

        if (mysqli_query(self::$db_connector, $query)) {

            unset($_SESSION['error_array']);

            header("location:admin_dashboard.php?success=" . $course_title . " course was successfully added!!!");

        } else {

            header("location:admin_dashboard.php?db_error=" . mysqli_error(self::$db_connector));

        }
    }

    function courseValidator($post_array = array(), $field_name = array(), $page_name)
    {

        $i = 0;
        $error_array = array();
        $error_checker = 0;
        //check for empty
        foreach ($post_array as $key => $value) {

            if ($this->validateData($value, 'empty') == false) {

                $error_array[] = $field_name[$i] . ' is required!!!';
                $error_checker = 1;

            }
            $i++;
        }


        //if the error checker is equal to 1, then there is an error
        if ($error_checker == 1) {

            $_SESSION['error_array'] = $error_array;
            //redirect the page to form and display errors
            header('location:' . $page_name);
            die();

        }

    }

    function addAcadYear()
    {
        $academicYear = $_SESSION['academic_year'] = mysqli_real_escape_string(self::$db_connector, $_POST['academic_year']);


        $this->acadValidator($_SESSION['academic_year'], "Academic Year", "admin_dashboard.php");

        //checking if the academic year is already active
        $query = "SELECT * FROM academic_year where academic_year = $academicYear";

        if ($result = mysqli_query(self::$db_connector, $query)) {
            if (mysqli_num_rows($result) === 0) {

                $query = "UPDATE academic_year SET academic_year = '$academicYear', status ='active' WHERE unique_id = 'qwererrtdf'";

                if (mysqli_query(self::$db_connector, $query)) {

                    unset($_SESSION['error_array']);
                    header("location:admin_dashboard.php?success=Academic Year update successful!!!");

                } else {
                    header("location:admin_dashboard.php?error='Academic Year update failed'");
                }
            } else {
                header("location:admin_dashboard.php?error=Academic Year is already active!!!");
            }
        }

    }

    function acadValidator($post_array, $field_name, $page_name)
    {

        $error_array = array();
        $error_checker = 0;
        //check for empty


        if ($this->validateData($post_array, 'empty') == false) {

            $error_array[] = $field_name . ' is required!!!';
            $error_checker = 1;

        }

        //if the error checker is equal to 1, then there is an error
        if ($error_checker == 1) {

            $_SESSION['error_array'] = $error_array;
            //redirect the page to form and display errors
            header('location:' . $page_name);
            die();

        }

    }

    function updateStudentProfile()
    {


        $firstName = mysqli_real_escape_string(self::$db_connector, $_POST['firstName']);
        $middleName = mysqli_real_escape_string(self::$db_connector, $_POST['middleName']);
        $lastName = mysqli_real_escape_string(self::$db_connector, $_POST['lastName']);
        $email = mysqli_real_escape_string(self::$db_connector, $_POST['email']);
        $phoneNumber = mysqli_real_escape_string(self::$db_connector, $_POST['phoneNumber']);
        $gender = mysqli_real_escape_string(self::$db_connector, $_POST['gender']);
        $dob = mysqli_real_escape_string(self::$db_connector, $_POST['dob']);
        $password = mysqli_real_escape_string(self::$db_connector, $_POST['password']);


        //form validation
        //build an associative array for the form validation
        $post_array = array("firstName" => $firstName, "middleName" => $middleName, "lastName" => $lastName, "email" => $email, "phoneNumber" => $phoneNumber, "gender" => $gender, "dob" => $dob, "password" => $password);

        //create the field names for the different fields
        $field_name = array("First Name", "Middle Name", "Last Name", "Email", "Phone Number", "Gender", "Date of Birth", "Password");

        //unset the error session
        unset($_SESSION['error_array']);

        $this->updateDetailsValidator($post_array, $field_name, 'update_student_profile.php');

        //prepare data for insert to db

        //create unique id
//        $unique_id = $this->createUniqueId('user_tb', 'unique_id');

        $h_password = $this->hasHer($password, self::SALT);
        $unique_id = $_SESSION['get_user_id'];
        unset($_SESSION['error_array']);

        $query = "update user_tb set first_name = '$firstName', middle_name = '$middleName', lastname = '$lastName', email = '$email', password = '$h_password', phone = '$phoneNumber', gender = '$gender',dob = '$dob'where unique_id = '$unique_id'";

        if (mysqli_query(self::$db_connector, $query)) {

            //unset the sessions
            unset($_SESSION['firstName']);
            unset($_SESSION['middleName']);
            unset($_SESSION['lastName']);
            unset($_SESSION['email']);
            unset($_SESSION['phoneNumber']);
            unset($_SESSION['gender']);
            unset($_SESSION['password']);
            unset($_SESSION['error_array']);

            header("location:update_student_profile.php?success=Student information was successfully updated!!!&user_id=$unique_id");

        } else {

            header("location:update_student_profile.php?db_error=" . mysqli_error(self::$db_connector));

        }

    }


    function updateDetailsValidator($post_array = array(), $field_name = array(), $page_name)
    {
        $user_id = $_SESSION['get_user_id'];
        $error_array = array();
        $error_checker = 0;

        //ceheck for valid email
        if ($post_array['email'] != "") {
            if ($this->validateData($post_array['email'], 'valid_email') == false) {

                $error_array[] = 'Please supply a valid Email';
                $error_checker = 1;

            }
        }

        //check if phone is a number
        if ($post_array['phoneNumber'] != "") {
            if ($this->validateData($post_array['phoneNumber'], 'numeric') == false) {

                $error_array[] = 'Only numbers are required for phone field';
                $error_checker = 1;

            }
        }


        //validate birthday format
        if ($post_array['dob'] != "") {
            if ($this->validateData($post_array['dob'], 'birthday_format') == false) {

                $error_array[] = 'Please use the date picker to your birthday!';
                $error_checker = 1;

            }
        }

        //validate password length
        if ($post_array['password'] != "") {
            if ($this->validateData($post_array['password'], 'alphanumeric') == false) {

                $error_array[] = 'Password should contain numbers and alphabet!';
                $error_checker = 1;

            }
        }

        //validate password for alphanumeric
        if ($post_array['password'] != "") {
            if ($this->validateData($post_array['password'], 'password_len') == false) {

                $error_array[] = 'Password must be more than 8 or equal t 8 characters';
                $error_checker = 1;

            }
        }

        //validate phone number length
        if ($post_array['phoneNumber'] != "") {
            if ($this->validateData($post_array['phoneNumber'], 'phone_len') == false) {

                $error_array[] = 'Phone Number must be be up to 11 characters';
                $error_checker = 1;

            }
        }

        //if the error checker is equal to 1, then there is an error
        if ($error_checker == 1) {

            $_SESSION['error_array'] = $error_array;
            //redirect the page to form and display errors
            header('location:'.$page_name."?user_id=$user_id");
            die();

        }

    }


    function change_student_courses()
    {

        //to add a course to the student's registered courses databased
        if (isset($_POST['add_courses'])) {

            $course_unique_id = $_POST['add_courses'];
            $academic_year = $_POST['academic_year'];
            $student_unique_id = $_SESSION['get_user_id'];

            $user_id = $_SESSION['get_user_id'];

            $error_array = $_SESSION['error_array'];
            $error_checker = 0;
            $insert_checker = 0;

            for ($i = 0; $i < count($course_unique_id); $i++) {

                //checking if the course has already been registered
                $query = "select * from course_reg_tb where course_unique_id = '$course_unique_id[$i]' and student_unique_id = '$student_unique_id'";
                unset($error_array);

                $student_detail = $this->selectOneCourseDetail('course_tb', "$course_unique_id[$i]");
                if ($result = mysqli_query(self::$db_connector, $query)) {
                    if (mysqli_num_rows($result) > 0) {

                        $error_array[] = $student_detail[0]->course_name . ' is already existing and cannot be re-registered';
                        $error_checker = 1;

                    }
                    else{
                        $unique_id = $this->createUniqueId('course_reg_tb', 'unique_id');

                        //insert the values into the db
                        $query = "INSERT INTO course_reg_tb (id, unique_id, student_unique_id, course_unique_id, academic_year) VALUES (null,'" . $unique_id . "','" . $student_unique_id . "','" . mysqli_real_escape_string(self::$db_connector, $course_unique_id[$i]) . "','" . $academic_year . "')";
                        if (mysqli_query(self::$db_connector, $query)) {

                            //change the value to 1
                            $insert_checker = 1;
                            unset($error_array);
                        }
                    }
                }




            }

            if ($insert_checker == 1) {
                if ($error_checker == 1) {
                    $_SESSION['error_array'] = $error_array;
                }
                header("location:update_student_profile.php?success=Courses were registered successfully&user_id=$user_id");
            } else {
                if ($error_checker == 1) {
                    $_SESSION['error_array'] = $error_array;
                }
                header("location:update_student_profile.php?error=Course registration failed&user_id=$user_id");
            }

            
            if ($error_checker == 1) {

                $_SESSION['error_array'] = $error_array;
                //redirect the page to form and display errors
                header("location:update_student_profile?db_error=Please select another course&user_id=$user_id");
                die();

            }
        }
        }


        function remove_a_course(){

            if (isset($_POST['remove_courses'])) {

                //to remove the courses
                $course_unique_id = $_POST['remove_courses'];
                $academic_year = $_POST['academic_year'];
                $student_unique_id = $_SESSION['get_user_id'];

                $user_id = $_SESSION['get_user_id'];

                $error_array = $_SESSION['error_array'];

                for ($i = 0; $i < count($course_unique_id); $i++) {

                    //checking if the course is registered
                    $query = "select * from course_reg_tb where course_unique_id = '$course_unique_id[$i]' and student_unique_id = '$student_unique_id'";
                    /*                    print_r($course_unique_id[$i]);*/
                    unset($error_array);
//                $student_detail = $this->selectOneCourseDetail('course_tb', "$course_unique_id[$i]");

                    if ($result = mysqli_query(self::$db_connector, $query)) {
                        if (mysqli_num_rows($result) >= 1) {


                            $query = "delete from course_reg_tb where course_unique_id = '$course_unique_id[$i]'";

                            if (mysqli_query(self::$db_connector, $query)) {

                                header("location:update_student_profile.php?success=Course has been removed successfully&user_id=$user_id");

                            } else {
                                header("location:update_student_profile.php?db_error=Database Error:" . mysqli_error(self::$db_connector) . "&user_id=$user_id");

                            }
                        }else{

                            header("location:update_student_profile.php?db_error=This course is not yet registered&user_id=$user_id");

                        }
                    }
                }
            }


        }
            function selectOneCourseDetail($table_name, $unique_id)
        {

            $query = "SELECT * FROM $table_name WHERE course_unique_id = '$unique_id'";

            if ($result = mysqli_query(self::$db_connector, $query)) {

                if (mysqli_num_rows($result) > 0) {

                    //decalre an array  to catch the values
                    $value_to_returned = array();

                    //loop through the result and rreturn each row
                    while ($row = mysqli_fetch_object($result)) {

                        $value_to_returned[] = $row;

                    }
                    return $value_to_returned;
                } else {

                    return 'No data was found';

                }

            } else {

                return 'An error occurred : ' . mysqli_error(self::$db_connector);

            }

        }

}


$obj = new processor();

?>