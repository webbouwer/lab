jQuery(function($){

/* custom setup
var checkboxes = document.getElementsByTagName('input');

for (var i=0; i<checkboxes.length; i++)  {
  if (checkboxes[i].type == 'checkbox')   {
    checkboxes[i].checked = false;
  }
}*/


function set_fullheight_elements(){
    $('.fullheight,.swiper-slide-wrap').each( function( idx, el ){
        $(this).innerHeight( $('.swiper-container').height() );
    });
}
function setControls(){
    $('.custom-control input').prop('checked', false);
    /* custom controls
    https://www.w3schools.com/howto/howto_css_switch.asp
    */
    $('#swipeboxToggle').on('change', function(){
        $('.swiper-container').toggleClass('boxview'); // element class
        $(window).trigger('resize'); // global window resize
        set_fullheight_elements(); // content height
    });

    $('#scrollbarToggle').on('change', function(){
        $('.swiper-container').toggleClass('hidescrollbar');
    });
    $('#colorToggle').on('change', function(){
        $('body').toggleClass('colorshow');
    });
    $('#colorToggle').trigger('click');

}

set_fullheight_elements();
setControls();

});
