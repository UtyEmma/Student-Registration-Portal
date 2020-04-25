<?php

class library{
	
	STATIC $db_connector;

	var $host = "localhost";
	var $username = "root";
	var $password = "";
	var $databasename = "registration_platform";
	const ACADEMIC_YEAR = "TECH/2019/";
	const SALT = 'sha256';
	
	function __construct(){
		
		$this->returnDbConnect();
		
	}
	
	private function connectToDb(){
	
		//connect to db
		self::$db_connector = mysqli_connect($this->host,$this->username,$this->password) or mysqli_error($this->db_connector);
		
		//select a particular db
		mysqli_select_db(self::$db_connector, $this->databasename);
		
	}
	
	//returns the db connection
	public function returnDbConnect(){
		
		$this->connectToDb();
		return self::$db_connector;
		
	}
	
	//method that creates a db
	function createDb($db_name){
		
		$query = "CREATE DATABASE $db_name";
		if(mysqli_query(self::$db_connector, $query)){
			return 'Database was created successfully';
		}else{
			return 'Database error: '.mysqli_error(self::$db_connector);
		}
		
	}
	

	//create table function
	function createUserTable(){
		
		$query = "CREATE TABLE IF NOT EXISTS user_tb (
		id int(20) primary key AUTO_INCREMENT,
		unique_id VARCHAR(100) NULL,
		first_name VARCHAR(100) NULL,
		middle_name VARCHAR(100) NULL,
		lastname VARCHAR(100) NULL,
		email VARCHAR(100) NULL UNIQUE,
		password VARCHAR(100) NULL,
		phone VARCHAR(100) NULL,
		reg_no VARCHAR(100) NULL
		)";
		
		if(mysqli_query(self::$db_connector, $query)){
			return 'User Table was created successfully';
		}else{
			return 'Database error: '.mysqli_error(self::$db_connector);
		}
		
	}
	
	function createCourseTb(){
		
		//course_unique_id,course_name,course_code,course_desc
		$query = "CREATE TABLE IF NOT EXISTS course_tb (
		id int(20) primary key AUTO_INCREMENT,
		course_unique_id VARCHAR(100) UNIQUE NULL,
		course_name VARCHAR(100) NULL,
		course_code VARCHAR(100) NULL,
		course_desc VARCHAR(100) NULL
		)";
		
		if(mysqli_query(self::$db_connector, $query)){
			return 'Course table was created successfully';
		}else{
			return 'Database error: '.mysqli_error(self::$db_connector);
		}
		
	}
//unique_id,student_unique_id,course_unique_id,academic_year
	function createCourseRegTb(){
		
		//course_unique_id,course_name,course_code,course_desc
		$query = "CREATE TABLE IF NOT EXISTS course_reg_tb (
		id int(20) primary key AUTO_INCREMENT,
		unique_id VARCHAR(100) UNIQUE NULL,
		student_unique_id VARCHAR(100) NULL,
		course_unique_id VARCHAR(100) NULL,
		academic_year VARCHAR(100) NULL
		)";
		
		if(mysqli_query(self::$db_connector, $query)){
			return 'Course Registration table was created successfully';
		}else{
			return 'Database error: '.mysqli_error(self::$db_connector);
		}
		
	}

	
	function validateData($value, $validation_type, $value2 = "", $table_name = ""){
	
	//when valiudation fails, we return false
	if($validation_type === 'empty'){
		
		if(empty($value)){
			return false;
		}
		
	}
	
	if($validation_type === 'numeric'){
		
		if(!is_numeric($value)){
			return false;
		}
		
	}
	
	if($validation_type === 'valid_email'){
		
		if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
			return false;
		}
		
	}

        //check for unique_email
        if($validation_type === 'unique_email'){

            $query = "SELECT * FROM $table_name WHERE email = '$value'";

            if($result = mysqli_query(self::$db_connector, $query)){

                if(mysqli_num_rows($result) !== 0){
                    return false;
                }
            }else{
                return mysqli_error(self::$db_connector);
            }

        }
	
	//checks if passwords match
	if($validation_type === 'password_match'){
		
		if($value != $value2){
			return false;
		}
		
	}
	
	//checks if birthday format is correct
	if($validation_type === 'birthday_format'){
		
		$value_array = explode('-', $value);
		if(count($value_array) != 3){
			return false;
		}
		
	}
	
	//check if password is alphanumeric
	if($validation_type === 'alphanumeric'){
		
		if(!preg_match('/[^a-z_\-0-9]/i', $value)){
			return false;
		}
		
	}
	
	//check if password is upto 8 or more character
	if($validation_type === 'password_len'){
		
		if(strlen($value) < 8){
			return false;
		}
		
	}
	
	//check if password is upto 8 or more character
	if($validation_type === 'phone_len'){
		
		if(strlen($value) < 11){
			return false;
		}
		
	}
		
	//check for file size
	if($validation_type === 'file_size'){
		
		if($value > '1000000'){
			return false;
		}
		
	}
	
	//check for file type
	if($validation_type === 'file_type'){
		
		$image_array = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
		
		if(!in_array($value, $image_array)){
			return false;
		}
		
	}

        //check if course code is 6 characters
        if($validation_type === 'course_code_len'){

            if(strlen($value) != 6){
                return false;
            }

        }

        if ($validation_type === 'course_code'){
	        if (!preg_match('COS 101', '$value')){
	            return false;
            }
        }
/*	//validating the course code
        if ($validation_type === 'Valid_course_code'){
	        if (explode('/', $value, 3)){

            }

        }*/
	
	//if the validsation didnt fail
	return true;
	
}
	
	//create unique id
	public function picker(){
			
		$randpicker = rand(1,143);
		$pickerbox = array('RCA13','RCB12','RCC23','RCD43','RCE34','RCF56','RCG23','RCH34','RCI17','RCJ23','RCK34','RCL54','RCM56','RCN23','RCO34','RCP56','RCQ34','RCR32','RCS32','RCT34','RCU12','RCV43','RCW12','RCX34','RCY23','RCZ65','RTA76','RTB34','RTH45','RTC54','RTD65','RTE78','RTF67','RTG54','RTH34','RTI34','RTJ67','RTK12','RTL54','RTM76','RTN34','RTO87','RTP67','RTQ65','RTR34','RTS65','RTT67','RTU98','RTV78','RTW34','RTX64','RTY54','RTZ32','RPA43','RPB45','RPC34','RPD32','RPD56','RPE89','RPF87','RPG76','RPH23','RPI78','RPJ54','RPK45','RPL90','RPM43','RPN43','RPO56','RPP67','RPQ78','RPR43','RPS76','RPT34','RPU45','RPV67','RPW78','RPX56','RPY67','RPZ34','RRR09','REA90','REB56','REC54','RED67','REE78','REF54','REG','REH56','REI56','REJ34','REK87','REL56','REM54','REN45','REO43','REP78','REQ67','RER43','RES45','RET34','REU34','REV65','REW56','REX56','REY78','REZ43','RDA65','RDB67','RDC34','RDD23','RDE87',"RAA87","RBH54","RHJ65","RKK45","RWH43","RBB45","RFC67","RGC54","RHC90","RJC43","RKC67","TLC34","TZC54","TXC34","TCC34","TVC67","TBC54","TNC54","TDO56","TDT67","TTT45","TAG54","TAH34","TAS54","TAR45","TAC78","TAT67","TAZ34","TSY54","TSB54","TZX78","TQO65","TAP45");

		//pick a particular value from the array
		$shuff = $pickerbox[$randpicker];

		//create a unique id
		$unique_id = uniqid();
		//get the lenght oif the create unique id
		$unique_id_len = strlen($unique_id);
		//return part of the unique id created
		$main = $shuff.substr($unique_id, $unique_id_len/2);
		return $main; 

	}
	
	function createUniqueId($table_name, $column_name){
		
		$unique_id = $this->picker();
		
		$query = "SELECT * FROM $table_name WHERE $column_name = '$unique_id'";
		if($result = mysqli_query(self::$db_connector, $query)){
			if(mysqli_num_rows($result) !== 0){
				//recursive call
				$this->createUniqueId($table_name, $column_name);
			}else{
				return $unique_id;
			}
			
		}else{
			return mysqli_error(self::$db_connector);
		}
		
		
		
	}
	
	function hasHer($password, $salt){
			return hash($salt, md5($password));
	}



	function selectFromAnyTable($query){
//		echo $query; die();
		if($result = mysqli_query(self::$db_connector, $query)){
			
			if(mysqli_num_rows($result) > 0){
				
				//declare an array to hold the returned values
				$values_to_be_returned = array();

				while($row = mysqli_fetch_object($result)){
					
					$values_to_be_returned[] = $row;
					
				}
				
				return $values_to_be_returned;
				
			}else{
				return 'An error occurred: '.mysqli_error(self::$db_connector);
			}
			
		}
		
	}
	
	
	//a function to pick year from 1999 to 2100
    function selectYear(){

	    $year = range(1999, 2100);

	    return $year;

	    
    }


    function selectAColumnFromAnyTable($table_name, $column_name, $clause, $selected_column){
		$query = "SELECT * FROM $table_name WHERE $column_name = '$clause'";
		if($result = mysqli_query(self::$db_connector, $query)){
			
			if(mysqli_num_rows($result) > 0){
				
			
				while($row = mysqli_fetch_assoc($result)){

					$value = $row[$selected_column];

				}
				
				return $value;
				
			}else{
				return 'An error occurred: '.mysqli_error(self::$db_connector);
			}
			
		}
		
	}
	
}

//$obj = new library();
//$obj::$db_connector;

//create a database
//echo $obj->createDb('registration_platform');

//create table user table
//echo $obj->createUserTable();

//create course table
//echo $obj->createCourseTb();

//create the course registration table
//echo $obj->createCourseRegTb();

//create academic year table
//echo $obj->createAcademicYearTb();
?>