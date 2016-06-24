<?php
    namespace Composants\Framework\Http;

    /**
     * Class Http
     * @package Composants\Framework\Http
     */
    class Http{
        /**
         * @return string
         */
        public function getPhpSelf(){
            return $_SERVER['PHP_SELF'];
        }

        /**
         * @return string
         */
        public function getGatewayInterface(){
            return $_SERVER['GATEWAY_INTERFACE'];
        }

        /**
         * @return string
         */
        public function getServerAddr(){
            return $_SERVER['SERVER_ADDR'];
        }

        /**
         * @return string
         */
        public function getServerName(){
            return $_SERVER['SERVER_NAME'];
        }

        /**
         * @return string
         */
        public function getServerSoftware(){
            return $_SERVER['SERVER_SOFTWARE'];
        }

        /**
         * @return string
         */
        public function getServerProtocol(){
            return $_SERVER['SERVER_PROTOCOL'];
        }

        /**
         * @return string
         */
        public function getRequestMethod(){
            return $_SERVER['REQUEST_METHOD'];
        }

        /**
         * @return int
         */
        public function getRequestTime(){
            return $_SERVER['REQUEST_TIME'];
        }

        /**
         * @return string
         */
        public function getQueryString(){
            return $_SERVER['QUERY_STRING'];
        }

        /**
         * @return string
         */
        public function getDocumentRoot(){
            return $_SERVER['DOCUMENT_ROOT'];
        }

        /**
         * @return string
         */
        public function getHttpAccept(){
            return $_SERVER['HTTP_ACCEPT'];
        }

        /**
         * @return string
         */
        public function getHttpAcceptCharset(){
            return $_SERVER['HTTP_ACCEPT_CHARSET'];
        }

        /**
         * @return string
         */
        public function getHttpAcceptEncoding(){
            return $_SERVER['HTTP_ACCEPT_ENCODING'];
        }

        /**
         * @return string
         */
        public function getHttpAcceptLanguage(){
            return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        }

        /**
         * @return string
         */
        public function getHttpHost(){
            return $_SERVER['HTTP_HOST'];
        }

        /**
         * @return string
         */
        public function getHttpReferer(){
            return $_SERVER['HTTP_REFERER'];
        }

        /**
         * @return string
         */
        public function getHttpUserAgent(){
            return $_SERVER['HTTP_USER_AGENT'];
        }

        /**
         * @return string
         */
        public function getHttps(){
            return $_SERVER['HTTPS'];
        }

        /**
         * @return string
         */
        public function getRemoteAddr(){
            return $_SERVER['REMOTE_ADDR'];
        }

        /**
         * @return string
         */
        public function getRemoteHost(){
            return $_SERVER['REMOTE_HOST'];
        }

        /**
         * @return int
         */
        public function getRemotePort(){
            return $_SERVER['REMOTE_PORT'];
        }

        /**
         * @return string
         */
        public function getScriptFilename(){
            return $_SERVER['SCRIPT_FILENAME'];
        }

        /**
         * @return string
         */
        public function getServerAdmin(){
            return $_SERVER['SERVER_ADMIN'];
        }

        /**
         * @return int
         */
        public function getServerPort(){
            return $_SERVER['SERVER_PORT'];
        }

        /**
         * @return string
         */
        public function getServerSignature(){
            return $_SERVER['SERVER_SIGNATURE'];
        }

        /**
         * @return string
         */
        public function getPathTranslated(){
            return $_SERVER['PATH_TRANSLATED'];
        }

        /**
         * @return string
         */
        public function getScriptName(){
            return $_SERVER['SCRIPT_NAME'];
        }

        /**
         * @return string
         */
        public function getRequestUri(){
            return $_SERVER['REQUEST_URI'];
        }

        /**
         * @return string
         */
        public function getPhpAuthDigest(){
            return $_SERVER['PHP_AUTH_DIGEST'];
        }

        /**
         * @return string
         */
        public function getPhpAuthUser(){
            return $_SERVER['PHP_AUTH_USER'];
        }

        /**
         * @return string
         */
        public function getPhpAuthPw(){
            return $_SERVER['PHP_AUTH_PW'];
        }

        /**
         * @return string
         */
        public function getAuthType(){
            return $_SERVER['AUTH_TYPE'];
        }

        /**
         * @return string
         */
        public function getPathInfo(){
            return $_SERVER['PATH_INFO'];
        }

        /**
         * @return string
         */
        public function getOrigPathInfo(){
            return $_SERVER['ORIG_PATH_INFO'];
        }

        /**
         * @return array
         */
        public function getAllRequest(){
            return $_SERVER;
        }
    }