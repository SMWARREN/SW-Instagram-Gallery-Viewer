<?php
/**
 * Instagram Gallery Viewer
 * A PHP class that will get and display your current instagram profile pictures.
 *
 * @category Instagram
 * @package  swInstagramGalleryViewer
 * @author   Sean Warren <sean.warren@gmail.com>
 */

include_once 'environment_variables.php';

class swInstagramGalleryViewer
{
    /**
     * @var string $sAccessToken The provided access token.
     * @var string $sUsername The provided username.
     * @var integer $iCount An integer which controls the amount of images to display.
     * @var array $aImages The array of images used to display the gallery.
     */

    private static $sAccessToken;
    public $sUsername;
    public $iCount;
    public $aImages = array();

    /*
    * The contructer for the swInstagramGalleryViewer class which initializes the
    * values used in the swInstagramGalleryViewer class.
    *
    * @param string $username  The username of the instagram account.
    * @param string $iCount    How many instagram images you want to display.
    */

    public function __construct($username, $iCount)
    {
        $this->sAccessToken = $_ENV["INSTAGRAM_ACCESS_TOKEN"];
        $this->sUsername = $username;
        $this->iCount = $iCount;
        self::getInstagramData();
    }

    /*
    * Helper function which returns the given access token.
    *
    * @return string $sAccessToken Returns the access token from instagram.
    */

    private function getAccessToken()
    {
        return $this->sAccessToken;
    }

    /*
    * This function parses the Instagram API for the most recent images and adds
    * the images to the url array.
    *
    * @return void
    */

    public function getInstagramData()
    {
        $sInstagramData = file_get_contents('https://api.instagram.com/v1/users/self/media/recent/?access_token='.self::getAccessToken());
        $sEncode = json_decode($sInstagramData, true);
        $aImagesData = $sEncode["data"];

        $iCount = $this->iCount;

        for ($x = 0; $x < $iCount; $x++) {
            $aUrl = $sEncode["data"][$x]["link"];
            $aImagesAndUrl =  array(
            'image' => $aImagesData[$x]["images"]["low_resolution"]["url"],
            'link' => $aUrl,
          );

            array_push($this->aImages, $aImagesAndUrl);
        }
    }

    /*
    * This function displays the Instagram posts on your webpage based on the
    * default template or provided template.
    *
    * @param string $template  The template used to display images.
    *
    * Example: <div class="imageContainer"><a target="_BLANK" href="'.$image['link'].'">
    * <img src="'.$image['image'].'" width="100%" height="100%"></a></div>
    *
    * @return string Returns a html string to be displayed.
    */

    public function displayImages($template = null)
    {
        if (count($this->aImages) <= 0) {
            throw new \Exception("Error there are no images to display ", 1);
        }
        if (is_null($template)) {
            foreach ($this->aImages as $image) {
                echo '<div class="imageContainer"><a target="_BLANK" href="'.$image['link'].'"><img src="'.$image['image'].'" width="100%" height="100%"></a></div>';
            }
        } else {
            foreach ($this->aImages as $image) {
                echo $template;
            }
        }
    }
}
