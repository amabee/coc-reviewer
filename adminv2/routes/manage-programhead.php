<!-- MAIN -->
<main>
    <div class="head-title">
        <div class="left">
            <h1>Manage Program Head Account</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Program Head</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Account Details</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Program Head Account</h3>
                <button class="btn-primary" id="addProgramHeadBtn" style="font-size: 14px;
  padding: 12px 20px; border-radius: 10px;">Add Program Head<i class='bx bx-add-to-queue' style='color:white; margin-left: 5px;'></i></button>
            </div>
            <table id="studentTable">
                <thead>
                    <tr>

                        <th>Program Head ID</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="ph-data-container">
                </tbody>
            </table>
            <div class="pagination">

            </div>

        </div>

        <!-- ADD MODAL PROGRAM HEAD START -->
        <div id="addProgramHeadModal" class="modal" style="width: 0%;">
            <div class="modal-overlay"></div>
            <div class="modal-content">
                <span class="close" id="closeAddProgramHeadModal">&times;</span>
                <div class="modal-header">
                    <h5 class="modal-title">Add Program Head</h5>
                </div>
                <hr style="margin-bottom:10px;">
                <form id="addProgramHeadForm" method="POST">

                    <div class="form-group">
                        <label for="programHeadId">Program Head ID:</label>
                        <input type="text" class="form-control" id="programHeadId" name="programHeadId">
                    </div>

                    <div class="form-group">
                        <label for="programHeadFirstName">Firstname:</label>
                        <input type="text" class="form-control" id="programHeadFirstName" name="programHeadFirstName">
                    </div>

                    <div class="form-group">
                        <label for="programHeadLastName">Lastname:</label>
                        <input type="text" class="form-control" id="programHeadLastName" name="programHeadLastName">
                    </div>

                    <div class="form-group">
                        <label for="programHeadGender">Gender:</label>
                        <select name="programHeadGender" id="pickProgramHeadGender" class="form-control">
                            <option value="" selected disabled>-- Select Gender --</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="programHeadEmail">Email:</label>
                        <input type="email" class="form-control" id="programHeadEmail" name="programHeadEmail">
                    </div>

                    <p style="text-align: center;">----------------------------------------------------</p>

                    <div class="btn-container">
                        <button type="button" class="btn-cancel btn-danger" id="cancelAddProgramHeadModal">Cancel</button>
                        <button type="submit" class="btn-primary">Add Program Head</button>
                    </div>

                </form>
            </div>
        </div>
        <!-- ADD MODAL PROGRAM HEAD END -->

        <!-- UPDATE PROGRAM HEAD MODAL START -->
        <div id="updateProgramHeadModal" class="modal" style="width: 0%;">
            <div class="modal-overlay"></div>
            <div class="modal-content">
                <span class="close close-update" id="closeUpdateProgramHeadModal">&times;</span>
                <div class="modal-header">
                    <h5 class="modal-title">Update Program Head</h5>
                </div>
                <hr style="margin-bottom:10px;">
                <form id="updateProgramHeadForm" method="POST">

                    <div class="form-group">
                        <label for="updateProgramHeadId">Program Head ID:</label>
                        <input type="text" class="form-control" id="updateProgramHeadId" name="updateProgramHeadId" readonly>
                    </div>

                    <div class="form-group">
                        <label for="updateProgramHeadFirstName">Firstname:</label>
                        <input type="text" class="form-control" id="updateProgramHeadFirstName" name="updateProgramHeadFirstName">
                    </div>

                    <div class="form-group">
                        <label for="updateProgramHeadLastName">Lastname:</label>
                        <input type="text" class="form-control" id="updateProgramHeadLastName" name="updateProgramHeadLastName">
                    </div>

                    <div class="form-group">
                        <label for="updateProgramHeadGender">Gender:</label>
                        <select name="updateProgramHeadGender" id="updateProgramHeadGender" class="form-control">
                            <option value="" selected disabled>-- Select Gender --</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="updateProgramHeadEmail">Email:</label>
                        <input type="email" class="form-control" id="updateProgramHeadEmail" name="updateProgramHeadEmail">
                    </div>

                    <p style="text-align: center;">---------------------------------------------------------</p>

                    <div class="btn-container">
                        <button type="button" class="btn-cancel btn-danger close-program-head">Cancel</button>
                        <button type="submit" id="updateProgramHead" class="btn-primary">Update Program Head</button>
                    </div>

                </form>
            </div>
        </div>
        <!-- UPDATE PROGRAM HEAD MODAL END -->


</main>
<!-- MAIN -->

<!-- JS AND JQUERY FOR PAGINATION -->
<script src="js/ph-datatable.js"></script>

<!-- JS AND JQUERY FOR MODAL -->
<script src="js/ph-modal.js"></script>
<!-- sweet alert  -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>