# SW-Instagram Gallery Viewer

Demo: http://saintsean.com/

1. Update the INSTAGRAM_ACCESS_TOKEN found in the environment_variables.php file. Read below for more information.

2. Inside of your code where you want to display your image gallery place the php below. The first parameter is your username and the second parameter is the amount of images you want to display.
```
<?php
$Gallery = new swInstagramGalleryViewer('Your Username', '5');
$Gallery->displayImages();
?>
```

3. There is also an optional parameter on the displayImages function where you can input your own template. For Example the default template is this: <div class="imageContainer"><a target="_BLANK" href="'.$image['link'].'"><img src="'.$image['image'].'" width="100%" height="100%"></a></div> if you pass a different string including $image['link'] and $image['image'] you can display your image gallery how ever you want to.

## Authentication
How to receive your access token for instagram.

(https://www.instagram.com/developer/authentication)[https://www.instagram.com/developer/authentication]
