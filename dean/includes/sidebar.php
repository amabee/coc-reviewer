<!-- Sidebar -->


<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
    <!-- <i class="fa-regular fa-user-tie"></i> -->

      
        <div class="sidebar-brand-text mx-3">Dean</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Student Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
 
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-graduation-cap"></i>
            <span>Students Performance</span>
        </a>
        <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Performance Overview:</h6>
                <!-- <a class="collapse-item" href="#" data-toggle="modal" data-target="#addStudentModal">Add Students</a> -->
                <a class="collapse-item" href="studentlist.php">View Student List</a>
            </div>
        </div>
    </li>
    
 

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Teacher Interface -->
    <div class="sidebar-heading">
        Teacher Interface
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTeachers" aria-expanded="true" aria-controls="collapseTeachers">
            <i class="fas fa fa-users"></i>
            <span>Manage Teachers</span>
        </a>
        <div id="collapseTeachers" class="collapse" aria-labelledby="headingTeachers" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Manage Teachers:</h6>
                <!-- <a class="collapse-item" href="#" data-toggle="modal" data-target="#addTeacherModal">Add Teacher</a> -->
                <a class="collapse-item" href="teacherlist.php">Teacher List</a>
                <div class="collapse-divider"></div>
            </div>
        </div>
    </li>
   <hr class="sidebar-divider d-none d-md-block">


    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
