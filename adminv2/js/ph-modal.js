var addProgramHeadBtn = document.getElementById("addProgramHeadBtn");
var addProgramHeadModal = document.getElementById("addProgramHeadModal");
var closeProgramHeadBtn = document.getElementById("closeAddProgramHeadModal");

addProgramHeadBtn.onclick = function () {
  addProgramHeadModal.style.display = "block";
};

closeProgramHeadBtn.onclick = function () {
  addProgramHeadModal.style.display = "none";
};

window.onclick = function (event) {
  if (event.target === addProgramHeadModal) {
    addProgramHeadModal.style.display = "none";
  }
};

// AJAX FOR ADDING PROGRAM HEAD
$("#addProgramHeadForm").submit(function (e) {
  e.preventDefault();
  var selectedGender = $("#pickProgramHeadGender option:selected").val();

  if (!validateProgramHeadForm()) {
    return;
  }

  var formData = new FormData(this);
  formData.set("gender", selectedGender);

  $.ajax({
    url: "queries/addProgramHead.php",
    method: "POST",
    data: formData,
    dataType: "json",
    contentType: false,
    processData: false,
    success: function (response) {
      handleAddProgramHeadResponse(response);
      clearAllProgramHeadInput();
      addProgramHeadModal.style.display = "none";
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

// PROGRAM HEAD RESPONSE SWAL
function handleAddProgramHeadResponse(response) {
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
      text: "Program Head added successfully!",
    }).then((result) => {
      if (result.isConfirmed) {
        addProgramHeadModal.style.display = "block";
      }
    });
  }
}

function clearAllProgramHeadInput() {
  document.getElementById("programHeadId").value = "";
  document.getElementById("programHeadFirstName").value = "";
  document.getElementById("programHeadLastName").value = "";
  document.getElementById("pickProgramHeadGender").value = "";
  document.getElementById("programHeadEmail").value = "";
}

// FORM VALIDATION
function validateProgramHeadForm() {
  var isValid = true;

  $("#addProgramHeadForm [required]").each(function () {
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

// UPDATE PROGRAM HEAD
var updateProgramHeadModal = document.getElementById("updateProgramHeadModal");

$(document).on("click", ".updateProgramHeadBtn", function () {
  updateProgramHeadModal.style.display = "block";

  var programHeadId = $(this).closest("tr").find("td:eq(0)").text().trim();
  loadAndUpdateProgramHeadData(programHeadId);
});

function closeProgramHeadModal() {
  updateProgramHeadModal.style.display = "none";
}

$(document).on("click", ".close-program-head", function () {
  closeProgramHeadModal();
});

$(document).on("click", ".close-update", function () {
  closeProgramHeadModal();
});

// GET PROGRAM HEAD DATA AND PASS TO MODAL
function loadAndUpdateProgramHeadData(programHeadId) {
  $.ajax({
    url: "queries/getProgramHeadData.php",
    method: "GET",
    data: { program_head_id: programHeadId },
    dataType: "json",
    success: function (data) {
      console.log(data);
      if (data && !data.error) {
        document.getElementById("updateProgramHeadId").value = data.ph_id;
        document.getElementById("updateProgramHeadFirstName").value = data.firstname;
        document.getElementById("updateProgramHeadLastName").value = data.lastname;
        document.getElementById("updateProgramHeadEmail").value = data.email;
        document.getElementById("updateProgramHeadGender").value =
          data.gender.toLowerCase();
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Failed to fetch program head data. " + (data && data.error ? data.error : ""),
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
}

// UPDATE PROGRAM HEAD INFORMATION
$(document).ready(function () {
  $("#updateProgramHead").on("click", function (e) {
    e.preventDefault();
    var formData = $("#updateProgramHeadForm").serialize();

    $.ajax({
      url: "queries/updateProgramHead.php",
      method: "POST",
      data: formData,
      dataType: "json",
      success: function (response) {
        if (response.success) {
          handleUpdateProgramHeadResponse(response);
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Failed to update program head data. Please try again.",
          });
        }
      },
      error: function () {
        closeProgramHeadModal();
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "An error occurred while processing your request.",
        });
      },
    });
  });
});

function handleUpdateProgramHeadResponse(response) {
  if (response.success) {
    Swal.fire({
      icon: "success",
      title: "Success!",
      text: "Program Head data updated successfully.",
    });
    closeProgramHeadModal();
  } else {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Failed to update program head data. Please try again.",
    });
  }
}

// JS FOR TOGGLING THE ACTIVE STATUS OF PROGRAM HEAD
$(document).ready(function () {
    $(document).off("click", ".toggleProgramHeadStatusBtn");
  
    $(document).on("click", ".toggleProgramHeadStatusBtn", function () {
      var programHeadId = $(this).data("ph-id");
      var button = $(this);
  
      button.prop("disabled", true);
  
      $.ajax({
        url: "queries/AddProgramHeadBack.php",
        method: "POST",
        data: { ph_id: programHeadId },
        dataType: "json",
        success: function (response) {
          if (response.success) {
            Swal.fire({
              icon: "success",
              title: "Success",
              text: "Program Head status updated successfully.",
            });
  
            button.toggleClass("btn-danger btn-success");
            button.text(response.newStatus == "active" ? "Remove" : "Add Back");
          } else {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Failed to update program head status. Please try again.",
            });
          }
        },
        error: function (response) {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "An error occurred while processing your request. " + JSON.stringify(response),
          });
        },
        complete: function () {
          button.prop("disabled", false);
        },
      });
    });
  });
  