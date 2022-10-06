
/* basic webview innitialize  */




var detectClient = function(){};

detectClient.prototype = {

  uagent: '',
  viewtype: '',
  
  textlog: '',

  defineView: function(){
      // function code..
      this.uagent = navigator.userAgent.toLowerCase();
	  var msg = '';
	  if( this.isDevice() ){
		  this.viewtype = 'mobile';
		  msg ='Mobile touch interface';
	  }else if( this.isTouch() ){
		  this.viewtype = 'tablet';
		  msg ='Tablet/touch interface';
	  }else{
		  this.viewtype = 'desktop';
		  msg ='Desktop interface';
	  }
	 	
	  console.log(msg);
	  document.body.className = this.viewtype;
	  this.startContent(); 
	  return;
  },
  
  startContent: function(){
	  
	  if (typeof(jQuery) != 'undefined') { // jquery
	  	
		jQuery(function($){
  			$(document).ready(function(){	
				$(document.body).animate({opacity: 1}, 1000);
  			});
		});
		
	  }else{
		  
		  document.body.style = "opacity:1;";
		  
	  }
	  
	  return;
  },
  
  detectUserAgent: function(deviceName){
	return (this.uagent.search(deviceName) > -1);
  },
  
  isDevice: function(){
	return (this.detectUserAgent("iphone") || 	 
			this.detectUserAgent("ipod") || 
			this.detectUserAgent("palm") || 
			this.detectUserAgent("android") || 	 
			this.detectUserAgent("series60") || 
			this.detectUserAgent("symbian") || 
			this.detectUserAgent("opera mobi") || 
			this.detectUserAgent("windows ce") || 
			this.detectUserAgent("windows phone") || 
			this.detectUserAgent("blackberry") || 
			this.detectUserAgent("playbook") || 
			this.detectUserAgent("kindle")		
		); // ipad left out - only needs touch events
		// see http://www.useragentstring.com/pages/Mobile%20Browserlist/
	},

	// DEVICE TYPE ///////////////////////////////////////////////////////////////////////////////
	isTouch: function(){
	   var el = document.createElement('div');
	   el.setAttribute('ongesturestart', 'return;');
	   if(typeof el.ongesturestart == "function"){
		  return true;
	   }else {
		  return false
	   }
	},
	// FUNCTION SUPPORT ///////////////////////////////////////////////////////////////////////////
	fixedSupport: function() { // http://kangax.github.com/cft/#IS_POSITION_FIXED_SUPPORTED
		var container = document.body;
		if (document.createElement &&
			container && container.appendChild && container.removeChild) {
			var el = document.createElement("div");
			if (!el.getBoundingClientRect) {
				return null; 
			}
			el.innerHTML = "x";
			el.style.cssText = "position:fixed;top:100px;";
			container.appendChild(el);
			var originalHeight = container.style.height, originalScrollTop = container.scrollTop;
			container.style.height = "3000px";
			container.scrollTop = 500;
			var elementTop = el.getBoundingClientRect().top;
			container.style.height = originalHeight;
			var isSupported = elementTop === 100;
			container.removeChild(el);
			container.scrollTop = originalScrollTop;
			return isSupported;
		}
		return null;
	}
}

/* Use the class */
window.onload = function(){

  var webClient = new detectClient();
  webClient.defineView();
  
}
