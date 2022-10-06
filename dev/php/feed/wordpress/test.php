<?php
$wp_api_url = "http://webdesigndenhaag.net/info/wp-json/wp/v2/posts"; // "http://webdesigndenhaag.net/lab/wp-json/wp/v2/posts";
$wppostdata = json_decode( file_get_contents($wp_api_url) );

header('Content-Type: application/json');
print json_encode($wppostdata);

?>