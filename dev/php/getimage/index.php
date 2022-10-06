<?php
if( $_GET['url']){
	$url = $_GET['url'];
}else{
	$url = "http://www.webdesigndenhaag.net";
}
$html = file_get_contents( $url );
preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i',$html,$matches);

$img = str_replace($url,"",$matches[1][0]); // incase it is a static url

echo $img;
/* dehaagsemaatschap
echo '<hr/>';
echo $matches[1][0];
echo '<hr/>';
echo $matches[1][1];
echo '<hr/>';
echo $matches[1][2];
echo '<hr/>';
*/
?>