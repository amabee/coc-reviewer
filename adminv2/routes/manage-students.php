<!-- MAIN -->
<main>
    <div class="head-title">
        <div class="left">
            <h1>Manage Students</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Students</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- TABLE AREA -->
    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Student List</h3>
                <button class="btn btn-primary" id="addStudentBtn" style="  font-size: 14px;
                        padding: 12px 20px; border-radius: 10px;">Add Student<i class='bx bx-add-to-queue'
                        style='color:white; margin-left: 5px;'></i></button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Student ID</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="student-data-container">
                </tbody>
            </table>
            <div class="pagination">
            </div>
        </div>
    </div>


    <!-- MODAL START -->
    <div id="addStudentModal" class="modal">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-header">
                <h5 class="modal-title">Add Student</h5>
            </div>
            <hr style="margin-bottom:10px;">
            <form id="addStudentForm" method="POST">

                <div class="form-group">
                    <label for="student_id">Student ID:</label>
                    <input type="text" class="form-control" id="studentId" name="studentId" required>
                </div>

                <div class="form-group">
                    <label for="firstname">Firstname:</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                </div>

                <div class="form-group">
                    <label for="lastname">Lastname:</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select name="gender" id="pickgender" class="form-control" required>
                        <option value="" selected disabled>-- Select Gender --</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <p style="text-align: center;">------------------ OR ADD BY BATCH ----------------------</p>

                <div class="form-group">
                    <label for="fileUpload">Select Excel File:</label>
                    <input type="file" class="form-control" id="fileUpload" name="fileUpload" accept=".xls, .xlsx">

                </div>
                <div class="btn-container">
                    <button type="button" class="btn-cancel btn-danger" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-primary">Add Student</button>
                </div>

            </form>
        </div>
    </div>
    <!-- MODAL END -->

</main>
<!-- MAIN -->

<!-- JS AND JQUERY FOR PAGINATION -->
<script src="js/student-datatable-pagination.js"></script>
<script src="js/student-modal.js"></script>


<!-- sweet alert  -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>