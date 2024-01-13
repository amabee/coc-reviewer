var totalPages = 1;

function loadClassData(page) {
  $.ajax({
    url: "includes/class-table.php",
    type: "GET",
    data: { page: page },
    success: function (data) {
      totalPages = data.totalPages;
      $("#classes-data-container").html(data.classesHtml);

      $(".pagination").empty();

      for (var i = 1; i <= totalPages; i++) {
        $(".pagination").append(
          '<a href="#" onclick="loadClassData(' + i + ')">' + i + "</a>"
        );
      }
    },
    error: function () {
      console.log("Error loading class data");
    },
  });
}

$(document).ready(function () {
  loadClassData(1);
});
