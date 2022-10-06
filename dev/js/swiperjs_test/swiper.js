/* SwiperJS custom */
jQuery(function($){

/* custom swiper */
var swipemenu = ['Slide 1', 'Slide 2', 'Slide 3', 'Slide 4'];
var swiper_page_vertical = new Swiper('.swiper-container', {

  direction: 'vertical',
  freeMode: false,
  slidesPerView: 'auto', //'auto' 
  spaceBetween: 0,
  mousewheel: true,
  loop: true,
  autoHeight: true,
  speed: 600,
  parallax: true,
  //runCallbacksOnInit: true,

  pagination: {
    el: '.swiper-pagination',
    clickable: true,
    renderBullet: function(index, className) {
      return '<span class="' + className + '">' + (swipemenu[index]) + '</span>';
    },
  },
  hashNavigation: {
    replaceState: true,
    watchState: true,
  },
  scrollbar: {
    el: '.swiper-scrollbar',
    draggable: true,
  },

});


/* on resize */
var resizeId;
$(window).resize(function() {
  clearTimeout(resizeId);
  resizeId = setTimeout(doneResizing, 20);
});

function doneResizing() {
  swiper_page_vertical.update();
  swiper_page_vertical.scrollbar.updateSize();
}


/* scrolling .. */
var boxscroll = 0;
var scrollamount = 0;

$('.swiper-slide').scrollTop(1);


$(window).on('touchstart scroll wheel DOMMouseScroll', function(e){

    var prevscroll = boxscroll;
    var activeSlide = $('.swiper-slide-active');
    var viewheight = activeSlide.find('.swiper-slide-wrap').height();
    var scrollheight = activeSlide.find('.swiper-slide-content').height();

    scrollamount = activeSlide.find('.swiper-slide-wrap').scrollTop();

    if( viewheight < scrollheight ){
        disable_swiper();
        activeSlide.find('.swiper-slide-wrap').addClass('scrollactive');
        $('.swiper-event-info').fadeIn(400);
        $('.swiper-event-info').html( scrollamount +' ('+prevscroll+') .. '+ (scrollheight-viewheight) );
        
        boxscroll = scrollamount; 
        
        if( scrollamount >= (scrollheight-viewheight) ){
            swiper_page_vertical.slideNext(swiper_page_vertical.speed);
            activeSlide.find('.swiper-slide-wrap').removeClass('scrollactive');
            boxscroll = 0; 
        }
        if( scrollamount <= 0 && scrollamount <= prevscroll && prevscroll != 0){
            swiper_page_vertical.slidePrev(swiper_page_vertical.speed);
            activeSlide.find('.swiper-slide-wrap').removeClass('scrollactive');
            boxscroll = 0; 
        }


        /*
    	disable_swiper();
            if( scrollamount > prevscroll && scrollamount >= (scrollheight-viewheight) ){
            	boxscroll = 1;
              dir = 1;
              activeSlide.find('.swiper-slide-wrap').scrollTop(1);
              swiper_page_vertical.slideNext(swiper_page_vertical.speed);
              //enable_swiper();
            }else if( scrollamount <= prevscroll && prevscroll != 1 && scrollamount <= 0 ){
             boxscroll = 1;
              dir = -1;
              activeSlide.find('.swiper-slide-wrap').scrollTop(1);
              swiper_page_vertical.slidePrev(swiper_page_vertical.speed);
              //enable_swiper();
            }
      			boxscroll = scrollamount;

            */
    }else{
            enable_swiper();
            activeSlide.find('.swiper-slide-wrap').removeClass('scrollactive');
            $('.swiper-event-info').fadeOut(400);
    }



});

swiper_page_vertical.on('transitionStart', function () {
    $('.swiper-slide').find('.swiper-slide-wrap').animate({ 'scrollTop': 1 }, swiper_page_vertical.speed );
});
swiper_page_vertical.on('slideNextTransitionEnd', function () {
});
function disable_swiper(){
    swiper_page_vertical.detachEvents();
    swiper_page_vertical.mousewheel.disable();
    //swiper_page_vertical.unsetGrabCursor();
}
function enable_swiper(){
    swiper_page_vertical.attachEvents();
    swiper_page_vertical.mousewheel.enable();
    //swiper_page_vertical.setGrabCursor();
}


});
