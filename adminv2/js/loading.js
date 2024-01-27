document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("loading-modal").style.display = "block";
  setTimeout(function () {
    document.getElementById("loading-modal").style.display = "none";
    document.getElementById("content").style.display = "block";
  }, 4000);
});

