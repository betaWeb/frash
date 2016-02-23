<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Response\Response;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class ConnexionORMFail
     * @package Composants\Framework\Exception
     */
    class ConnexionORMFail{
        /**
         * ConnexionORMFail constructor.
         */
        public function __construct(){
            new CreateErrorLog('La connexion à la base de données par l\'ORM n\'a pu être effectuée');
            return new Response('ConnexionORMFail.html.twig', 'Exception');
        }
    }