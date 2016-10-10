<?php
    namespace LFW\Framework\Controller;
    use LFW\Framework\DIC\Dic;

    /**
     * Class Controller
     * @package LFW\Framework\Controller
     */
    class Controller{
        /**
         * @var Dic
         */
        private $dic;

        /**
         * Controller constructor.
         * @param Dic $dic
         */
        public function __construct(Dic $dic){
            $this->dic = $dic;
        }

        /**
         * @return object
         */
        public function call($controller){
            return new $controller($this->dic);
        }
    }