<!DOCTYPE html>
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
<!-- <link rel="stylesheet" href="swiper.css" /> -->
<!-- Custom HTML elements -->


<script>
jQuery(function($){



    getData = function(){

        $.ajax({
            type: 'POST',
            url: 'data.php',
            //data: {json: JSON.stringify(json_data)},
            dataType: 'json',
        }).done( function( data ) {

            console.log('done');
            console.log(data);

            var fielddata = '';
            var textdata = '';

            if( data['fields']){

								let fields = data['fields'];
                $.each(data, function(idx, obj) {

                    if(idx == 'fields'){
                        /*$.each(obj, function(fkey, fieldname) {
                            fielddata += fieldname+' ';
                        });
                        fielddata += '<br />';*/
                    }else{
											
                        $.each(obj, function( key, value) {
                            textdata += '<div id="nr'+idx+'" class="entry"><div class="element" data-nr="'+idx+'" data-field="'+key+'">'+fields[key]+': <span class="inputbox">'+value+'</span></div></div>';
                        });
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

		saveData = function( tosave ){

			//alert( JSON.stringify( tosave ) );

			var senddata =  { 'data': tosave, 'action': 'save' };
			$.ajax({
					type: 'POST',
					url: 'data.php',
					data: senddata,
					dataType: 'json',
			}).done( function( data ) {
					console.log('done');
					//console.log(data);
					//displayList(data); //(for admins)
					//alert( JSON.stringify( data ) );

			})
			.fail( function( data ) {
					console.log('fail');
					//console.log(data);
			});

		}




    getData();



		$('body').on('click', '.inputbox:not(.edit)', function() {

	    let txt = $(this).html().trim();
	    let inp = $('<input class="textinput" type="text" value="' + txt + '" />');

	    $(this).addClass('edit');
	    $(this).html(inp);
			$('body').find('.inputbox.edit input.textinput').select();
	  });

	  $('body').on('blur', '.inputbox.edit input.textinput', function() {
	    let txt = $(this).val();
			let toSave = { 'nr': $(this).parent().parent().data('nr'), 'field': $(this).parent().parent().data('field'), 'content': txt };
			saveData( toSave );
	    $(this).parent().removeClass('edit').html(txt);
	  });


});
</script>

</head>
<body>
</body>
</html>
