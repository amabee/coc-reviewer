function logout() {
        window.location.href = 'includes/logout.php';
}

$(document).ready(function () {
        $('#studentTable').DataTable();
});

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

$('#addStudentBtn').on('click', function () {


        var selectedGender = $('#pickgender').val();
        var excelFile = $('#excelFile')[0].files[0];
        if (excelFile) {
                uploadExcelFile(excelFile);
        } else {

                if (!validateForm()) {
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

function validateForm() {
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
