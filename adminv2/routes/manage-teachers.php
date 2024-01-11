<!-- MAIN -->
<main>
    <div class="head-title">
        <div class="left">
            <h1>Manage Students</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Manage Teachers</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Teachers</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- TABLE AREA -->

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Teacher List</h3>
                <button class="btn-primary" style="  font-size: 14px;
  padding: 12px 20px; border-radius: 10px;">Add Teacher<i class='bx bx-add-to-queue'
                        style='color:white; margin-left: 5px;'></i></button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Teacher ID</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="teacher-data-container">
                </tbody>
            </table>
            <div class="pagination">

            </div>

        </div>

</main>
<!-- MAIN -->

<!-- JS AND JQUERY FOR PAGINATION -->
<script src="js/teacher-datatable-pagination.js"></script>