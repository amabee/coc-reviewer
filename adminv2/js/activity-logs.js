var totalPages = 1;

function loadActivityLog(page) {
  $.ajax({
    url: "includes/activityLog-table.php",
    type: "GET",
    data: { page: page },
    success: function (data) {
      totalPages = data.totalPages;
      console.log(data);
      $("#activity-log-container").html(data.activityLogHtml);

      $(".pagination").empty();

      for (var i = 1; i <= totalPages; i++) {
        $(".pagination").append(
          '<a href="#" onclick="loadActivityLog(' + i + ')">' + i + "</a>"
        );
      }
    },
    error: function () {
      console.log("Error loading activity log data");
    },
  });
}

$(document).ready(function () {
  loadActivityLog(1);
});
