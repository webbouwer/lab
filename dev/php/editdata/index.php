<?php
		

?>
<html>
<head>

<!-- HTML meta -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, width=device-width" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<!-- HTML doc title -->
<title>data rw</title>
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="swiper.css" />
<!-- Custom HTML elements -->
<link rel="stylesheet" href="elements.css" />

    
<script>
jQuery(function($){
    

    
    getContactList = function(){
        
        $.ajax({
            type: 'POST', 
            url: 'contacts.php',
            //data: {json: JSON.stringify(json_data)},
            dataType: 'json',
        }).done( function( data ) { 
        
            console.log('done');
            console.log(data);
            
            var fielddata = '';
            var textdata = '';
            if( data['fields']){ 
                $.each(data, function(idx, obj) {
                    
                    if(idx == 'fields'){
                        $.each(obj, function(fkey, fieldname) {
                            fielddata += fieldname+' ';
                        });
                        fielddata += '<br />';
                    }else{
                        $.each(obj, function( key, value) {
                            textdata += value+' ';
                        });
                        textdata += '<br />';
                    }
                    
                });
            }
            
            $('body').html(fielddata + '' +textdata); 

        })
        .fail( function( data ) {
            console.log('fail');
            console.log(data);
        });
    }
    
    getContactList();
    
    
    
});
</script>
    
</head>
<body>
</body>
</html>