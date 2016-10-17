<?php
    namespace LFW\Framework\Forms;
    use LFW\Framework\Globals\Session;

    /**
     * Class VerifForm
     * @package LFW\Framework\Forms
     */
    class VerifForm{
        /**
         * @param string $csrf
         * @return bool
         */
        public function csrf($csrf){
            if($csrf != ''){
                $session = new Session;
                return ($session->getSession('token') == $csrf) ? true : false;
            }
        }

        /**
         * @param string $mail
         * @return bool
         */
        public function isMail($mail){
            return (filter_var($mail, FILTER_VALIDATE_EMAIL)) ? true : false;
        }
    }