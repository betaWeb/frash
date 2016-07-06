<?php
    namespace Composants\Framework\Utility\Forms;
    use Composants\Framework\Globals\Session;

    /**
     * Class VerifForm
     * @package Composants\Framework\Utility\Forms
     */
    class VerifForm{
        /**
         * @var string
         */
        private $name_submit;

        /**
         * @var string
         */
        private $csrf;

        /**
         * @var bool
         */
        private $activ_csrf;

        /**
         * VerifForm constructor.
         * @param string $name_submit
         * @param bool $activ_csrf
         * @param string $csrf
         */
        public function __construct($name_submit, $activ_csrf, $csrf = ''){
            $this->name_submit = $name_submit;
            $this->activ_csrf = $activ_csrf;
            $this->csrf = $csrf;

            new Session();
        }

        public function valid(){
            if(isset($_POST[ $this->name_submit ])){
                if($this->activ_csrf){
                    return (Session::getSession('token') == $this->csrf) ? true : false;
                }
            }
            else{
                return false;
            }
        }
    }