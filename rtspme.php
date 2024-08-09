<?php
/**
 * ########::'########::'######::'########:::::::'##::::'##:'########:
 * ##.... ##:... ##..::'##... ##: ##.... ##:::::: ###::'###: ##.....::
 * ##:::: ##:::: ##:::: ##:::..:: ##:::: ##:::::: ####'####: ##:::::::
 * ########::::: ##::::. ######:: ########::::::: ## ### ##: ######:::
 * ##.. ##:::::: ##:::::..... ##: ##.....:::::::: ##. #: ##: ##...::::
 * ##::. ##::::: ##::::'##::: ##: ##::::::::'###: ##:.:: ##: ##:::::::
 * ##:::. ##:::: ##::::. ######:: ##:::::::: ###: ##:::: ##: ########:
 * ..:::::..:::::..::::::......:::..:::::::::...::..:::::..::........::
 * 
 * Filename: rtspme.php
 * Author: Kakhaber Mekvabishvili
 * Date: August 2024
 * 
 */

Class RtspDotMe 
{

    private $url;

    /**
     * Constructor for the class.
     * 
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;

        /**
         * Validate the URL format.
         */
        if(!preg_match('/^https?:\/\/.*/', $this->url))
        {
            throw new InvalidArgumentException("Invalid URL for camera ID: $this->url");
        }
    }

    /**
     * Grabs a poster image and saves it to the specified path.
     * 
     * @param string $savePath The path where the image will be saved.
     * @return void
     */
    public function grab(string $savePath)
    {
        /**
         * Get url content
         */
        $html = @file_get_contents($this->url);

        if($html === false)
        {
            throw new RuntimeException("Failed to retrieve content from URL: $this->url");
        }

        /**
         * Parses HTML content using DOMDocument.
         * 
         * For more information, refer to the PHP manual:
         * Mannual: https://www.php.net/manual/en/class.domdocument.php 
         */
        $doc = new DOMDocument();
        @$doc->loadHTML($html);

        /**
         * Find and retrieve the <video> tag.
         */
        $videoTags = $doc->getElementsByTagName('video');
        $poster = null;

        if($videoTags->length > 0)
        {
            /**
             * Retrieve the 'poster' attribute from <video> tag.
             */
            $poster = $videoTags->item(0)->getAttribute('poster');
        }

        if($poster)
        {
            /**
             * Retrieve the image content from the 'poster' URL.
             * 
             * Example URL: "https://frn.rtsp.me/vY34hUswMz1E8JAPpJq20Q/1723217386/poster/rthDG7af.jpg"
             */
            $imageContent = @file_get_contents($poster);

            if($imageContent !== false)
            {
                /**
                 * Save the image content to the specified path.
                 * 
                 *  $savePath example: "/home/kakha/public_html/images/camera_poster.jpg"
                 */
                file_put_contents($savePath, $imageContent);
            }
            else
            {
                throw new RuntimeException("Failed to retrieve poster image for camera ID: $this->url");
            }

        }
        else
        {
            throw new RuntimeException("No video tag found for camera ID: $this->url");
        }
    }
}