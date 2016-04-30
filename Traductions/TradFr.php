<?php
    namespace Traductions;

    /**
     * Class TradFr
     * @package Traductions
     */
    class TradFr{
        // private name = 'value';

        /**
         * @param $trad
         * @return mixed
         */
        public function show($trad){
            return $this->$trad;
        }
    }