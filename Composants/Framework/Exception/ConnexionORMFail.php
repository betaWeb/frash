<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class ConnexionORMFail
     * @package Composants\Framework\Exception
     */
    class ConnexionORMFail{
        /**
         * ConnexionORMFail constructor.
         */
        public function __construct($message){
            new CreateErrorLog('La connexion à la base de données par l\'ORM n\'a pu être effectuée : '.$message);

            header('HTTP/1.0 404 Not Found', true, 404);
            die();
        }
    }