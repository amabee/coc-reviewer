document.addEventListener("DOMContentLoaded", function () {
  function updateSpacerMargin() {
    var viewportWidth =
      window.innerWidth || document.documentElement.clientWidth;
    var multiplier = 0.036;
    var marginValue = viewportWidth * multiplier;

    document.querySelector("#content nav .spacer").style.marginRight =
      marginValue + "vw";
  }

  updateSpacerMargin();

  window.addEventListener("resize", updateSpacerMargin);
});
