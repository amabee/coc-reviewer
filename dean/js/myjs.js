function logout() {
  window.location.href = "includes/logout.php";
}

$(document).ready(function () {
  $("#studentTable").DataTable();
});

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

//     GET Student DATA

function loadStudentDatas(studentId) {
  $.ajax({
    url: "queries/getStudentData.php",
    method: "GET",
    data: { studentId: studentId },
    dataType: "json",
    success: function (response) {
      if (response.error) {
        console.error(response.error);
      } else {
        $("#card-body").html(`
        <img class="card-img-top img-fluid img-rounded mx-auto" src="../tmp/${response.image}" alt="Student Profile Image" style="width: 100px; height: 100px;">

                       
                        <h5 class="mt-3">${response.firstname} ${response.lastname}</h5>
                        <p>Email: ${response.email}</p>
                        <p>Student Id: ${response.id}</p>
                    `);
      }
    },
    error: function () {
      console.error("Error fetching student data");
    },
  });
}

// chart

