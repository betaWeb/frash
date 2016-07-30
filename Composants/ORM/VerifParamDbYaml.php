<?php
    namespace Composants\ORM;
    use Composants\Framework\Exception\ConnexionORMFail;

    /**
     * Class VerifParamDbYaml
     * @package Composants\ORM
     */
    class VerifParamDbYaml{
        /**
         * VerifParamDbYaml constructor.
         * @param array $conn
         * @param array $param
         */
        public function __construct($conn, $param){
            foreach($param as $key){
                if(empty($conn[ $key ])){ return new ConnexionORMFail('Le paramètre '.$key.' n\'est pas renseigné.'); }
            }
        }
    }