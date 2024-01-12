var addTeacherBtn = document.getElementById("addTeacherBtn");
var addTeacherModal = document.getElementById("addTeacherModal");
var closeBtn = document.getElementsByClassName("close")[0];

addTeacherBtn.onclick = function () {
  addTeacherModal.style.display = "block";
};

closeBtn.onclick = function () {
  addTeacherModal.style.display = "none";
};

window.onclick = function (event) {
  if (event.target === addTeacherModal) {
    addTeacherModal.style.display = "none";
  }
};

// AJAX FOR ADDING TEACHER
$("#addTeacherForm").submit(function (e) {
  e.preventDefault();
  var selectedGender = $("#pickgender option:selected").val();

  if (!validateTeacherForm()) {
    return;
  }

  var formData = new FormData(this);
  formData.set("gender", selectedGender);

  $.ajax({
    url: "queries/addTeachers.php",
    method: "POST",
    data: formData,
    dataType: "json",
    contentType: false,
    processData: false,
    success: function (response) {
      handleAddTeacherResponse(response);
      clearAllTeacherInput();
      addTeacherModal.style.display = "none";
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

// TEACHER RESPONSE SWAL
function handleAddTeacherResponse(response) {
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
      text: "Teacher added successfully!",
    }).then((result) => {
      if (result.isConfirmed) {
        addTeacherModal.style.display = "block";
      }
    });
  }
}

function clearAllTeacherInput() {
  document.getElementById("teacherId").value = "";
  document.getElementById("firstName").value = "";
  document.getElementById("lastName").value = "";
  document.getElementById("pickgender").value = "";
  document.getElementById("email").value = "";
}

// FORM VALIDATION
function validateTeacherForm() {
  var isValid = true;

  $("#addTeacherForm [required]").each(function () {
    var value = $(this).val().trim();

    if (!value) {
      isValid = false;
      $(this).addClass("is-invalid");
    } else {
      $(this).removeClass("is-invalid");
    }
  });
  return isValid;
}

// UPDATE TEACHER
var updateTeacherModal = document.getElementById("updateTeacherModal");

$(document).on("click", ".updateTeacherBtn", function () {
  updateTeacherModal.style.display = "block";

  var teacherId = $(this).closest("tr").find("td:eq(1)").text().trim();
  loadAndUpdateTeacherData(teacherId);
});

function closeTeacherModal() {
  updateTeacherModal.style.display = "none";
}

$(document).on("click", ".close-teacher", function () {
  closeTeacherModal();
});

$(document).on("click", ".close-update", function () {
  closeTeacherModal();
});

// GET TEACHER DATA AND PASS TO MODAL
function loadAndUpdateTeacherData(teacherId) {
  $.ajax({
    url: "queries/getTeacherData.php",
    method: "GET",
    data: { teacher_id: teacherId },
    dataType: "json",
    success: function (data) {
      document.getElementById("updateTeacherId").value = data.teacher_id;
      document.getElementById("updateTeacherFirstName").value = data.firstname;
      document.getElementById("updateTeacherLastName").value = data.lastname;
      document.getElementById("updateTeacherEmail").value = data.email;
      document.getElementById("updateTeacherGender").value =
        data.gender.toLowerCase();
    },
    error: function () {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Failed to fetch teacher data.",
      });
    },
  });
}

// UPDATE TEACHER INFORMATION
$(document).ready(function () {
  $("#updateTeacher").on("click", function (e) {
    e.preventDefault();
    var formData = $("#updateTeacherForm").serialize();

    $.ajax({
      url: "queries/updateTeacher.php",
      method: "POST",
      data: formData,
      dataType: "json",
      success: function (response) {
        if (response.success) {
          handleUpdateTeacherResponse(response);
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Failed to update teacher data. Please try again.",
          });
        }
      },
      error: function () {
        closeTeacherModal();
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "An error occurred while processing your request.",
        });
      },
    });
  });
});

function handleUpdateTeacherResponse(response) {
  if (response.success) {
    Swal.fire({
      icon: "success",
      title: "Success!",
      text: "Teacher data updated successfully.",
    });
    closeTeacherModal();
  } else {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Failed to update teacher data. Please try again.",
    });
  }
}

// ADDING THE TEACHER BACK (if applicable)
$(document).on("click", ".toggleTeacherStatusBtn", function () {
  var teacherId = $(this).data("teacher-id");
  var button = $(this);

  $.ajax({
    url: "queries/AddTeacherBack.php",
    method: "POST",
    data: { teacher_id: teacherId },
    dataType: "json",
    success: function (response) {
      if (response.success) {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: "Teacher status updated successfully.",
        });

        button.toggleClass("btn-danger btn-success");
        button.text(response.newStatus == "active" ? "Remove" : "Add Back");
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Failed to update teacher status. Please try again.",
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
  });
});
