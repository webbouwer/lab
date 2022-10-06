<?php
/* Thorn v0.0.1 */

/* GET, POST, PUT, DELETE 
	data:
	- contacts
	- labels
	- projects
	- tasks
	- invoices
	- logs
*/ 

/* Development resources 

- https://codeigniter.com/user_guide/helpers/index.html

- Forms
	https://codeigniter.com/user_guide/helpers/form_helper.html

- Api
	create
	http://coreymaynard.com/blog/creating-a-restful-api-with-php/
*/

$manager = new manager;

class manager{

	public $page;

	public $labels;
	public $contacts;

	function manager(){
	
		require( $this->getSourceFolder() .'labels.php' );
		require( $this->getSourceFolder() .'contacts.php' );

		$this->page = basename($_SERVER['PHP_SELF'],'.php');

		$this->labels = new labelmanager();
		$this->contacts = new contactmanager();

		// $this->labels->setLabel('test3','test1');
		//$this->labels->delLabel(1);
		// $this->contacts->newContact( array( 'male', 'myname', array('test1','test2') ) );
		//$this->contacts->delContact(1);
		
		// echo $this->contacts->htmlForm(1);
		
		
		//$this->labels->output();
		//$this->contacts->output();
		
	}
	
	function getDataFolder(){
		return 'data/';
	}
	function getSourceFolder(){
		return 'src/';
	}
}

?>
<html> 
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript">

		window.onload = function() {
		
			var types = JSON.parse('<?php echo json_encode( $manager->contacts->types ); ?>');
			var selecttype = document.getElementById('typeselect');
			for(index in types) {
				selecttype.options[selecttype.options.length] = new Option(types[index], types[index]);
			}
			
			var labels = JSON.parse('<?php echo json_encode( $manager->labels->labels ); ?>');
			document.getElementById('labelinput').addEventListener("keyup", function(){
				if( labels[this.value] ){
					console.log( this.value );
				}
			});
			
			var contacts = JSON.parse('<?php echo json_encode( $manager->contacts->contacts ); ?>');
			var clist = '<ul>';
			$(contacts).each(function(index){
				clist += '<li>'+this.fullname+'</li>';
			});
			/*for(i=0;i<contacts.length;i++){
				clist += '<li>'+contacts[i].fullname+'</li>';
			}*/
			clist += '</ul>';
			document.getElementById('contactlist').innerHTML = clist;
			
			
		}
		
		function submitContactForm() {
			
				console.log( 'sending..' );
				var formtype = document.getElementById("formtype").value;
				var id = document.getElementById("id").value;
				var type = document.getElementById("typeselect").options[document.getElementById("typeselect").selectedIndex].value;
				var fullname = document.getElementById("fullname").value;
				var labels = document.getElementById("labelinput").value;
				
				// Returns successful data submission message when the entered information is stored in database.
				var dataString = 'formtype=' + formtype + '&id=' + id + '&type=' + type + '&fullname=' + fullname+ '&labels=' + labels;
				if (type == '' || fullname == '') {
					alert("Please at least select a type and name");
				} else {
				// AJAX code to submit form.
					$.ajax({
						type: "POST",
						url: "submit.php",
						data: dataString,
						cache: false,
						success: function(html) {
							alert(html);
						
						}
					});
				}
				return false;
			}
	</script> 
</head>
<body>
<div id="contactlist">
</div>

<div id="form contact">
	<form>
	<input id="id" type="hidden" name="id" value="">
    <input id="formtype" type="hidden" name="formtype" value="contact">
	<select id="typeselect" name="type">
    </select>
		<input id="fullname" type="text" name="fullname" size="30"> 
		<input type="text" data-hotkey="l" id="labelinput" name="labels" value="" placeholder="Labels" aria-label="Add labels" data-unscoped-placeholder="Add labels" data-scoped-placeholder="Labels" autocapitalize="off">
   		
        <input id="submit" onclick="submitContactForm()" type="button" value="Save">
    </form>
</div>

</body>
</html>