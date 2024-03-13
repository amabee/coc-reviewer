<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="logoutBtn" onclick="logout()">Logout</button>
            </div>
        </div>
    </div>
</div>


<!-- Add Student Modal -->
<div class="modal fade" data-backdrop="static" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addStudentForm">
                    <div class="form-group">
                        <label for="studentId">Student ID</label>
                        <input type="text" class="form-control" id="studentId" name="studentId" required>
                    </div>
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                    </div>
                    <div class="form-group">
                        <label for="firstName">Gender</label>
                        <select name="gender" id="pickgender" class="form-control" required>
                            <option value="" disabled selected>-- SELECT GENDER --</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <hr>
                    <!-- Separator: Header and Horizontal Rule -->
                    <div class="text-center mb-3">
                        <span class="text-muted font-weight-bold">----------------- OR ADD BY BATCH
                            -------------------</span>
                    </div>
                    <hr>

                    <!-- Batch Input (if needed) -->
                    <div class="form-group">
                        <label for="excelFile">Upload Excel File</label>
                        <input type="file" class="d-none" id="excelFile" name="excelFile" accept=".xls, .xlsx">
                        <button type="button" class="btn btn-primary" onclick="document.getElementById('excelFile').click()">
                            <span id="excelFileLabel">Click to Upload Excel File</span>
                        </button>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit" id="addStudentBtn">Add Student</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Student Modal -->
<div class="modal fade" data-backdrop="static" id="updateStudentModal" tabindex="-1" role="dialog" aria-labelledby="updateStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStudentModalLabel">Update Student Information</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateStudentForm">
                    <input type="hidden" id="updateStudentId" name="updateStudentId">

                    <div class="form-group">
                        <label for="updateFirstName">First Name</label>
                        <input type="text" class="form-control" id="updateFirstName" name="updateFirstName" required>
                    </div>
                    <div class="form-group">
                        <label for="updateLastName">Last Name</label>
                        <input type="text" class="form-control" id="updateLastName" name="updateLastName" required>
                    </div>
                    <div class="form-group">
                        <label for="updateGender">Gender</label>
                        <select name="updateGender" id="updateStudentGender" class="form-control" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="updateEmail">Email</label>
                        <input type="email" class="form-control" id="updateEmail" name="updateEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="updateStatus">Active Status</label>
                        <select name="updateStatus" class="form-control" id="updateStatus" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="button" id="updateStudentBtn">Update Student</button>
            </div>
        </div>
    </div>
</div>



<!-- Add Teacher Modal -->
<div class="modal fade" data-backdrop="static" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTeacherModalLabel">Add Teacher</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addTeacherForm">
                    <div class="form-group">
                        <label for="teacherId">Teacher ID</label>
                        <input type="text" class="form-control" id="teacherId" name="teacherId" required>
                    </div>
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select name="gender" id="pickGender" class="form-control" required>
                            <option value="" disabled selected>-- SELECT GENDER --</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit" id="addTeacherBtn">Add Teacher</button>
            </div>
        </div>
    </div>
</div>

<!-- TEACHER PROFILE MODAL -->

<div class="modal fade" id="teacherProfileModal" tabindex="-1" role="dialog" aria-labelledby="teacherProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="teacherProfileModalLabel">Teacher Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" id="teacherProfileModalBody">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Section Modal -->
<div class="modal fade" data-backdrop="static" id="addSectionModal" tabindex="-1" role="dialog" aria-labelledby="addSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSectionModalLabel">Add Section</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addSectionForm">
                    <div class="form-group">
                        <label for="sectionName">Section Name</label>
                        <input type="text" class="form-control" id="sectionName" name="sectionName" required>
                    </div>
                    <div class="form-group">
                        <label for="teacherId">Assigned Teacher</label>

                        <select name="teacherId" id="teacherId" class="form-control" required>
                            <?php
                            $queryTeachers = "SELECT teacher_id, firstname, lastname FROM tbl_teachers";
                            $stmtTeachers = $conn->prepare($queryTeachers);
                            $stmtTeachers->execute();
                            $availableTeachers = $stmtTeachers->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <option value="" disabled selected>-- SELECT TEACHER --</option>
                            <?php foreach ($availableTeachers as $teacher) : ?>
                                <option value="<?php echo $teacher['teacher_id']; ?>">
                                    <?php echo $teacher['firstname'] . ' ' . $teacher['lastname']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="button" id="addSectionBtn">Add Section</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FOR ADDING PROGRAM HEAD -->
<div class="modal fade" data-backdrop="static" id="addFacultyModal" tabindex="-1" role="dialog" aria-labelledby="addFacultyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFacultyModalLabel">Add New Program Head</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addFacultyForm">
                    <div class="form-group">
                        <label for="facultyId">Faculty ID</label>
                        <input type="text" class="form-control" id="facultyId" name="facultyId" required>
                    </div>
                    <div class="form-group">
                        <label for="facultyFirstName">Faculty Firstname</label>
                        <input type="text" class="form-control" id="facultyFirstName" name="facultyFirstName" required>
                    </div>
                    <div class="form-group">
                        <label for="facultyLastName">Faculty Lastname</label>
                        <input type="text" class="form-control" id="facultyLastName" name="facultyLastName" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addProgramHeadBtn">Add Program Head</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FOR ADDING DEAN -->
<div class="modal fade" data-backdrop="static" id="addDeanModal" tabindex="-1" role="dialog" aria-labelledby="addDeanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDeanModalLabel">Add New Dean</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addDeanForm">
                    <div class="form-group">
                        <label for="deanId">Dean ID</label>
                        <input type="text" class="form-control" id="deanId" name="deanId" required>
                    </div>
                    <div class="form-group">
                        <label for="deanFirstName">Dean Firstname</label>
                        <input type="text" class="form-control" id="deanFirstName" name="deanFirstName" required>
                    </div>
                    <div class="form-group">
                        <label for="deanLastName">Dean Lastname</label>
                        <input type="text" class="form-control" id="deanLastName" name="deanLastName" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="deanGender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="deanEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addDeanBtn">Add Dean</button>
            </div>
        </div>
    </div>
</div>
