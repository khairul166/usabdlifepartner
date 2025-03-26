$(document).ready(function(){
    $('.couple-slider').slick({
       dots: false, // Show dot indicators
       arrows: true, // Show navigation arrows
       infinite: true, // Infinite looping
       speed: 200, // Transition speed
       slidesToShow: 3, // Number of slides to show at once
       autoplay: true, // Enable auto-slide
       slidesToScroll: 1, // Number of slides to scroll
       responsive: [
          {
             breakpoint: 992, // Breakpoint for medium screens
             settings: {
                slidesToShow: 2,
                slidesToScroll: 1
             }
          },
          {
             breakpoint: 768, // Breakpoint for small screens
             settings: {
                slidesToShow: 1,
                slidesToScroll: 1
             }
          }
       ]
    });

    $('.testim-slider').slick({
        dots: false, // Show dot indicators
        arrows: true, // Show navigation arrows
        infinite: true, // Infinite looping
        speed: 200, // Transition speed
        slidesToShow: 3, // Number of slides to show at once
        slidesToScroll: 1, // Number of slides to scroll
        autoplay: true, // Enable auto-slide
        autoplaySpeed: 3000, // Auto-slide interval (3 seconds)
        responsive: [
           {
              breakpoint: 992, // Breakpoint for medium screens
              settings: {
                 slidesToShow: 2,
                 slidesToScroll: 1
              }
           },
           {
              breakpoint: 768, // Breakpoint for small screens
              settings: {
                 slidesToShow: 1,
                 slidesToScroll: 1
              }
           }
        ]
     });
 });

