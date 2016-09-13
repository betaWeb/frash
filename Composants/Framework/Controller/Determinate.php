<?php
    namespace Composants\Framework\Controller;
    use Composants\Framework\Exception\DeterminateFail;

    /**
     * Class Determinate
     * @package Composants\Framework\Controller
     */
    class Determinate{
        /**
         * @param string $path
         * @param string $param
         * @return string
         */
        public function bundle($path, $param){
            $bundle = explode('/', dirname($path));

            if($param != 'not' && $param == 'with'){ return new DeterminateFail('Paramètre non valide'); }

            return ($param == 'not') ? str_replace('Bundle', '', end($bundle)) : end($bundle);
        }
    }