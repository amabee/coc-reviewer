var totalPages = 1;

function loadDeanData(page) {
  $.ajax({
    url: "includes/dean-table.php",
    type: "GET",
    data: { page: page },
    success: function (data) {
      totalPages = data.totalPages;
      $("#dean-data-container").html(data.deansHtml);

      $(".pagination").empty();

      for (var i = 1; i <= totalPages; i++) {
        $(".pagination").append(
          '<a href="#" onclick="loadDeanData(' + i + ')">' + i + "</a>"
        );
      }
    },
    error: function () {
      console.log("Error loading dean data");
    },
  });
}

$(document).ready(function () {
  loadDeanData(1);
});
