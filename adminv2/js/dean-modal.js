var addDeanBtn = document.getElementById("addDeanBtn");
var addDeanModal = document.getElementById("addDeanModal");
var closeDeanBtn = document.getElementsByClassName("close")[0];

addDeanBtn.onclick = function () {
  addDeanModal.style.display = "block";
};

closeDeanBtn.onclick = function () {
  addDeanModal.style.display = "none";
};

window.onclick = function (event) {
  if (event.target === addDeanModal) {
    addDeanModal.style.display = "none";
  }
};

// AJAX FOR ADDING DEAN
$("#addDeanForm").submit(function (e) {
  e.preventDefault();
  var selectedGender = $("#pickDeanGender option:selected").val();

  if (!validateDeanForm()) {
    return;
  }

  var formData = new FormData(this);
  formData.set("gender", selectedGender);

  $.ajax({
    url: "queries/addDean.php",
    method: "POST",
    data: formData,
    dataType: "json",
    contentType: false,
    processData: false,
    success: function (response) {
      handleAddDeanResponse(response);
      clearAllDeanInput();
      addDeanModal.style.display = "none";
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

// DEAN RESPONSE SWAL
function handleAddDeanResponse(response) {
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
      text: "Dean added successfully!",
    }).then((result) => {
      if (result.isConfirmed) {
        addDeanModal.style.display = "block";
      }
    });
  }
}

function clearAllDeanInput() {
  document.getElementById("deanId").value = "";
  document.getElementById("deanFirstName").value = "";
  document.getElementById("deanLastName").value = "";
  document.getElementById("pickDeanGender").value = "";
  document.getElementById("deanEmail").value = "";
}

// FORM VALIDATION
function validateDeanForm() {
  var isValid = true;

  $("#addDeanForm [required]").each(function () {
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

// UPDATE DEAN
var updateDeanModal = document.getElementById("updateDeanModal");

$(document).on("click", ".updateDeanBtn", function () {
  updateDeanModal.style.display = "block";

  var deanId = $(this).closest("tr").find("td:eq(0)").text().trim();
  loadAndUpdateDeanData(deanId);
});

function closeDeanModal() {
  updateDeanModal.style.display = "none";
}

$(document).on("click", ".close-dean", function () {
  closeDeanModal();
});

$(document).on("click", ".close-update", function () {
  closeDeanModal();
});

// GET DEAN DATA AND PASS TO MODAL
function loadAndUpdateDeanData(deanId) {
  $.ajax({
    url: "queries/getDeanData.php",
    method: "GET",
    data: { dean_id: deanId },
    dataType: "json",
    success: function (data) {
      console.log(data);
      if (data && !data.error) {
        document.getElementById("updateDeanId").value = data.dean_id;
        document.getElementById("updateDeanFirstName").value = data.firstname;
        document.getElementById("updateDeanLastName").value = data.lastname;
        document.getElementById("updateDeanEmail").value = data.email;
        document.getElementById("updateDeanGender").value =
          data.gender.toLowerCase();
      } else {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Failed to fetch dean data. " + (data && data.error ? data.error : ""),
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


// UPDATE DEAN INFORMATION
$(document).ready(function () {
  $("#updateDean").on("click", function (e) {
    e.preventDefault();
    var formData = $("#updateDeanForm").serialize();

    $.ajax({
      url: "queries/updateDean.php",
      method: "POST",
      data: formData,
      dataType: "json",
      success: function (response) {
        if (response.success) {
          handleUpdateDeanResponse(response);
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Failed to update dean data. Please try again.",
          });
        }
      },
      error: function () {
        closeDeanModal();
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "An error occurred while processing your request.",
        });
      },
    });
  });
});

function handleUpdateDeanResponse(response) {
  if (response.success) {
    Swal.fire({
      icon: "success",
      title: "Success!",
      text: "Dean data updated successfully.",
    });
    closeDeanModal();
  } else {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: "Failed to update dean data. Please try again.",
    });
  }
}

// JS FOR TOGGLING THE ACTIVE STATUS OF DEAN
$(document).ready(function () {
  $(document).off("click", ".toggleDeanStatusBtn");

  $(document).on("click", ".toggleDeanStatusBtn", function () {
      var deanId = $(this).data("dean-id");
      var button = $(this);

      button.prop("disabled", true);

      $.ajax({
          url: "queries/AddDeanBack.php",
          method: "POST",
          data: { dean_id: deanId },
          dataType: "json",
          success: function (response) {
              if (response.success) {
                  Swal.fire({
                      icon: "success",
                      title: "Success",
                      text: "Dean status updated successfully.",
                  });

                  button.toggleClass("btn-danger btn-success");
                  button.text(response.newStatus == "active" ? "Remove" : "Add Back");
              } else {
                  Swal.fire({
                      icon: "error",
                      title: "Oops...",
                      text: "Failed to update dean status. Please try again.",
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
