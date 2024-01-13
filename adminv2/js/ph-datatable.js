var totalPages = 1;

function loadProgramHeadData(page) {
  $.ajax({
    url: "includes/ph-table.php", 
    type: "GET",
    data: { page: page },
    success: function (data) {
      totalPages = data.totalPages;
      $("#ph-data-container").html(data.phsHtml);

      $(".pagination").empty();

      for (var i = 1; i <= totalPages; i++) {
        $(".pagination").append(
          '<a href="#" onclick="loadProgramHeadData(' + i + ')">' + i + "</a>"
        );
      }
    },
    error: function () {
      console.log("Error loading program head data");
    },
  });
}

$(document).ready(function () {
  loadProgramHeadData(1);
});
