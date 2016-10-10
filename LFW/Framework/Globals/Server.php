<?php
    namespace Composants\Framework\Globals;

    /**
     * Class Server
     * @package Composants\Framework\Globals
     */
    class Server{
        /**
         * @return string
         */
        public static function getPhpSelf(){
            return $_SERVER['PHP_SELF'];
        }

        /**
         * @return string
         */
        public static function getGatewayInterface(){
            return $_SERVER['GATEWAY_INTERFACE'];
        }

        /**
         * @return string
         */
        public static function getServerAddr(){
            return $_SERVER['SERVER_ADDR'];
        }

        /**
         * @return string
         */
        public static function getServerName(){
            return $_SERVER['SERVER_NAME'];
        }

        /**
         * @return string
         */
        public static function getServerSoftware(){
            return $_SERVER['SERVER_SOFTWARE'];
        }

        /**
         * @return string
         */
        public static function getServerProtocol(){
            return $_SERVER['SERVER_PROTOCOL'];
        }

        /**
         * @return string
         */
        public static function getRequestMethod(){
            return $_SERVER['REQUEST_METHOD'];
        }

        /**
         * @return int
         */
        public static function getRequestTime(){
            return $_SERVER['REQUEST_TIME'];
        }

        /**
         * @return string
         */
        public static function getQueryString(){
            return $_SERVER['QUERY_STRING'];
        }

        /**
         * @return string
         */
        public static function getDocumentRoot(){
            return $_SERVER['DOCUMENT_ROOT'];
        }

        /**
         * @return string
         */
        public static function getHttpAccept(){
            return $_SERVER['HTTP_ACCEPT'];
        }

        /**
         * @return string
         */
        public static function getHttpAcceptCharset(){
            return $_SERVER['HTTP_ACCEPT_CHARSET'];
        }

        /**
         * @return string
         */
        public static function getHttpAcceptEncoding(){
            return $_SERVER['HTTP_ACCEPT_ENCODING'];
        }

        /**
         * @return string
         */
        public static function getHttpAcceptLanguage(){
            return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        }

        /**
         * @return string
         */
        public static function getHttpHost(){
            return $_SERVER['HTTP_HOST'];
        }

        /**
         * @return string
         */
        public static function getHttpReferer(){
            return $_SERVER['HTTP_REFERER'];
        }

        /**
         * @return string
         */
        public static function getHttpUserAgent(){
            return $_SERVER['HTTP_USER_AGENT'];
        }

        /**
         * @return string
         */
        public static function getHttps(){
            return $_SERVER['HTTPS'];
        }

        /**
         * @return string
         */
        public static function getRemoteAddr(){
            return $_SERVER['REMOTE_ADDR'];
        }

        /**
         * @return string
         */
        public static function getRemoteHost(){
            return $_SERVER['REMOTE_HOST'];
        }

        /**
         * @return int
         */
        public static function getRemotePort(){
            return $_SERVER['REMOTE_PORT'];
        }

        /**
         * @return string
         */
        public static function getScriptFilename(){
            return $_SERVER['SCRIPT_FILENAME'];
        }

        /**
         * @return string
         */
        public static function getServerAdmin(){
            return $_SERVER['SERVER_ADMIN'];
        }

        /**
         * @return int
         */
        public static function getServerPort(){
            return $_SERVER['SERVER_PORT'];
        }

        /**
         * @return string
         */
        public static function getServerSignature(){
            return $_SERVER['SERVER_SIGNATURE'];
        }

        /**
         * @return string
         */
        public static function getPathTranslated(){
            return $_SERVER['PATH_TRANSLATED'];
        }

        /**
         * @return string
         */
        public static function getScriptName(){
            return $_SERVER['SCRIPT_NAME'];
        }

        /**
         * @return string
         */
        public static function getRequestUri(){
            return $_SERVER['REQUEST_URI'];
        }

        /**
         * @return string
         */
        public static function getPhpAuthDigest(){
            return $_SERVER['PHP_AUTH_DIGEST'];
        }

        /**
         * @return string
         */
        public static function getPhpAuthUser(){
            return $_SERVER['PHP_AUTH_USER'];
        }

        /**
         * @return string
         */
        public static function getPhpAuthPw(){
            return $_SERVER['PHP_AUTH_PW'];
        }

        /**
         * @return string
         */
        public static function getAuthType(){
            return $_SERVER['AUTH_TYPE'];
        }

        /**
         * @return string
         */
        public static function getPathInfo(){
            return $_SERVER['PATH_INFO'];
        }

        /**
         * @return string
         */
        public static function getOrigPathInfo(){
            return $_SERVER['ORIG_PATH_INFO'];
        }

        /**
         * @return array
         */
        public static function getAllRequest(){
            return $_SERVER;
        }
    }