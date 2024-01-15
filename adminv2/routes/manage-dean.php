<!-- MAIN -->
<main>
    <div class="head-title">
        <div class="left">
            <h1>Manage Dean Account</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dean</a>
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
                <h3>Dean Accounts</h3>
                <button class="btn-primary" id="addDeanBtn" style="font-size: 14px;
  padding: 12px 20px; border-radius: 10px;">Add Dean<i class='bx bx-add-to-queue' style='color:white; margin-left: 5px;'></i></button>
            </div>
            <table id="studentTable">
                <thead>
                    <tr>

                        <th>Dean ID</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="dean-data-container">
                </tbody>
            </table>
            <div class="pagination">

            </div>

        </div>

        <!-- ADD MODAL DEAN START -->
        <div id="addDeanModal" class="modal" style="width: 0%;">
            <div class="modal-overlay"></div>
            <div class="modal-content">
                <span class="close" >&times;</span>
                <div class="modal-header">
                    <h5 class="modal-title">Add Dean</h5>
                </div>
                <hr style="margin-bottom:10px;">
                <form id="addDeanForm" method="POST">

                    <div class="form-group">
                        <label for="deanId">Dean ID:</label>
                        <input type="text" class="form-control" id="deanId" name="deanId">
                    </div>

                    <div class="form-group">
                        <label for="deanFirstName">Firstname:</label>
                        <input type="text" class="form-control" id="deanFirstName" name="deanFirstName">
                    </div>

                    <div class="form-group">
                        <label for="deanLastName">Lastname:</label>
                        <input type="text" class="form-control" id="deanLastName" name="deanLastName">
                    </div>

                    <div class="form-group">
                        <label for="deanGender">Gender:</label>
                        <select name="deanGender" id="pickDeanGender" class="form-control">
                            <option value="" selected disabled>-- Select Gender --</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="deanEmail">Email:</label>
                        <input type="email" class="form-control" id="deanEmail" name="deanEmail">
                    </div>

                    <p style="text-align: center;">----------------------------------------------------</p>

                    <div class="btn-container">
                        <button type="button" class="btn-cancel btn-danger" >Cancel</button>
                        <button type="submit" class="btn-primary">Add Dean</button>
                    </div>

                </form>
            </div>
        </div>
        <!-- ADD MODAL DEAN END -->

        <!-- UPDATE DEAN MODAL START -->
        <div id="updateDeanModal" class="modal" style="width: 0%;">
            <div class="modal-overlay"></div>
            <div class="modal-content">
                <span class="close close-update">&times;</span>
                <div class="modal-header">
                    <h5 class="modal-title">Update Dean</h5>
                </div>
                <hr style="margin-bottom:10px;">
                <form id="updateDeanForm" method="POST">

                    <div class="form-group">
                        <label for="updateDeanId">Dean ID:</label>
                        <input type="text" class="form-control" id="updateDeanId" name="updateDeanId" readonly>
                    </div>

                    <div class="form-group">
                        <label for="updateDeanFirstName">Firstname:</label>
                        <input type="text" class="form-control" id="updateDeanFirstName" name="updateDeanFirstName">
                    </div>

                    <div class="form-group">
                        <label for="updateDeanLastName">Lastname:</label>
                        <input type="text" class="form-control" id="updateDeanLastName" name="updateDeanLastName">
                    </div>

                    <div class="form-group">
                        <label for="updateDeanGender">Gender:</label>
                        <select name="updateDeanGender" id="updateDeanGender" class="form-control">
                            <option value="" selected disabled>-- Select Gender --</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="updateDeanEmail">Email:</label>
                        <input type="email" class="form-control" id="updateDeanEmail" name="updateDeanEmail">
                    </div>

                    <p style="text-align: center;">---------------------------------------------------------</p>

                    <div class="btn-container">
                        <button type="button" class="btn-cancel btn-danger close-dean">Cancel</button>
                        <button type="submit" id="updateDean" class="btn-primary">Update Dean</button>
                    </div>

                </form>
            </div>
        </div>
        <!-- UPDATE DEAN MODAL END -->



</main>
<!-- MAIN -->

<!-- JS AND JQUERY FOR PAGINATION -->
<script src="js/dean-datatable.js"></script>
<!-- JS FOR DEAN MODAL -->
<script src="js/dean-modal.js"></script>
<!-- sweet alert  -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>