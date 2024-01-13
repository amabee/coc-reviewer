var addSectionBtn = document.getElementById("addSectionBtn");
var addSectionModal = document.getElementById("addSectionModal");
var closeBtn = document.getElementsByClassName("close")[0];
var updateClassModal = document.getElementById("updateClassModal");

addSectionBtn.onclick = function () {
    addSectionModal.style.display = "block";
};

closeBtn.onclick = function () {
    addSectionModal.style.display = "none";
};

window.onclick = function (event) {
  if (event.target === addSectionModal) {
    addSectionModal.style.display = "none";
  }
};

function closeModal(){
    addSectionModal.style.display = "none";
}

function closeUpdateModal(){
  updateClassModal.style.display = "none";
}


function handleClassMessage(status, message) {
    if (status === 'success') {
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: message,
      });
    } else if (status === 'error') {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
      });
    }
  }
  
// AJAX for getting the teachers then passed unto the select options?
function loadTeachers() {
    $.ajax({
        url: "queries/getTeacher.php",
        type: "GET",
        success: function (data) {
            $("#assignedTeacher").empty();
            $.each(data, function (index, teacher) {
                $("#assignedTeacher").append('<option value="' + teacher.teacher_id + '">' + teacher.firstname + ' ' + teacher.lastname + '</option>');
            });
        },
        error: function () {
            console.log("Error loading teachers");
        },
    });
}
// AJAX for adding section
$("#addClassForm").submit(function (event) {
    event.preventDefault();

    var formData = $(this).serialize();

    $.ajax({
        url: "queries/addSection.php",
        type: "POST",
        data: formData,
        success: function (response) {
            handleClassMessage(response.status, response.message);
            closeModal();
        },
        error: function () {
            handleClassMessage('error', 'Error submitting form');
        },
    });
});
updateClassModal = document.getElementById("updateClassModal");
$(document).on("click", ".updateClassBtn", function () {
  updateClassModal.style.display = "block";

  var sectionId = $(this).closest("tr").find("td:eq(0)").text().trim();
  loadAndUpdateSectionModal(sectionId);
});

function loadAndUpdateSectionModal(sectionId) {
  $.ajax({
    url: "queries/getSectionData.php",
    method: "GET",
    data: { section_id: sectionId },
    dataType: "json",
    success: function (data) {
      document.getElementById("updateSectionName").value = data.section_id;

      var selectDropdown = document.getElementById("updateAssignedTeacher");
      selectDropdown.innerHTML = '<option value="" disabled>Select Teacher</option>';

      data.teachers.forEach(function (teacher) {
        var option = document.createElement("option");
        option.value = teacher.teacher_id;
        option.text = teacher.firstname + " " + teacher.lastname;
        selectDropdown.add(option);
      });

      document.getElementById("updateAssignedTeacherId").value = data.teacher_id;
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


// UPDATE SECTION INFORMATION
$(document).ready(function () {
  $("#updateClass").on("click", function (e) {
      e.preventDefault();
      var formData = $("#updateClassForm").serialize();

      $.ajax({
          url: "queries/updateSection.php",
          method: "POST",
          data: formData,
          dataType: "json",
          success: function (response) {
              if (response.success) {
                closeUpdateModal();
                handleClassMessage('success',response.message);
              } else {
                  Swal.fire({
                      icon: "error",
                      title: "Oops...",
                      text: "Failed to update section data. Please try again.",
                  });
              }
          },
          error: function () {
              closeUpdateModal();
              Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: "An error occurred while processing your request.",
              });
          },
      });
  });
});


$(document).ready(function () {
    loadTeachers();
});

