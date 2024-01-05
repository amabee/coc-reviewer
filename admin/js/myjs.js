function logout() {
  window.location.href = "includes/logout.php";
}

$(document).ready(function () {
  $("#studentTable").DataTable();
});

//  STUDENT RESPONSE SWAL
function handleAddStudentResponse(response) {
  if (response.error) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: response.error,
    });
  } else {
    Swal.fire({
      icon: "success",
      title: "Success",
      text: "Student added successfully!",
    });
  }
}

// AJAX FOR ADDING STUDENT
$("#addStudentBtn").on("click", function () {
  var selectedGender = $("#pickgender").val();
  var excelFile = $("#excelFile")[0].files[0];
  if (excelFile) {
    uploadExcelFile(excelFile);
  } else {
    if (!validateStudentForm()) {
      return;
    }

    var formData = $("#addStudentForm").serializeArray();
    formData.push({ name: "gender", value: selectedGender });
    $.ajax({
      url: "queries/addStudent.php",
      method: "POST",
      data: formData,
      dataType: "json",
      success: function (response) {
        handleAddStudentResponse(response);
        clearAllStudentInput();
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Something went wrong with the AJAX request.",
        });
      },
    });
  }
});

function clearAllStudentInput() {
  document.getElementById("studentId").value = "";
  document.getElementById("firstName").value = "";
  document.getElementById("lastName").value = "";
  document.getElementById("pickgender").value = "";
  document.getElementById("email").value = "";
}

// FORM VALIDATION
function validateStudentForm() {
  var isValid = true;

  $("#addStudentForm [required]").each(function () {
    if (!$(this).val()) {
      isValid = false;
      $(this).addClass("is-invalid");
    } else {
      $(this).removeClass("is-invalid");
    }
  });

  return isValid;
}

// AJAX FOR UPLOADING EXCEL FILE FOR BATCH ADDING
function uploadExcelFile(file) {
  var formData = new FormData();
  formData.append("excelFile", file);

  $.ajax({
    url: "queries/addStudentViaExcel.php",
    method: "POST",
    data: formData,
    processData: false,
    contentType: false,
    dataType: "json",
    success: function (response) {
      handleAddStudentResponse(response);
    },
    error: function () {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Something went wrong with the AJAX request to addStudentViaExcel.php.",
      });
    },
  });
}

// AJAX FOR ADDING TEACHER
$("#addTeacherBtn").on("click", function () {
  var selectedGender = $("#pickGender").val();

  if (!validateTeacherForm()) {
    return;
  }

  var formData = $("#addTeacherForm").serializeArray();
  formData.push({ name: "gender", value: selectedGender });

  $.ajax({
    url: "queries/addTeachers.php",
    method: "POST",
    data: formData,
    dataType: "json",
    success: function (response) {
      handleAddTeacherResponse(response);
    },
    error: function (response) {
      Swal.fire({
        icon: "error",
        title: "Error",
        text: response.error,
      });
    },
  });
});

// FORM VALIDATION
function validateTeacherForm() {
  var isValid = true;

  $("#addTeacherForm [required]").each(function () {
    if (!$(this).val()) {
      isValid = false;
      $(this).addClass("is-invalid");
    } else {
      $(this).removeClass("is-invalid");
    }
  });

  return isValid;
}

// HANDLE ADD TEACHER RESPONSE
function handleAddTeacherResponse(response) {
  if (response.error) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: response.error,
    });
  } else {
    $("#addTeacherForm")[0].reset();
    Swal.fire({
      icon: "success",
      title: "Success",
      text: "Teacher added successfully!",
    });
  }
}

//     GET TEACHER DATA
function loadTeacherData(teacherId) {
  $.ajax({
    url: "queries/getTeacherData.php",
    method: "GET",
    data: { teacherId: teacherId },
    dataType: "json",
    success: function (response) {
      if (response.error) {
        console.error(response.error);
      } else {
        $("#teacherProfileModalBody").html(`
                        <img class="rounded mx-auto d-block img-fluid" src="../tmp/${response.image}" style="max-width: 100px;" alt="Teacher Image">
                        <h5 class="mt-3">${response.firstname} ${response.lastname}</h5>
                        <p>Email: ${response.email}</p>
                        <p>Teacher ID: ${response.teacher_id}</p>
                    `);
      }
    },
    error: function () {
      console.error("Error fetching teacher data");
    },
  });
}

// BUTTON LOADING CODE
document.addEventListener("DOMContentLoaded", function () {
  const excelFileInput = document.getElementById("excelFile");
  const excelFileLabel = document.getElementById("excelFileLabel");
  const addStudentBtn = document.getElementById("addStudentBtn");

  excelFileInput.addEventListener("change", function () {
    const fileName = this.files[0].name;
    excelFileLabel.innerText = fileName;
  });

  document
    .getElementById("addStudentForm")
    .addEventListener("submit", function () {
      addStudentBtn.innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
      addStudentBtn.disabled = true;
    });
});

// HANDLE ADD TEACHER RESPONSE
function handleAddSectionResponse(response) {
  if (response.error) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: response.error,
    });
  } else {
    $("#addSectionForm")[0].reset();
    Swal.fire({
      icon: "success",
      title: "Success",
      text: response.message,
    });
  }
}

// FORM VALIDATION FOR SECTION
function validateSectionForm() {
  var isValid = true;

  $("#addSectionForm [required]").each(function () {
    if (!$(this).val()) {
      isValid = false;
      $(this).addClass("is-invalid");
    } else {
      $(this).removeClass("is-invalid");
    }
  });

  return isValid;
}

// ADDING SECTION
$(document).ready(function () {
  $("#addSectionBtn").on("click", function () {
    if (!validateSectionForm()) {
      return;
    }
    var formData = $("#addSectionForm").serializeArray();
    $.ajax({
      url: "queries/addSection.php",
      method: "POST",
      data: formData,
      dataType: "json",
      success: function (response) {
        handleAddSectionResponse(response);
      },
      error: function () {
        handleAddSectionResponse();
      },
    });
  });
});
