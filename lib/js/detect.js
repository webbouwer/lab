var uagent = navigator.userAgent.toLowerCase();

function detectUserAgent(deviceName){
	return (uagent.search(deviceName) > -1)
}
function isTouch(){
   var el = document.createElement('div');
   el.setAttribute('ongesturestart', 'return;');
   if(typeof el.ongesturestart == "function"){
	  return true;
   }else {
	  return false
   }
}
function isDevice(){
	return (detectUserAgent("iphone") ||
			detectUserAgent("ipod") ||
			detectUserAgent("palm") ||
			detectUserAgent("android") ||
			detectUserAgent("series60") ||
			detectUserAgent("symbian") ||
			detectUserAgent("windows ce") ||
			detectUserAgent("windows phone") ||
			detectUserAgent("blackberry")
		); // ipad left out - only needs touch events
}
