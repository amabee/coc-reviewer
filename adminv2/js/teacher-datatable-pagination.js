var totalPages = 1;

function loadTeacherData(page) {
  $.ajax({
    url: "includes/teacher-table.php",
    type: "GET",
    data: { page: page },
    success: function (data) {
      totalPages = data.totalPages;
      $("#teacher-data-container").html(data.teachersHtml);

      $(".pagination").empty();

      for (var i = 1; i <= totalPages; i++) {
        $(".pagination").append(
          '<a href="#" onclick="loadTeacherData(' + i + ')">' + i + "</a>"
        );
      }
    },
    error: function () {
      console.log("Error loading student data");
    },
  });
}

$(document).ready(function () {
  loadTeacherData(1);
});
