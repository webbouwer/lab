$(document).ready(function(){

		var menu = $('.menubox');
		//var loop = true;
		var itemview = 5;


		if( menu.find('.button-up').length < 1 ){
			menu.append('<div class="button button-up">up</div>');
			menu.find('.button-up').hide();
		}
		if( menu.find('.button-down').length < 1 ){
			menu.append('<div class="button button-down">down</div>');
			if( menu.find('ul li').length * menu.find('ul li').height() < menu.find('ul').height() ){
				menu.find('.button-down').hide();
			}
		}



    $(document).on("click", ".button-up",function(){

        var scrollval =  menu.find('ul li').height() * itemview;
        var currentscrollval = parseInt(menu.find('ul').scrollTop( ));
        menu.find('ul').scrollTop(currentscrollval-scrollval);
				menu.find('.button-down').show();

    });




    $(document).on("click", ".button-down",function(){

        var scrollval = menu.find('ul li').height() * itemview;
        var currentscrollval = menu.find('ul').scrollTop();
        menu.find('ul').scrollTop(scrollval+currentscrollval);
				menu.find('.button-up').show();

    });




		menu.find('ul').bind('scroll', function(event){

			let obj = $(event.currentTarget);
			let max = obj[0].scrollHeight - obj[0].offsetHeight;

			if( obj.scrollTop() > max ) {
				menu.find('.button-down').hide(); //console.log("bottom");
				//menu.find('ul li').first().appendTo( menu.find('ul') );
			}
			if( obj.scrollTop() < 1 ) {
				menu.find('.button-up').hide();
			}

		});




		menu.find('ul').bind('mousewheel DOMMouseScroll MozMousePixelScroll', function(event) {

       event.preventDefault();
       var delta = event.originalEvent.wheelDelta || -event.originalEvent.detail;
			 setTimeout( function(){
			 	if(delta > 0 ){
					menu.find('.button-up').trigger('click');
				}else{
					menu.find('.button-down').trigger('click');
				}
			 }, 10);


		});


		$(window).resize(function(){

			if( $(document).offsetHeight < 1200 ){
				itemview = 4;
			}
			if( $(document).offsetHeight < 800 ){
				itemview = 3;
			}

		});



});
