(function ($) {
  $(".toggle-nav").click(function () {
    $("#sidebar-links .nav-menu").css("left", "0px");
  });
  $(".mobile-back").click(function () {
    $("#sidebar-links .nav-menu").css("left", "-410px");
  });
  $(".page-wrapper").attr(
    "class",
    "page-wrapper " + localStorage.getItem("page-wrapper")
  );
  if (localStorage.getItem("page-wrapper") === null) {
    $(".page-wrapper").addClass("compact-wrapper");
  }

  // left sidebar and vertical menu
  if ($("#pageWrapper").hasClass("compact-wrapper")) {
    jQuery(".sidebar-title").append(
      '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
    );
    jQuery(".sidebar-title").click(function () {
      jQuery(".sidebar-title")
        .removeClass("active")
        .find("div")
        .replaceWith(
          '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
        );
      jQuery(".sidebar-submenu, .menu-content").slideUp("normal");
      jQuery(".menu-content").slideUp("normal");
      if (jQuery(this).next().is(":hidden") == true) {
        jQuery(this).addClass("active");
        jQuery(this)
          .find("div")
          .replaceWith(
            '<div class="according-menu"><i class="fa fa-angle-down"></i></div>'
          );
        jQuery(this).next().slideDown("normal");
      } else {
        jQuery(this)
          .find("div")
          .replaceWith(
            '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
          );
      }
    });
    // jQuery(".sidebar-submenu, .menu-content").hide();
    jQuery(".submenu-title").append(
      '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
    );
    jQuery(".submenu-title").click(function () {
      jQuery(".submenu-title")
        .removeClass("active")
        .find("div")
        .replaceWith(
          '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
        );
      jQuery(".submenu-content").slideUp("normal");
      if (jQuery(this).next().is(":hidden") == true) {
        jQuery(this).addClass("active");
        jQuery(this)
          .find("div")
          .replaceWith(
            '<div class="according-menu"><i class="fa fa-angle-down"></i></div>'
          );
        jQuery(this).next().slideDown("normal");
      } else {
        jQuery(this)
          .find("div")
          .replaceWith(
            '<div class="according-menu"><i class="fa fa-angle-right"></i></div>'
          );
      }
    });
    jQuery(".submenu-content").hide();
  } 

  // toggle sidebar
  $nav = $(".sidebar-wrapper");
  $header = $(".page-header");
  $toggle_nav_top = $(".toggle-sidebar");
  $toggle_nav_top.click(function () {
    $nav.toggleClass("close_icon");
    $header.toggleClass("close_icon");
    $(window).trigger("overlay");
  });

  $(window).on("overlay", function () {
    $bgOverlay = $(".bg-overlay");
    $isHidden = $nav.hasClass("close_icon");
    if ($(window).width() <= 1184 && !$isHidden && $bgOverlay.length === 0) {
      $('<div class="bg-overlay active"></div>').appendTo($("body"));
    }

    if ($isHidden && $bgOverlay.length > 0) {
      $bgOverlay.remove();
    }
  });

  $(".sidebar-wrapper .back-btn").on("click", function (e) {
    $(".page-header").toggleClass("close_icon");
    $(".sidebar-wrapper").toggleClass("close_icon");
    $(window).trigger("overlay");
  });

  $("body").on("click", ".bg-overlay", function () {
    $header.addClass("close_icon");
    $nav.addClass("close_icon");
    $(this).remove();
  });

  $body_part_side = $(".body-part");
  $body_part_side.click(function () {
    $toggle_nav_top.attr("checked", false);
    $nav.addClass("close_icon");
    $header.addClass("close_icon");
  });

  //    responsive sidebar
  var $window = $(window);
  var widthwindow = $window.width();
  (function ($) {
    "use strict";
    if (widthwindow <= 1184) {
      $toggle_nav_top.attr("checked", false);
      $nav.addClass("close_icon");
      $header.addClass("close_icon");
    }
  })(jQuery);
  $(window).resize(function () {
    var widthwindaw = $window.width();
    if (widthwindaw <= 1184) {
      $toggle_nav_top.attr("checked", false);
      $nav.addClass("close_icon");
      $header.addClass("close_icon");
    } else {
      $toggle_nav_top.attr("checked", true);
      $nav.removeClass("close_icon");
      $header.removeClass("close_icon");
    }
  });

  // horizontal arrows
  var view = $("#sidebar-menu");
  var move = "500px";
  var leftsideLimit = -500;

  var getMenuWrapperSize = function () {
    return $(".sidebar-wrapper").innerWidth();
  };
  var menuWrapperSize = getMenuWrapperSize();

  if (menuWrapperSize >= "1660") {
    var sliderLimit = -3000;
  } else if (menuWrapperSize >= "1440") {
    var sliderLimit = -3600;
  } else {
    var sliderLimit = -4200;
  }

  $("#left-arrow").addClass("disabled");
  $("#right-arrow").click(function () {
    var currentPosition = parseInt(view.css("marginLeft"));
    if (currentPosition >= sliderLimit) {
      $("#left-arrow").removeClass("disabled");
      view.stop(false, true).animate(
        {
          marginLeft: "-=" + move,
        },
        {
          duration: 400,
        }
      );
      if (currentPosition == sliderLimit) {
        $(this).addClass("disabled");
        console.log("sliderLimit", sliderLimit);
      }
    }
  });

  $("#left-arrow").click(function () {
    var currentPosition = parseInt(view.css("marginLeft"));
    if (currentPosition < 0) {
      view.stop(false, true).animate(
        {
          marginLeft: "+=" + move,
        },
        {
          duration: 400,
        }
      );
      $("#right-arrow").removeClass("disabled");
      $("#left-arrow").removeClass("disabled");
      if (currentPosition >= leftsideLimit) {
        $(this).addClass("disabled");
      }
    }
  });


})(jQuery);
