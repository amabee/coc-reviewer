function logout() {
        window.location.href = 'includes/logout.php';
}

$(document).ready(function () {
        $('#studentTable').DataTable();
});

//  STUDENT RESPONSE SWAL
function handleAddStudentResponse(response) {

        if (response.error) {
                Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error,
                });
        } else {

                Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Student added successfully!',
                });
        }
}


// AJAX FOR ADDING STUDENT
$('#addStudentBtn').on('click', function () {


        var selectedGender = $('#pickgender').val();
        var excelFile = $('#excelFile')[0].files[0];
        if (excelFile) {
                uploadExcelFile(excelFile);
        } else {

                if (!validateStudentForm()) {
                        return;
                }

                var formData = $('#addStudentForm').serializeArray();
                formData.push({ name: 'gender', value: selectedGender });
                $.ajax({
                        url: "queries/addStudent.php",
                        method: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function (response) {
                                handleAddStudentResponse(response);
                        },
                        error: function () {
                                Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Something went wrong with the AJAX request.',
                                });
                        },
                });
        }
});

// FORM VALIDATION
function validateStudentForm() {
        var isValid = true;

        $('#addStudentForm [required]').each(function () {
                if (!$(this).val()) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                } else {
                        $(this).removeClass('is-invalid');
                }
        });

        return isValid;
}

// AJAX FOR UPLOADING EXCEL FILE FOR BATCH ADDING
function uploadExcelFile(file) {
        var formData = new FormData();
        formData.append('excelFile', file);

        $.ajax({
                url: "queries/addStudentViaExcel.php",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                        handleAddStudentResponse(response);
                },
                error: function () {
                        Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong with the AJAX request to addStudentViaExcel.php.',
                        });
                },
        });
}


// AJAX FOR ADDING TEACHER
$('#addTeacherBtn').on('click', function () {
        var selectedGender = $('#pickGender').val();

        if (!validateTeacherForm()) {
                return;
        }

        var formData = $('#addTeacherForm').serializeArray();
        formData.push({ name: 'gender', value: selectedGender });

        $.ajax({
                url: "queries/addTeachers.php",
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                        handleAddTeacherResponse(response);
                },
                error: function (response) {
                        Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.error,
                        });
                },
        });
});

// FORM VALIDATION
function validateTeacherForm() {
        var isValid = true;

        $('#addTeacherForm [required]').each(function () {
                if (!$(this).val()) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                } else {
                        $(this).removeClass('is-invalid');
                }
        });

        return isValid;
}

// HANDLE ADD TEACHER RESPONSE
function handleAddTeacherResponse(response) {
        if (response.error) {
                Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error,
                });
        } else {
                $('#addTeacherForm')[0].reset();
                Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Teacher added successfully!',
                });
        }
}

//     GET TEACHER DATA 
function loadTeacherData(teacherId) {

        $.ajax({
                url: "queries/getTeacherData.php",
                method: 'GET',
                data: { teacherId: teacherId },
                dataType: 'json',
                success: function (response) {
                        if (response.error) {
                                console.error(response.error);
                        } else {
                                $('#teacherProfileModalBody').html(`
                        <img class="rounded mx-auto d-block img-fluid" src="../tmp/${response.image}" style="max-width: 100px;" alt="Teacher Image">
                        <h5 class="mt-3">${response.firstname} ${response.lastname}</h5>
                        <p>Email: ${response.email}</p>
                        <p>Teacher ID: ${response.teacher_id}</p>
                    `);

                        }
                },
                error: function () {
                        console.error('Error fetching teacher data');
                },
        });
}