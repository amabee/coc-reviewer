document.addEventListener("DOMContentLoaded", function () {
  loadContent("routes/dashboard.php");
  const navLinks = document.querySelectorAll(".sidebar-link");

  navLinks.forEach((link) => {
    link.addEventListener("click", function (event) {
      event.preventDefault();
      const route = this.getAttribute("href");
      loadContent(route);
    });
  });
});

function loadContent(route) {
  $.ajax({
    url: route,
    type: "GET",
    success: function (data) {
      $("#dynamic-content").html(data);
    },
    error: function () {
      console.log("Error loading content");
    },
  });
}
