<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Updates HTML</title>
<!-- jquery -->
<script   src="https://code.jquery.com/jquery-1.12.4.min.js"   integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<!-- updates code 

https://stackoverflow.com/questions/8951810/how-to-parse-json-data-with-jquery-javascript
https://www.sitepoint.com/ajaxjquery-getjson-simple-example/
WP: https://wptheming.com/2013/07/simple-ajax-example/
-->
<script type="text/javascript" language="javascript">

$(document).ready(function(){

var maxitems = 15;

$('#feedbox').html('Loading..');

$.getJSON('feeds.php', { get_param: 'value' }, function(data) {
	
	$('#feedbox').html('');
	
	var c = 0;
    $.each(data, function(index, element) {
	
		if( element.pubdate ){
		
			c++;
			if( c > maxitems ) return;
			
			var item = $('<li>');
			
			var title = element.description;
			var date = element.pubdate;
			if( !element.description && element.title ){
			title = element.title;
			}
			
			item.append($('<h3>', {
				html: title
			}));
			item.append($('<small>', {
				html: date+' at '+element.source
			}));
			
			$('#feedbox').append(item);
			
    	}
		
		
	});
	
});

   
});



</script>
</head>
<body>

<ul id="feedbox">
</ul>

</body>
</html>
