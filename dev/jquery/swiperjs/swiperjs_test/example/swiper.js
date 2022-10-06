/* SwiperJS custom */
jQuery(function($){
// https://idangero.us/swiper/demos/
//https://idangero.us/swiper/api/#pagination
var menu = ['Slide 1', 'Slide 2', 'Slide 3', 'Slide 4'];

var swiperV = new Swiper('.swiper-container-v', {
  direction: 'vertical',
  spaceBetween: 0,
  hashNavigation: true,
  mousewheel: true,
  speed: 600,
  loop: true,
  /*pagination: {
    el: '.swiper-pagination-v',
    clickable: true,
  },*/
  // If we need pagination
    pagination: {
      el: '.swiper-pagination-v',
        clickable: true,
        renderBullet: function (index, className) {
          return '<span class="' + className + '">' + (menu[index]) + '</span>';
        },
    },
});

var swiperH = new Swiper('.swiper-container-h', {
  direction: 'horizontal',
  parallax: true,
  loop: true,
  speed: 600,
  navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
  },
  
  pagination: {
    el: '.swiper-pagination-h',
    //type: 'fraction',
    clickable: true,
  },
  slidesPerView: 1,
  //slidesPerColumn: 2,
  spaceBetween: 0,
  // Responsive breakpoints
  breakpointsInverse: true,
  breakpoints: {
    // when window width is >= 320px
    320: {
      slidesPerView: 1,
      spaceBetween: 10
    },
    // when window width is >= 480px
    560: {
      slidesPerView: 3,
      spaceBetween: 20
    },
    // when window width is >= 640px
    960: {
      slidesPerView: 5,
      spaceBetween: 20
    }
  },
  
 keyboard: {
    enabled: true,
    onlyInViewport: false,
  },
  /*
  
  mousewheel: {
  	enabled: false,
  },
  keyboard: {
  	enabled: true,
  },
  */
});



});
