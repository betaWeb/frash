<?php
    namespace Composants\Framework;
    use Composants\Framework\DIC\Dic;

    /**
     * Class ControllerFactory
     * @package Composants\Framework
     */
    class ControllerFactory{
        /**
         * @param Dic $dic
         * @param string $controller
         * @return object
         */
        public function getController(Dic $dic, $controller){
            return new $controller($dic);
        }
    }