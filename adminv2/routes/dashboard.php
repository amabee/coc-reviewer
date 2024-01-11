<!-- MAIN -->
<main>
    <div class="head-title">
        <div class="left">
            <h1>Dashboard</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Home</a>
                </li>
            </ul>
        </div>
    </div>

    <ul class="box-info">
        <li>
            <i class='bx bxs-calendar-check'></i>
            <span class="text">
                <h3>0</h3>
                <p>Total Active Students</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3>0</h3>
                <p>Total Active Teachers</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-dollar-circle'></i>
            <span class="text">
                <h3>89%</h3>
                <p>Passing Rate</p>
            </span>
        </li>
    </ul>

    <!-- TABLE AREA -->

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Student Overview</h3>
            </div>
            <table id="studentTable">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Student ID</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="student-data-container">
                </tbody>
            </table>
            <div class="pagination">

            </div>

        </div>

</main>
<!-- MAIN -->

<!-- JS AND JQUERY FOR PAGINATION -->
<script src="js/student-datatable-pagination.js"></script>