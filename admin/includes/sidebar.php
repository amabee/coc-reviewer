<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-solid fa-user-tie"></i>
        </div>
        <div class="sidebar-brand-text mx-3">ADMIN <sup>PAGE</sup></div>
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
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-graduation-cap"></i>
            <span>Manage Students</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Manage Students:</h6>
                <a class="collapse-item" href="#" data-toggle="modal" data-target="#addStudentModal">Add Students</a>
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
                <a class="collapse-item" href="teacher_list.html">Teacher List</a>
                <a class="collapse-item" href="add_teacher.html">Add Teacher</a>
                <div class="collapse-divider"></div>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Dean's Interface -->
    <div class="sidebar-heading">
        Faculty Interface
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDeans" aria-expanded="true" aria-controls="collapseDeans">
            <i class="fas fa fa-users"></i>
            <span>Manage Faculty</span>
        </a>
        <div id="collapseDeans" class="collapse" aria-labelledby="headingDeans" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Manage Faculty:</h6>
                <a class="collapse-item" href="view_dean_details.html">View Dean Details</a>
                <a class="collapse-item" href="view_dean_details.html">View Faculty</a>
                <div class="collapse-divider"></div>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Dean's Interface -->
    <div class="sidebar-heading">
        Class Interface
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClass" aria-expanded="true" aria-controls="collapseDeans">
            <i class="fas fa fa-users"></i>
            <span>Manage Class</span>
        </a>
        <div id="collapseClass" class="collapse" aria-labelledby="headingDeans" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Manage Section:</h6>
                <a class="collapse-item" href="view_dean_details.html">View Section list</a>
                <a class="collapse-item" href="view_dean_details.html">Add Section</a>
                <div class="collapse-divider"></div>
                <div class="dropdown-divider"></div>
                <a class="collapse-item" href="view_dean_details.html">Class Performance</a>
            </div>
        </div>
    </li>



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->