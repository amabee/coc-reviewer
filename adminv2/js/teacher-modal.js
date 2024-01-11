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

  // Additional validation rules for teacher form

  return isValid;
}
