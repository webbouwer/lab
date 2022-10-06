<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head> 



<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Oddsized Interctive- Webdesign & development</title>



<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />



<title>Webdesign Den Haag - Webdesign, vormgeving en web ontwikkeling - wordpress, javascript</title>



<meta name="description" content="Basic HTML5 template">

<meta name="author" content="Carl Müller">

<meta name="keywords" content="Webdesign,den haag,webdesign,webbouwer,website,wordpress,vormgeving,web,ontwikkeling,applicaties,webapp,javascript">



<!-- without animation -->

<link rel="shortcut icon" href="../src/media/favicon.ico" >

<link rel="icon" type="image/gif" href="../src/media/anifavicon.gif" > 



<link rel="canonical" href="https://www.webdesigndenhaag.net" /> 

<link rel="pingback" href="https://www.webdesigndenhaag.net" />

		

<meta property="og:title" content="Webdesign Den Haag - Webdesign, vormgeving en web ontwikkeling - wordpress, javascript"/>

<meta property="og:image" content="IMAGE_URL"/>

<meta property="og:description" content="Vormgeving en ontwikkeling van logo + website, huisstijl pakket, campagne vormgeving, trajecten en projecten, website of webapp, wij kunnen u van dienst zijn. Website met customized themes en plugins in Wordpress, webdevelopment in oa. javascript en php"/>

<meta property="og:url" content="https://www.webdesigndenhaag.net" />

		

<!-- device specific -->

<meta name="apple-mobile-web-app-capable" content="yes" />



<!-- older IE versions: declare css3 queries and html5 tags through js -->

<!--[if lt IE 9]> 

	<script src="src/html5.js"></script>

	<script src="src/cssmediaqueries.js">// or cdn google http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js </script>

<![endif]-->

		

<!-- JS libs - fastest cdn load? https://www.cdnperf.com

		our choice: https://docs.microsoft.com/en-us/aspnet/ajax/cdn/overview 

		might wanna use: https://developers.google.com/speed/libraries/?csw=1 

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>

-->

		 

<!-- custom scripts.. 

<script src="src/webview.js"></script>

<link rel="stylesheet" type="text/css" href="../src/media/style.css" /> 

-->		

<!-- mobile specific.. 

<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

-->

<meta name="viewport" content="initial-scale=1.0, width=device-width" />





 






    </head>



     <body style="color:black;background-color:#ffffff;">

    

    <div align="center" style="padding-top:12%;"> 

 

   

    <p><a href="http://lab.oddsized.com"><img src="https://lab.oddsized.com/dev/oddsized_pixel_morph.gif" /></a></p>

    <h3>dev.oddsized.com</h3>

        

        <p><a href="https://lab.oddsized.com/dev">lab.oddsized.com/dev</a></p> 

        <?php 

    

     $dirs = array_filter(glob('*'), 'is_dir');

      if(is_array( $dirs ) && count($dirs) > 1 ){

          echo '<div>';

          foreach($dirs as $name ){

                if( $name != '.' && $name != '.'){

                    echo '<a style="display:inline-block;color:black;background-color:#efefef;padding:2px 3px;margin:2px;" href="'. $name .'">'. $name .'</a>';

                }

          }

          echo '</div>';

      }else{

          echo '<p>No folders found</p>';

      }







    ?>


    

</div>

    </body>

    </html>