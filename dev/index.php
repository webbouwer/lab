
<!-- Dev from  Server\oddsized.com\lab.oddsized.com\dev\js -->

<!DOCTYPE html>
<html>
<head>

<!-- HTML meta -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="initial-scale=1.0, width=device-width" />

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<!-- HTML doc title -->
<title>Projects Lab</title>

<!-- meta tags -->
<meta name="description" content="Basic HTML5 boilerplate v1 2022">
<meta name="author" content="Webbouwer">
<meta name="keywords" content="HTML5, HTML, boilerplate, template, html template, basic, basic html">

<!-- jQuery and/or other libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Custom
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.4/imagesloaded.min.js"></script>
<link rel="stylesheet" href="elements.css" />
 -->

<!-- Custom view/page style -->
<style>
body
{
margin:0;
padding:0;
}
iframe#pages
{
    height:80vh;
    width:100vw;
}
</style>

</head>
<body>

<!-- content display -->
<div id="pagecontainer">

<!-- variable content -->
<h1>Testing Lab Webbouwer</h1>
Work in progress
<?php



		 $dirs = array_filter(glob('*'), 'is_dir');

		  if(is_array( $dirs ) && count($dirs) > 0 ){

			  echo '<div>';

			  foreach($dirs as $name ){

					if( $name != '.' && $name != '.'){

						echo '<a style="display:inline-block;color:black;background-color:#efefef;padding:2px 3px;margin:2px;" href="'. $name .'" target="pages">'. $name .'</a>';

					}

			  }

			  echo '</div>';

		  }else{

			  echo '<p>No folders found</p>';

		  }







		?>



</div>
<iframe id="pages" name="pages" src="https://www.webbouwer.org/lab/dev/jquery/isotope/setup">
</iframe>
</body>
</html>
