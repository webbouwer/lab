<?php
/**
 * Parse document in correct content type
 * returns js, xml or json
 */
if( $_GET['token'] && $_GET['token'] == 'test'){

if($_GET['url']){

// get extension by checking last 4 characters (enough for an extension)
$url = $_GET['url'];
$length = strlen($url);
$characters = 4;
$start = $length - $characters;
$url = substr($time , $start ,$characters);
$ext = explode(".", $url); // drop the dot
$type = $ext[1];

if($_GET['type']){ 
    $type = $_GET['type'];
}

if($type == 'js'){
// set javascript headers
header("Content-Type: application/javascript");
}else
if($type == 'xml'){
// set xml headers
header('Content-type: text/xml; charset=utf-8');
}else
if($type == 'json'){
// set json
header('Content-type: application/json; charset=utf-8'); 
}else
{
// set xml (default)
header('Content-type: text/plain; charset=utf-8');
}
echo file_get_contents($_GET['url']);

}else{

echo 'Usage: https://webdesigndenhaag.net/factory/xhtml/parse/ ?type=(type of data)&url=(content url)';

}
    
}else{

echo 'Not allowed, valid token not found';

}
    

?>
