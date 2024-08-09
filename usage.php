<?php

require_once('rtspme.php');

try {

    // RTSP.ME stream url
    $url = 'https://rtsp.me/embed/rthDG7af/';

    // Specify the full path where you want to save the image
    $savePath = '/path/to/save/cam_poster.jpg'; 
    
    $grabber = new RtspDotMe($url);

    $grabber->grab($savePath);
    echo "Image saved to $savePath";

} catch (InvalidArgumentException $e) {

    echo 'Error: ' . $e->getMessage();

} catch (RuntimeException $e) {

    echo 'Error: ' . $e->getMessage();
}

?>