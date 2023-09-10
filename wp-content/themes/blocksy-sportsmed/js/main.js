document.addEventListener("DOMContentLoaded", function () {
  var videos = document.querySelectorAll(".stk-video-background");

  videos.forEach(function (video) {
    // Check if the video has the autoplay attribute
    var hasAutoplay = video.hasAttribute("autoplay");

    // If autoplay is present, remove the attribute
    if (hasAutoplay) {
      video.removeAttribute("autoplay");
    }

    var parentElement = video.parentElement;

    parentElement.addEventListener("mouseenter", function () {
      video.play();
    });

    parentElement.addEventListener("mouseleave", function () {
      video.pause();
    });

    parentElement.addEventListener("focusin", function () {
      video.play();
    });

    parentElement.addEventListener("focusout", function () {
      video.pause();
    });
  });
});

jQuery(document).ready(function ($) {
  // var swiper_testimonials = new Swiper(".swiper-testimonials", {
  //   autoplay: {
  //     delay: 8000,
  //     pauseOnMouseEnter: true,
  //     disableOnInteraction: false,
  //   },
  //   effect: "fade",
  //   fadeEffect: {
  //     crossFade: true,
  //   },
  //   loop: true,
  //   on: {
  //     autoplayTimeLeft: function (swiper, timeLeft, percentage) {

  //       var val = (timeLeft/8000) * 100;
  //       var $circle = $(".progress-bar .bar");

  //       if (isNaN(val)) {
  //         val = 100;
  //       } else {
  //         var r = $circle.attr("r");
  //         var c = Math.PI * (r * 2);

  //         if (val < 0) { val = 0; }
  //         if (val > 100) { val = 100; }

  //         var pct = ((100 - val) / 100) * c;

  //         $circle.css({ "strokeDashoffset": pct });

  //       }
  //     }
  //   }
  // });

  // var galleryThumbs = new Swiper('.gallery-thumbs', {
  //   spaceBetween: 10,
  //   slidesPerView: 4,
  //   loop: true,
  //   freeMode: true,
  //   loopedSlides: 5, //looped slides should be the same
  //   watchSlidesVisibility: true,
  //   watchSlidesProgress: true,
  // });

  const swiper = new Swiper(".swiper-gallery", {
    loop: true,
    // Navigation arrows
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });

  if ($(".gf-page-numbers-container").length) {
    // Add classes 'gform_wrapper' and 'gravity-theme' to the page numbers container
    $(".gf-page-numbers-container").addClass("gform_wrapper gravity-theme");

    // Find the 'stk-block-content' inside the 'gf-page-numbers-container'
    var stkBlockContent = $(".gf-page-numbers-container").find(
      ".stk-block-content"
    );

    // Move the contents of '.gf_page_steps' inside the 'stk-block-content'
    $(".gf_page_steps").appendTo(stkBlockContent);
  }

  /* $(document).on('DOMNodeInserted', '.sl-ddl-state', function() {
    $(document).off('DOMNodeInserted','.sl-ddl-state');
    // insert this in to .Filter_section div
    $(this).addClass('asl-advance-filters').prependTo('.Filter_section').children('.asl-filter-cntrl').addClass('asl-tabs-ddl');
    $('.search_filter').hide();
  }); */

  if ($("#gform_next_button_3_81").length) {
    var buttonHTML =
      '<a id="gform-get-started-now-button" href="/get-started-now/" type="button" class="gform_previous_button gform-theme-button gform-theme-button--secondary button">&larr;&nbsp; Find a SportsMed</a>';
    $("#gform_next_button_3_81").before(buttonHTML);
  }

});
