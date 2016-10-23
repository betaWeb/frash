<?php
    namespace LFW\Console\Bundle;

    /**
     * Class GenerateBundle
     * @package LFW\Console\Bundle
     */
    class GenerateBundle{
        const PREFIX = 'Bundles/';
    
        /**
         * GenerateBundle constructor.
         * @param string $name
         */
        public function __construct($name){
            if(!file_exists(self::PREFIX)){
                mkdir('Bundles', 0755);
                echo 'Dossier Bundles généré !'.PHP_EOL;
            }

            mkdir(self::PREFIX.$name);
            mkdir(self::PREFIX.$name.'/Controllers');
            mkdir(self::PREFIX.$name.'/Entity');
            mkdir(self::PREFIX.$name.'/Entity/Mapping');
            mkdir(self::PREFIX.$name.'/Requests');
            mkdir(self::PREFIX.$name.'/Ressources');
            mkdir(self::PREFIX.$name.'/Views');

            echo 'Bundle généré !'.PHP_EOL;
        }
    }