var addStudentBtn = document.getElementById("addStudentBtn");
var addStudentModal = document.getElementById("addStudentModal");
var closeBtn = document.getElementsByClassName("close")[0];

addStudentBtn.onclick = function () {
  addStudentModal.style.display = "block";
};

closeBtn.onclick = function () {
  addStudentModal.style.display = "none";
};

window.onclick = function (event) {
  if (event.target === addStudentModal) {
    addStudentModal.style.display = "none";
  }
};

// AJAX FOR ADDING STUDENT
$("#addStudentForm").submit(function (e) {
  e.preventDefault();
  var selectedGender = $("#gender").val();
  var excelFile = $("#fileUpload")[0].files[0];

  if (excelFile) {
    uploadExcelFile(excelFile);
  } else {
    if (!validateStudentForm()) {
      return;
    }

    var formData = $(this).serializeArray();
    formData.push({ name: "gender", value: selectedGender });
    $.ajax({
      url: "queries/addStudent.php",
      method: "POST",
      data: formData,
      dataType: "json",
      success: function (response) {
        handleAddStudentResponse(response);
        clearAllStudentInput();
        addStudentModal.style.display = "none";
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

// STUDENT RESPONSE SWAL
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
    }).then((result) => {
      if (result.isConfirmed) {
        addStudentModal.style.display = "block";
      }
    });
  }
}

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
