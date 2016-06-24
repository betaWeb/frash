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
        }

        public function valid(){
            if(isset($_POST[ $this->name_submit ])){
                $session = new Session();

                if($this->activ_csrf && $session->getSession('token') == $this->csrf){
                    return true;
                }
                elseif($this->activ_csrf && $session->getSession('token') != $this->csrf){
                    return false;
                }
            }
            else{
                return false;
            }
        }
    }