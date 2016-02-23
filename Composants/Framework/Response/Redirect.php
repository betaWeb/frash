<?php
    namespace Composants\Framework\Response;

    /**
     * Class Redirect
     * @package Composants\Framework\Response
     */
    class Redirect{
        /**
         * Redirect constructor.
         * @param $url
         */
        public function __construct($url){
            header('Location:'.$url);
        }
    }