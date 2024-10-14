!function (l) {
  "use strict";

  // Toggle the sidebar on button click
  l("#sidebarToggle, #sidebarToggleTop").on("click", function (e) {
    l("body").toggleClass("sidebar-toggled"); // Toggle class on body
    l(".sidebar").toggleClass("toggled"); // Toggle class on sidebar

    // If the sidebar is toggled, hide any open collapsible elements
    if (l(".sidebar").hasClass("toggled")) {
      l(".sidebar .;;").collapse("hide");
    }
  });

  // Handle window resize events
  l(window).resize(function () {
    // Hide collapsible elements if the window width is less than 768 pixels
    if (l(window).width() < 768) {
      l(".sidebar .collapse").collapse("hide");
    }

    // If window width is less than 480 pixels and sidebar is not toggled, toggle it
    if (l(window).width() < 480 && !l(".sidebar").hasClass("toggled")) {
      l("body").addClass("sidebar-toggled");
      l(".sidebar").addClass("toggled");
      l(".sidebar .collapse").collapse("hide");
    }
  });

  // Enable smooth scrolling for fixed navigation
  l("body.fixed-nav .sidebar").on("mousewheel DOMMouseScroll wheel", function (e) {
    var o;
    if (768 < l(window).width()) {
      o = (o = e.originalEvent).wheelDelta || -o.detail;
      this.scrollTop += 30 * (o < 0 ? 1 : -1);
      e.preventDefault();
    }
  });

  // Show/hide scroll-to-top button based on scroll position
  l(document).on("scroll", function () {
    if (100 < l(this).scrollTop()) {
      l(".scroll-to-top").fadeIn();
    } else {
      l(".scroll-to-top").fadeOut();
    }
  });

  // Smooth scroll to the top when the button is clicked
  l(document).on("click", "a.scroll-to-top", function (e) {
    var o = l(this);
    l("html, body").stop().animate({
      scrollTop: l(o.attr("href")).offset().top
    }, 1000, "easeInOutExpo");
    e.preventDefault();
  });
}(jQuery);
// 