<?php
    namespace Composants\Framework\Utility\Forms;
    use Composants\Framework\Globals\Session;

    /**
     * Class VerifForm
     * @package Composants\Framework\Utility\Forms
     */
    class VerifForm{
        /**
         * @param string $name_submit
         * @param bool $activ_csrf
         * @param string $csrf
         * @return bool
         */
        public static function valid($name_submit, $activ_csrf, $csrf = ''){
            new Session();

            if(isset($_POST[ $name_submit ])){
                if($activ_csrf){
                    return (Session::getSession('token') == $csrf) ? true : false;
                }
            }
            else{
                return false;
            }
        }
    }