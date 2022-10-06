<?php
/*  Linkedin Api

 	Company			Oddsized
   	Application Name	Oddsized Network
   	API Key			781heg4fxobqi4
   	Secret Key		yjvCgOkm3TPu3wpl
   	OAuth User Token	
   	OAuth User Secret	
	
    
    header: X-Restli-Protocol-Version: 2.0.0
    
    https://api.linkedin.com/v2/companies/{id}/updates
    
    https://www.linkedin.com/in/{name}/feed?start=0&v2=true
    
    api info;
    https://docs.microsoft.com/nl-nl/linkedin/shared/authentication/authorization-code-flow
    https://stackoverflow.com/questions/61937301/how-to-scrape-single-linkedin-post-with-php
    https://www.codexworld.com/login-with-linkedin-using-php/
    
    ? https://platform.linkedin.com/in.js
*/ 
?>

<html>
<head>
<title>Linkedin Api Dev</title> 

    
</head>
<body>
    



<?php 
$page=@file_get_contents("https://www.linkedin.com/posts/linkedin_simple-reminder-believe-in-yourself-activity-6668872904807092224-pMVk");
if($page){
    preg_match_all("/<p class=\"share-update-card__update-text public-post__update-text\">([^<]+)<\/p>/",$page,$matches);
    if(isset($matches[1][0])){
        echo $matches[1][0];
    }else{
        echo "No match found!";
    }
}else{
    echo "failed to load page";
}
?>

Update:

<?php 
$page=@file_get_contents("https://www.linkedin.com/posts/dineshkarna_the-biology-of-courage-what-is-that-ugcPost-6668335979088216064-nQwk/");
if($page){
    $data=array();

    preg_match_all("/<p class=\"share-update-card__update-text public-post__update-text\">([^<]+)<\/p>/",$page,$title_matches);
    if(isset($title_matches[1][0])){
        $data["title"]=$title_matches[1][0];
    }else{
        $data["title"]=null;
    }

    preg_match_all("/<video class=\"share-native-video__node video-js\"data-sources=\"(\[[^\]]*\])\"data-poster-url=\"([^\"]*)\".*><\/video>/",$page,$video_matches);
    if(isset($video_matches[1][0])){
        $data["videos"]=json_decode(html_entity_decode($video_matches[1][0]),true);
        var_dump($data["videos"]); 
        exit;
    }else{
        $data["videos"]=null;
    }

    var_dump($data);
    exit;
}else{
    echo "failed to load page";
}
?>

    

</body>
</html>