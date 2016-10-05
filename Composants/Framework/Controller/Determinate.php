<?php
    namespace Composants\Framework\Controller;
    use Composants\Framework\Exception\Exception;
    use Composants\Framework\Globals\Server;

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

        /**
         * @return string
         */
        public function uri(){
            return ltrim(Server::getRequestUri(), '/');
        }
    }