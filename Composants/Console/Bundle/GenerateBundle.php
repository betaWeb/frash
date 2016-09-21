<?php
    namespace Composants\Console\Bundle;

    /**
     * Class GenerateBundle
     * @package Composants\Console\Bundle
     */
    class GenerateBundle{
        const PREFIX = 'Bundles/';
    
        /**
         * GenerateBundle constructor.
         * @param string $name
         */
        public function __construct($name){
            mkdir(self::PREFIX.$name);
            mkdir(self::PREFIX.$name.'/Controllers');
            mkdir(self::PREFIX.$name.'/Entity');
            mkdir(self::PREFIX.$name.'/Requests');
            mkdir(self::PREFIX.$name.'/Views');

            echo 'Bundle généré !'.PHP_EOL;
        }
    }