<div class="container-fluid">
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-3  col-lg-3 ml-0 bg-dark side_nav p-0">


            <div class="row mt-5 text-center">
                <div class="container-fluid col-xs-6 col-sm-12 col-md-12 col-lg-12 ">
            <div class=" col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-3 mt-4">
                <img src="img/passport/<?php echo $user_details[0]->passport; ?>" class="img-fluid rounded-circle">
                <br>
            </div>
                <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2 pl-4 pr-4">
                <form action="processor.php?action_to_perform=upload_image" method="post" enctype="multipart/form-data" >
                	<div class="row">
                        <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-7 mt-2 pr-1">
                    <input type="file" name="passport" class="form-control">
                        </div>

                        <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-5 mt-2 pl-1">
                	<button class="btn btn-info btn-sm mt-1" type="submit">Upload Image</button>
                        </div>

                    </div>
                </form>
                </div>

            </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4 text-center text-white">
            <p><?php echo $user_details[0]->lastname.' '.$user_details[0]->first_name.' '.$user_details[0]->middle_name ?><br><a href="#"><?php echo $user_details[0]->email ?></a></p>
                <hr>
            </div>





            <div class="container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1 pl-0 pr-0">
            <nav class="navbar-nav text-white mt-1 ml-0">
                    <ul class="p-0 ml-0">
                    <li class="nav-link"><a href="dashboard.php" class="text-white ml-5"><i class="mdi mdi-account-circle"></i> Profile</a></li>
                    <li class="nav-link"><a href="course_reg.php" class="text-white ml-5"><i class="mdi mdi-book-open-page-variant"></i> Register Courses</a></li>
                    <li class="nav-link"><a href="dashboard.php#reg_course"  class="text-white ml-5"><i class="mdi mdi-book-outline"></i> View Registered Courses</a></li>
                    <li class="nav-link"><a href="profileUpdate.php" class="text-white ml-5"><i class="mdi mdi-account-edit"></i> Update Profile</a></li>
            </ul>
            </nav>
            </div>

            <div class="text-center mt-2">
                <a href="login.php"><button type="button" class="mt-2 bg-transparent border-white rounded-pill text-white out_btn">Log out</button></a>
            </div>
            <br>
            <div class="text-right mt-3 mb-2 mr-4">
                <p><a href="#">Report a problem</a></p>
            </div>
        </div>
            </div>
         </div>
</div>