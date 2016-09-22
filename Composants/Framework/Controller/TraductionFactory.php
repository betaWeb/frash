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

        /**
         * @param string $string
         * @param array $search
         * @param string $lang
         * @return mixed
         */
        public function translate($string, $search, $lang){
            $class = 'Traductions\\Trad'.ucfirst($lang);
            $trad = new $class();

            $str = $string;

            foreach($search as $v){
                str_replace('%'.$v.'%', $trad->show($v), $str);
            }

            return $str;
        }
    }