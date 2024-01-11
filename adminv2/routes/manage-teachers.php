<!-- MAIN -->
<main>
    <div class="head-title">
        <div class="left">
            <h1>Manage Teachers</h1>
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
                <button class="btn-primary" id="addTeacherBtn" style="font-size: 14px;
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

        <!-- ADD MODAL START -->
        <div id="addTeacherModal" class="modal" style="width: 0%;">
            <div class="modal-overlay"></div>
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="modal-header">
                    <h5 class="modal-title">Add Teacher</h5>
                </div>
                <hr style="margin-bottom:10px;">
                <form id="addTeacherForm" method="POST">

                    <div class="form-group">
                        <label for="student_id">Teacher ID:</label>
                        <input type="text" class="form-control" id="teacherId" name="teacherId">
                    </div>

                    <div class="form-group">
                        <label for="firstname">Firstname:</label>
                        <input type="text" class="form-control" id="firstName" name="firstName">
                    </div>

                    <div class="form-group">
                        <label for="lastname">Lastname:</label>
                        <input type="text" class="form-control" id="lastName" name="lastName">
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select name="gender" id="pickgender" class="form-control">
                            <option value="" selected disabled>-- Select Gender --</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <p style="text-align: center;">----------------------------------------------------</p>

                    <div class="btn-container">
                        <button type="button" class="btn-cancel btn-danger" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="btn-primary">Add Teacher</button>
                    </div>

                </form>
            </div>
        </div>
        <!-- ADD MODAL END -->

</main>
<!-- MAIN -->
<!-- teacher modal -->
<script src="js/teacher-modal.js"></script>
<!-- JS AND JQUERY FOR PAGINATION -->
<script src="js/teacher-datatable-pagination.js"></script>
<!-- sweet alert  -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>