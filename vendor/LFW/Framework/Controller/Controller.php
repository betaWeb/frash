<?php
    namespace LFW\Framework\Controller;
    use LFW\Framework\DIC\Dic;
    use LFW\Framework\FileSystem\Json;

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

        public function generationAnalyzer(){
            $this->dic->load('analyzer')->generation();
        }
    }