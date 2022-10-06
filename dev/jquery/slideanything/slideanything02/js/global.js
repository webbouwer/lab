/* */


jQuery(document).ready(function($) {
								
								
/*_ _ _ _ _ _ _ _ _ _ _ _ _  view elements _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ */								
							
	// first control view bars & buttons etc. 
	
/*_ _ _ _ _ _ _ _ _ _ _ _ _  page elements _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ */
	
	// detect.js // to check use of position:fixed, touch/rollover and device/desktop : dsplDocinfo();
	
	
	// shape the page a bit
	function sectionShapes(){
		var windowheight = $(window).height();
		$('#headerslides').css('height', windowheight);
		$('.page-section-content').css('min-height', windowheight);
		
		var windowwidth = $(window).width();
		$('#page,div.item').css('width', windowwidth);
		$('#portfolioslides').css('min-height', (windowheight/4)*3);
	}

/*_ _ _ _ _ _ _ _ _ _ _ _ _  page waypoints _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ */
	/* Waypoints  
	- http://imakewebthings.com/jquery-waypoints/#doc-refresh
	*/
	
	/* Waypoints Navi Sections*/
	$('.page-section').waypoint(function(direction) {
        var $links = $('a[href="#' + this.id + '"]');
        $links.toggleClass('active', direction === 'down'); 
    }, {
        offset: '50%' // 
    }).waypoint(function(direction) {
    	var $links = $('a[href="#' + this.id + '"]');
        $links.toggleClass('active', direction === 'up');
    }, {
    	offset: function() {
        	return -$(this).height()/2; // 50%
        }
    });

/*_ _ _ _ _ _ _ _ _ _ _ _ _  page menu _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ */
	
	
	if(fixedSupport() != null){
		/* Waypoints Navi Sticky */
		$('#pagenav').waypoint(function(direction) {
			$(this).toggleClass('topbarfixed', direction === "down");
		}, {
			offset: 30 
		})
	}
	/* Smooth Scroll on Navi Sections */
	$('.page-section').each(function() {
    	var $panel = $(this);
    	var hash = '#' + this.id;
		$('a[href="' + hash + '"]').click(function(event) {
			//$('html,body').animate({scrollTop:$(hash).offset().top}, 1600);
			
			$(this).addClass('active');
	  
      		var duration=1600; // duration in ms
      		var easing='linear'; // easing values: swing | linear

			// set selector
        	if($.browser.safari) var animationSelector='body:not(:animated)';
        	else var animationSelector='html:not(:animated)';

        	// animate to target and set the hash to the window.location after the animation
        	$(animationSelector).animate({scrollTop:$(hash).offset().top}, 1600, function() {
            // add new hash to the browser location
      		window.location.href=window.location.href.replace(window.location.hash, hash);
        	});
        	// cancel default click action
      		return false; 
		});
	});


/*_ _ _ _ _ _ _ _ _ _ _ _ _  logo & buttons _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ */

	$('#gototop').hide();
	$('#gototop').click(function(event) {
			$('html,body').animate({scrollTop:$('#home').offset().top}, 2000);
			return false;
	});
	
	if(fixedSupport() != null){
		/* Waypoints Navi Sticky */
		$('#home').waypoint(function(direction) {										 
			if(direction == "down"){
				$('#gototop').fadeIn(300);
			}else{
				$('#gototop').fadeOut(150);
			}
		},{
		  offset: function() {
			return (-$(this).height());
		  }
		});
	}


/*_ _ _ _ _ _ _ _ _ _ _ _ _  scrollable area's _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ */

	/* Scrollable portfolio */
	var portfolio = $("#portfolioslides").scrollable({
		easing: 'linear',
		circular: true,
		speed: 500,
		interval: 8000
	}).navigator().autoscroll({
		autoplay: false,
		autopause: true
	});
	window.portfolioapi = $("#portfolioslides").data("scrollable");
	
	// portfolio scroll control top & bottom
	$('#portfolio').waypoint(function(direction) {										 
	  	if(direction == "up"){
			window.portfolioapi.pause(); // alert('Leave scroll area to top');
	  	}else{
	  		window.portfolioapi.play(); // alert('Enter scroll area from top');
		}
	},{
	  offset: function() {
		return ($(this).height()-100);
	  }
	}); 
	$('#portfolioslides').waypoint(function(direction) {										 
	  	if(direction == "up"){
			window.portfolioapi.play();// alert('Enter scroll area from bottom');
	  	}else{
	  		window.portfolioapi.pause(); 
		}
	},{
	  offset: function() {
		return (-$(this).height());
	  }
	});
	
/*_ _ _ _ _ _ _ _ _ _ _ _ _  section objects _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ */

	if(fixedSupport() != null){
		
		$('#info_object1').scrollingParallax({
			staticSpeed : .25
		}).css('position','fixed');
		
		$('#services_object1').scrollingParallax({
			staticSpeed : .3
		}).css('position','fixed');
		
		$('#info_object1,#services_object1').hide();
				
		$('#info').waypoint(function(direction) {										 
			if(direction == "down"){
				$('#info_object1').fadeIn(200);
			}else{
				$('#info_object1').fadeOut(50);
			}
		},{
		  offset: '60%'
		}).waypoint(function(direction) {										 
			if(direction == "up"){
				$('#info_object1').fadeIn(150);
			}else{
				$('#info_object1').fadeOut(100);
			}
		},{
		  offset: '-60%' // function() { return (200-$(this).height()); }
		});
		
		$('#services').waypoint(function(direction) {										 
			if(direction == "up"){
				$('#services_object1').fadeOut(100);
			}else{
				$('#services_object1').fadeIn(200);
			}
		},{
		  offset: '60%'
		}).waypoint(function(direction) {										 
			if(direction == "up"){
				$('#services_object1').fadeIn(200);
			}else{
				$('#services_object1').fadeOut(100);
			}
		},{
		  offset: '-60%'
		});
		
	}
	
	
	
	



	/*_ _ _ _ _ _ _ _ _ _ _ _ _  Anything slider _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ */
	
	$('#slider').anythingSlider({
					
					theme: 'fullscreen', // name of this setting/theme
					//resizeContents: true, // makes variable box height 
					expand: true, // strech to screensize
					
					//width               : null,      // Override the default CSS width
				  	//height              : null,      // Override the default CSS height
				  	//resizeContents      : true,      // If true, solitary images/objects in the panel will expand to fit the viewport
				
				  	// Navigation
				  	startPanel          : 1,         // This sets the initial panel
				  	hashTags            : true,      // Should links change the hashtag in the URL? - see navigation formatter
				  	buildArrows         : true,      // If true, builds the forwards and backwards buttons
				  	buildNavigation     : true,      // If true, buildsa list of anchor links to link to each panel
				  	buildStartStop		: true,
					
				  	forwardText         : "&raquo;", // Link text used to move the slider forward (hidden by CSS, replaced with arrow image)
				  	backText            : "&laquo;", // Link text used to move the slider back (hidden by CSS, replace with arrow image)
				
				  	// Slideshow options
				  	autoPlay            : true,      // This turns off the entire slideshow FUNCTIONALY, not just if it starts running or not
				  	startStopped        : false,     // If autoPlay is on, this can force it to start stopped
				  	pauseOnHover        : false,      // If true & the slideshow is active, the slideshow will pause on hover
				  	resumeOnVideoEnd    : true,      // If true & the slideshow is active & a youtube video is playing, it will pause the autoplay until the video has completed
				  	stopAtEnd           : false,     // If true & the slideshow is active, the slideshow will stop on the last page
				  	playRtl             : false,     // If true, the slideshow will move right-to-left
				  	startText           : "Start",   // Start button text
				  	stopText            : "Stop",    // Stop button text
				  	delay               : 9800,      // How long between slideshow transitions in AutoPlay mode (in milliseconds)
				  	animationTime       : 1200,       // How long the slideshow transition takes (in milliseconds)
				  	easing              : "swing",    // Anything other than "linear" or "swing" requires the easing plugin
					
					
        			// set this delay to fade out the current slide before animating
        			// set here to match the fade time
        			//delayBeforeAnimate : 500,			 	
					
					onSlideComplete : function(slider){ // update the hash AFTER the slide is in view (so we can animate)
						window.location.hash = '#' + slider.$currentPage[0].id;
						$('#current').html(window.location.hash); // get current
					},
					navigationFormatter : function(i, panel){
					return ['Webdesign', 'Interactief', 'Ontwerp', 'Ontwikkeling'][i - 1];
					}
					
				})
				.anythingSliderFx({
				// base FX definitions
				// '.selector' : [ 'effect(s)', 'size', 'time', 'easing' ]
				// 'size', 'time' and 'easing' are optional parameters, but must be kept in order if added
				
				//'.textSlide h3'       : [ 'top fade', '200px', '600', 'easeOutExpo' ],
				
				'.slidebox li'       : [ 'listLR', 'auto', '600', 'easeOutExpo' ],
				/*
				'.shapewrapper .combox1'    : [ 'left fade', '200px', '400', 'easeOutExpo' ],
				'.shapewrapper .combox2'    : [ 'top fade', '400px', '600', 'easeOutCirc' ],
				'.shapewrapper .combox3'    : [ 'top fade', '400px', '300', 'easeOutExpo' ],
				'.shapewrapper .combox4'    : [ 'bottom fade', '400px', '500', 'easeOutCirc' ],
				'.shapewrapper .combox5'    : [ 'left fade', '600px', '700', 'easeOutCirc' ],
				'.shapewrapper .combox6'    : [ 'bottom fade', '200px', '300', 'easeOutExpo' ], 
				*/
				
				
				/*
				// target the entire panel and fade will take 500ms
				// set opacity (value after the 'fade'),
				// the value must be between 0 and 1
				// (1 = 100% opacity and is the default)
				*/
				'.panel' : [ 'fade', '', 1000, 'easeInOutCirc' ],
				
				// http://proloser.github.com/AnythingSlider/demos.html#&panel3-4
				
				// custom FX definitions
				inFx : {
    			'.slidebox div.sbox1'	: { opacity: 1, top : '0%', duration: 600, easing : 'easeOutElastic' },
    			'.slidebox div.sbox2'	: { opacity: 1, bottom : '0%', duration: 1000, easing : 'easeOutElastic' },
    			'.slidebox div.sbox3'	: { opacity: 1, top : '0%', duration: 800, easing : 'easeOutElastic' }
				
   				}
				,
  				outFx : {
				'.slidebox div.sbox1' 	: { opacity: 0, top : '40%',  duration: 400, easing : 'easeOutExpo' },
				'.slidebox div.sbox2' 	: { opacity: 0, bottom : '20%', duration: 800, easing : 'easeOutExpo' },
				'.slidebox div.sbox3' 	: { opacity: 0, top : '30%', duration: 600, easing : 'easeOutExpo' }
			   	}
				
				
				
				
				});
	   
	   

				$('#info').waypoint(function(direction) {										 
					if(direction == "up"){
						$('#slider').data('AnythingSlider').startStop(true);// alert('Enter scroll area from bottom');
					}else{
						$('#slider').data('AnythingSlider').startStop(false); 
					}
				},{
				  offset: '90%'
				});




	
/*_ _ _ _ _ _ _ _ _ _ _ _ _  innitialize functions _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ */

	function pageSetting(){
		sectionShapes(); // page main elements
		window.portfolioapi.move(0, 500); // portfolio scrollable
	}
	/* onready (load) */
	pageSetting();
	
	/* onresize */
	$(window).resize(function(){
		pageSetting();
	});
	
});

$(window).load(function(){
	$('#loadscreen').delay(1000).fadeOut(500);
});
