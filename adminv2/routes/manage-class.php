<!-- MAIN -->
<main>
    <div class="head-title">
        <div class="left">
            <h1>Manage Class</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Manage Class</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Classlist</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- TABLE AREA -->

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Class List</h3>
                <button class="btn-primary" id="addSectionBtn" style="font-size: 14px; padding: 12px 20px; border-radius: 10px;">
                    Create New Section<i class='bx bx-add-to-queue' style='color:white; margin-left: 5px;'></i>
                </button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Section Name</th>
                        <th>Assigned Teacher</th>
                        <th>Student Count</th>
                        <th></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="classes-data-container">
                </tbody>
            </table>
            <div class="pagination">
            </div>
        </div>

        <!-- ADD MODAL CLASS START -->
        <div id="addSectionModal" class="modal" style="width: 0%;">
            <div class="modal-overlay"></div>
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="modal-header">
                    <h5 class="modal-title">Add Class</h5>
                </div>
                <hr style="margin-bottom:10px;">
                <form id="addClassForm" method="POST">

                    <div class="form-group">
                        <label for="sectionName">Section Name:</label>
                        <input type="text" class="form-control" id="sectionName" name="sectionName">
                    </div>

                    <div class="form-group">
                        <label for="assignedTeacher">Assigned Teacher:</label>
                        <select name="assignedTeacher" class="form-control" id="assignedTeacher">
                        </select>
                    </div>

                    <p style="text-align: center; visibility: hidden;">----------------------------------------------------</p>

                    <div class="btn-container">
                        <button type="button" class="btn-cancel btn-danger" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="btn-primary">Add Section</button>
                    </div>

                </form>
            </div>
        </div>
        <!-- ADD MODAL CLASS END -->

        <!-- UPDATE CLASS MODAL START -->
        <div id="updateClassModal" class="modal" style="width: 0%;">
            <div class="modal-overlay"></div>
            <div class="modal-content">
                <span class="close close-update" onclick="closeUpdateModal()">&times;</span>
                <div class="modal-header">
                    <h5 class="modal-title">Update Class</h5>
                </div>
                <hr style="margin-bottom:10px;">
                <form id="updateClassForm" method="POST">

                    <div class="form-group">
                        <label for="updateSectionName">Section Name:</label>
                        <input type="text" class="form-control" id="updateSectionName" name="updateSectionName" readonly>
                    </div>

                    <div class="form-group">
                        <label for="updateAssignedTeacher">Assigned Teacher:</label>
                        <select class="form-control" id="updateAssignedTeacher" name="updateAssignedTeacher">
                        </select>
                    </div>
                    <input type="hidden" id="updateAssignedTeacherId" name="updateAssignedTeacherId" />

                    <p style="text-align: center;">----------------------------------------------------</p>

                    <div class="btn-container">
                        <button type="button" class="btn-cancel btn-danger close-update" onclick="closeUpdateModal()">Cancel</button>
                        <button type="submit" id="updateClass" class="btn-primary">Update Section</button>
                    </div>

                </form>
            </div>
        </div>
        <!-- UPDATE CLASS MODAL END -->


    </div>
</main>
<!-- MAIN -->
<!-- JS AND JQUERY FOR PAGINATION -->
<script src="js/class-datatable-pagination.js"></script>
<!-- class modal -->
<script src="js/class-modal.js"></script>
<!-- sweet alert  -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>