<?php
    namespace Composants\Framework\Controller;
    use Composants\Framework\Exception\Exception;

    /**
     * Class Determinate
     * @package Composants\Framework\Controller
     */
    class Determinate{
        /**
         * @param string $path
         * @param string $param
         * @return Exception|string
         */
        public function bundle($path, $param){
            $bundle = explode('/', dirname($path));

            if($param != 'not' && $param != 'with'){ return new Exception('Determinate : Paramètre non valide'); }

            return ($param == 'not') ? str_replace('Bundle', '', end($bundle)) : end($bundle);
        }
    }