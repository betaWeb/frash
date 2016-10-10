<?php
    namespace LFW\Framework\Forms;
    use LFW\Framework\Globals\Session;

    /**
     * Class VerifForm
     * @package LFW\Framework\Forms
     */
    class VerifForm{
        /**
         * @param string $name_submit
         * @param bool $activ_csrf
         * @param string $csrf
         * @return bool
         */
        public function valid($name_submit, $activ_csrf, $csrf = ''){
            if(isset($_POST[ $name_submit ])){
                if($activ_csrf === true && $csrf != ''){
                    $session = new Session;
                    return ($session->getSession('token') == $csrf) ? true : false;
                }
            }
            else{
                return false;
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