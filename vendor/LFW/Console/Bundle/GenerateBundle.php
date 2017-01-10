<?php
    namespace LFW\Console\Bundle;
    use LFW\Console\CommandInterface;
    use LFW\Framework\FileSystem\Directory;

    /**
     * Class GenerateBundle
     * @package LFW\Console\Bundle
     */
    class GenerateBundle implements CommandInterface{
        const CHMOD = 0770;
        const PREFIX = 'Bundles/';

        private $name = '';

        public function __construct(array $argv){
            $this->name = $argv[2];
        }

        public function work(){
            if(!file_exists(self::PREFIX)){
                Directory::create('Bundles', self::CHMOD);
                echo 'Dossier Bundles généré !'.PHP_EOL;
            }

            Directory::create(self::PREFIX.$this->name, self::CHMOD);
            Directory::create(self::PREFIX.$this->name.'/Controllers', self::CHMOD);
            Directory::create(self::PREFIX.$this->name.'/Entity', self::CHMOD);
            Directory::create(self::PREFIX.$this->name.'/Entity/Mapping', self::CHMOD);
            Directory::create(self::PREFIX.$this->name.'/Requests', self::CHMOD);
            Directory::create(self::PREFIX.$this->name.'/Ressources', self::CHMOD);
            Directory::create(self::PREFIX.$this->name.'/Views', self::CHMOD);

            echo 'Bundle généré !'.PHP_EOL;
        }
    }