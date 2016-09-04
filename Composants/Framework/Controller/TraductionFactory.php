<?php
    namespace Composants\Framework\Controller;

    /**
     * Class TraductionFactory
     * @package Composants\Framework\Controller
     */
    class TraductionFactory{
        /**
         * @param string $lang
         * @return mixed
         */
        public function trad($lang){
            $class = 'Traductions\\Trad'.ucfirst($lang);
            return new $class();
        }
    }