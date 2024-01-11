var totalPages = 1;

function loadStudentData(page) {
  $.ajax({
    url: "includes/student-table.php",
    type: "GET",
    data: { page: page },
    success: function (data) {
      totalPages = data.totalPages;
      $("#student-data-container").html(data.studentsHtml);

      $(".pagination").empty();

      for (var i = 1; i <= totalPages; i++) {
        $(".pagination").append(
          '<a href="#" onclick="loadStudentData(' + i + ')">' + i + "</a>"
        );
      }
    },
    error: function () {
      console.log("Error loading student data");
    },
  });
}

$(document).ready(function () {
  loadStudentData(1);
});
