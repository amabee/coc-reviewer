function showLoadingModal(event, linkHref) {
  event.preventDefault();
  document.getElementById("loading-modal").style.display = "block";

  loadContent(linkHref, function () {
    document.getElementById("loading-modal").style.display = "none";
  });
}

function showLoadingOverlay() {
  document.getElementById("loading-overlay").style.display = "block";
}

function hideLoadingOverlay() {
  document.getElementById("loading-overlay").style.display = "none";
}


document.addEventListener("DOMContentLoaded", function () {
 
  loadContent("routes/dashboard.php");

  const navLinks = document.querySelectorAll(".sidebar-link");

  navLinks.forEach((link) => {
    link.addEventListener("click", function (event) {
      event.preventDefault();
      const route = this.getAttribute("href");
      showLoadingModal(event, route);
    });
  });
});

function loadContent(route, callback) {
  $.ajax({
    url: route,
    type: "GET",
    success: function (data) {
      $("#dynamic-content").html(data);
      if (callback) {
        callback();
      }
    },
    error: function () {
      console.log("Error loading content");
    },
  });
}
