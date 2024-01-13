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
$("#submitMe").click(function (e) {
  e.preventDefault();
  var selectedGender = $("#pickgender option:selected").val();

  if (!validateStudentForm()) {
    return;
  }

  var formData = new FormData($("#addStudentForm")[0]);
  formData.set("gender", selectedGender);

  $.ajax({
    url: "queries/addStudent.php",
    method: "POST",
    data: formData,
    dataType: "json",
    contentType: false,
    processData: false,
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
});

$("#addViaExcel").click(function (e) {
  e.preventDefault();

  var excelFile = $("#fileUpload")[0].files[0];
  if (!excelFile) {
    alert("Nani?");
  } else {
    uploadExcelFile(excelFile);
  }

})

// STUDENT RESPONSE SWAL
function handleAddStudentResponse(response) {
  console.log(response);
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
      text: "Successfully Added the Students",
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
    var value = $(this).val().trim();

    if (!value) {
      isValid = false;
      $(this).addClass("is-invalid");
    } else {
      $(this).removeClass("is-invalid");
    }
  });

  var firstNameInput = $("#firstName");
  var lastNameInput = $("#lastName");
  var genderSelector = $("#pickgender");
  var emailInput = $("#email");

  // Check for First Name
  if (!firstNameInput.val().trim()) {
    isValid = false;
    firstNameInput.addClass("is-invalid");
  } else {
    firstNameInput.removeClass("is-invalid");
  }

  // Check for Last Name
  if (!lastNameInput.val().trim()) {
    isValid = false;
    lastNameInput.addClass("is-invalid");
  } else {
    lastNameInput.removeClass("is-invalid");
  }

  // Check for Gender
  if (genderSelector.val() === null) {
    isValid = false;
    genderSelector.addClass("is-invalid");
  } else {
    genderSelector.removeClass("is-invalid");
  }

  // Check for Email
  var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailInput.val().trim() || !emailRegex.test(emailInput.val().trim())) {
    isValid = false;
    emailInput.addClass("is-invalid");
  } else {
    emailInput.removeClass("is-invalid");
  }

  return isValid;
}

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
      addStudentModal.style.display = "none";
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

// UPDATE AREA
var updateStudentModal = document.getElementById("updateStudentModal");

$(document).on("click", ".updateStudentBtn", function () {
  updateStudentModal.style.display = "block";

  var studentId = $(this).closest("tr").find("td:eq(1)").text().trim();
  loadAndUpdateStudentData(studentId);
});

function closeModal() {
  updateStudentModal.style.display = "none";
}

$(document).on("click", ".close", function () {
  closeModal();
});

// GET STUDENT DATA AND PASS TO MODAL
function loadAndUpdateStudentData(studentId) {
  $.ajax({
    url: "queries/getStudentData.php",
    method: "GET",
    data: { student_id: studentId },
    dataType: "json",
    success: function (data) {
      document.getElementById("updateStudentId").value = data.id;
      document.getElementById("updateFirstName").value = data.firstname;
      document.getElementById("updateLastName").value = data.lastname;
      document.getElementById("updateEmail").value = data.email;
      document.getElementById("updateStudentGender").value =
        data.gender.toLowerCase();
    },

    error: function () {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Failed to fetch student data.",
      });
    },
  });
}

// UPDATE STUDENT INFORMATION
$(document).ready(function () {
  $("#updateStudent").on("click", function (e) {
    e.preventDefault(); // Prevent the default form submission behavior
    var formData = $("#updateStudentForm").serialize();

    $.ajax({
      url: "queries/updateStudent.php",
      method: "POST",
      data: formData,
      dataType: "json",
      success: function (response) {
        if (response.success) {
          handleUpdateStudentResponse(response);
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Failed to update student data. Please try again.",
          });
        }
      },
      error: function () {
        closeModal();
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "An error occurred while processing your request.",
        });
      },
    });
  });
});

function handleUpdateStudentResponse(response) {
  if (response.success) {
    Swal.fire({
      icon: "success",
      title: "Success!",
      text: "Student data updated successfully.",
    });
    closeModal();
  } else {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Failed to update student data. Please try again.",
    });
  }
}


$(document).ready(function () {
  $(document).off("click", ".toggleStudentStatusBtn");

  $(document).on("click", ".toggleStudentStatusBtn", function () {
    var studentId = $(this).data("student-id");
    var button = $(this);

    button.prop("disabled", true);

    $.ajax({
      url: "queries/AddStudentBack.php",
      method: "POST",
      data: { student_id: studentId },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          Swal.fire({
            icon: "success",
            title: "Success",
            text: "Student status updated successfully.",
          });

          button.toggleClass("btn-danger btn-success");
          button.text(response.newStatus == "active" ? "Remove" : "Add Back");
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Failed to update student status. Please try again.",
          });
        }
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "An error occurred while processing your request.",
        });
      },
      complete: function () {
        button.prop("disabled", false);
      },
    });
  });
});
