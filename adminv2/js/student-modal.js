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
  var selectedGender = $("#pickgender option:selected").val();
  var excelFile = $("#fileUpload")[0].files[0];

  if (excelFile) {
    uploadExcelFile(excelFile);
  } else {
    if (!validateStudentForm()) {
      return;
    }

    var formData = new FormData(this);
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
  }
});
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

  // Additional check for file input
  var fileInput = $("#fileUpload")[0];
  if (!fileInput.files.length) {
    isValid = false;
    $(fileInput).addClass("is-invalid");
  } else {
    $(fileInput).removeClass("is-invalid");
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
var closeUpdateBtn = document.getElementsByClassName("close")[1];
$(document).on("click", ".updateStudentBtn", function () {
  var updateStudentModal = document.getElementById("updateStudentModal");
  updateStudentModal.style.display = "block";
});

function closeModal() {
  updateStudentModal.style.display = "none";
}

closeUpdateBtn.onclick = function () {
  updateStudentModal.style.display = "none";
};
