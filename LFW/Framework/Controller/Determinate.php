<?php
    namespace LFW\Framework\Controller;
    use LFW\Framework\Exception\Exception;
    use LFW\Framework\Globals\Server;

    /**
     * Class Determinate
     * @package LFW\Framework\Controller
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