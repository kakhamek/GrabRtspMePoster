## Grab RTSP.ME poster image from embed video player

```php
require_once('rtspme.php');

try {

    // RTSP.ME stream url
    $url = 'https://rtsp.me/embed/[ID]/';

    // Specify the full path where you want to save the image
    // Emaple: "/home/kakha/public_html/images/camera_poster.jpg"
    $savePath = '/path/to/save/cam_poster.jpg'; 
    
    $grabber = new RtspDotMe($url);

    $grabber->grab($savePath);
    echo "Image saved to $savePath";

} catch (InvalidArgumentException $e) {
    echo 'Error: ' . $e->getMessage();
} catch (RuntimeException $e) {
    echo 'Error: ' . $e->getMessage();
}
```