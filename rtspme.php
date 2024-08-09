<?php
/**
 * '########::'########::'######::'########:::::::'##::::'##:'########:
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
 * Date: Aug, 2024
 * 
 */

Class RtspDotMe 
{

    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;

        /**
         * URL Validate
         */
        if(!preg_match('/^https?:\/\/.*/', $this->url))
        {
            throw new InvalidArgumentException("Invalid URL for camera ID: $this->url");
        }
    }

    public function grab($savePath)
    {

        $html = @file_get_contents($this->url);

        if($html === false)
        {
            throw new RuntimeException("Failed to retrieve content from URL: $this->url");
        }

        /**
         * Use DOMDocument
         * Mannual: https://www.php.net/manual/en/class.domdocument.php 
         */
        $doc = new DOMDocument();
        @$doc->loadHTML($html);

        /**
         * Find video tag
         */
        $videoTags = $doc->getElementsByTagName('video');
        $poster = null;

        if($videoTags->length > 0)
        {
            /**
             * Find poster attribute in video tag
             */
            $poster = $videoTags->item(0)->getAttribute('poster');
        }

        if($poster)
        {
            /**
             * Get image
             */
            $imageContent = @file_get_contents($poster);

            if($imageContent !== false)
            {
                /**
                 * Save image
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