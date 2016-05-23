<?php
    namespace Composants\Console\Bundle;

    /**
     * Class GenerateBundle
     * @package Composants\Console\Bundle
     */
    class GenerateBundle{
        /**
         * GenerateBundle constructor.
         * @param $name
         */
        public function __construct($name){
            mkdir('Bundles/'.$name);
            mkdir('Bundles/'.$name.'/Controllers');
            mkdir('Bundles/'.$name.'/Entity');
            mkdir('Bundles/'.$name.'/Requests');
            mkdir('Bundles/'.$name.'/Views');

            echo 'Bundle généré !'.PHP_EOL;
        }
    }