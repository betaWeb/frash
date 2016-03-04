<?php
    namespace Composants\Console\Bundle;

    class GenerateBundle{
        public function __construct($name){
            mkdir('Bundles/'.$name);
            mkdir('Bundles/'.$name.'/Controllers');
            mkdir('Bundles/'.$name.'/Entity');
            mkdir('Bundles/'.$name.'/Requests');
            mkdir('Bundles/'.$name.'/Views');
        }
    }