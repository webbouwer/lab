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
<!-- Custom HTML elements -->
<link rel="stylesheet" href="style.css" />


<script>
jQuery(function($){

  $(document).ready(function () {

    getPlayers = function(){

        $.ajax({
            type: 'POST',
            url: 'players.php',
            //data: {json: JSON.stringify(json_data)},
            dataType: 'json',
        }).done( function( data ) {

            console.log('done');
            //console.log(data);
            //displayList(data); //(for admins)
						onlinePlayers(data);
        })
        .fail( function( data ) {
            console.log('fail');
            //console.log(data);
        });
    }

	function displayList(data){

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
												if(key === 'email' && value == '') value = 'unknown';
                            textdata += value+' ';
                        });
                        textdata += '<br />';
                    }

                });
            }

            $('body').html(fielddata + '' +textdata);
	}


	function onlinePlayers(data){
			var playerdata = '';
            if( data['fields']){
				var c = 0;
                $.each(data, function(idx, obj) {
					if(idx != 'fields' && obj.status != 0 ){
						c++;
                        playerdata += '<div id="'+obj.name+'" data-nr="'+c+'" data-name="'+obj.name+'">'+c+' '+obj.name+' <span class="remove">x</span></div>';
                    }
                });
				if( c== 0){
					playerdata += 'No players online<br />';
				}
            }
            $('#player-list').html(playerdata);
	}



	addPlayer = function(){

		if( $('#playername').val() == '' ){
		}
		if( $('#playername').val() != '' && isEmail($('#playeremail').val()) ){
		}
		if( $('#playerpassword').val() != '' ){
		}

		var senddata =  {nm:$('#playername').val(), em:$('#playeremail').val(), pw: $('#playerpassword').val(), do: 'save' };

        $.ajax({
            type: 'POST',
            url: 'players.php',
            data: senddata,
            dataType: 'json',
        }).done( function( data ) {
            console.log('done');
            //console.log(data);
            //displayList(data); //(for admins)
			onlinePlayers(data);
        })
        .fail( function( data ) {
            console.log('fail');
            //console.log(data);
        });
    }

		removePlayer = function(idx=false, name=false){

			if( !idx ){

			}
			if( !name ){

			}
			var senddata =  { nr:idx, nm: name, do: 'del' };

	        $.ajax({
	            type: 'POST',
	            url: 'players.php',
	            data: senddata,
	            dataType: 'json',
	        }).done( function( data ) {
	            console.log('done');
	            //console.log(data);
	            //displayList(data); //(for admins)
							onlinePlayers(data);
	        })
	        .fail( function( data ) {
	            console.log('fail');
	            //console.log(data);
	        });

		}

    getPlayers();

	$('#join').click(function(){
    	addPlayer();
	});

	$('body').on('click', '.remove', function(){
		let q ='Remove '+$(this).parent().data('name') +"?";
		let x = confirm(q);
		if (x == true){
			removePlayer( $(this).parent().data('nr'), $(this).parent().data('name') );
		}

		/*
			//alert( 'player: '+  $(this).parent().attr('id') );
			name = prompt("Remove: "+ $(this).parent().data('name'));

			if(name != null && name != "")
			removePlayer( $(this).parent().data('nr'), $(this).parent().data('name') );
			else
		  console.log('no action');
			*/
	});

	 // Attach the event handler for the keyboard keyup
	 $('#playername').keyup(function () {
		var $th = $(this);
		// run the expression and replace with nothing
		$th.val($th.val().replace(/[^a-zA-Z0-9]/g, function () {
		  return '';
		}));
	  });

	  function isEmail(email) {
		  var EmailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		  return EmailRegex.test(email);
	  }

  });

});
</script>

</head>
<body>
<div id="player-login">
	<input id="playername" type="text" placeholder="nickname" />
	<input id="playeremail" type="text" placeholder="email" />
	<input id="playerpassword" type="text" placeholder="password" />
	<input id="join" type="button" value="join" />
</div>
<div id="player-list">
</div>

</body>
</html>
