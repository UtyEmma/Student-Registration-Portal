<div class="container-fluid">
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-3  col-lg-3 ml-0 bg-dark side_nav p-0">


            <div class="row mt-5">
                <div class="container-fluid col-xs-4 col-sm-4 col-md-4 col-lg-4 mt-5">
                    <img src="img/admin_passport/<?php echo $admin_details[0]->admin_passport; ?>" class="img-fluid rounded-circle">

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4 text-center text-white">
                    <p><?php echo $admin_details[0]->admin_name; ?><br><a href="#"><?php echo $admin_details[0]->admin_email; ?></a></p>
                    <hr>
                </div>

            </div>



            <div class="container-fluid col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1 pl-0 pr-0">
                <nav class="navbar-nav text-white mt-1 ml-0">
                    <ul class="p-0 ml-0">
                        <li class="nav-link"><a href="admin_dashboard.php#addCourses" class="text-white ml-5"><i class="mdi mdi-account-circle"></i> Add Courses</a></li>
                        <li class="nav-link"><a href="admin_dashboard.php#academicYear" class="text-white ml-5"><i class="mdi mdi-book-open-page-variant"></i> Change Academic Year</a></li>
                        <li class="nav-link"><a href="admin_dashboard.php#regCourses"  class="text-white ml-5"><i class="mdi mdi-book-outline"></i> All Students</a></li>
                    </ul>
                </nav>
            </div>

            <div class="text-center mt-3">
                <a href="login.php"><button type="button" class="mt-3 bg-transparent border-white rounded-pill text-white out_btn">Log out</button></a>
            </div>

            <br>
            <br>
            <div class="text-right mt-5 mb-2 mr-4">
                <p><a href="#">Report a problem</a></p>
            </div>

        </div>
    </div>
</div>