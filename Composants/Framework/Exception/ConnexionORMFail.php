<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Controller;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class ConnexionORMFail
     * @package Composants\Framework\Exception
     */
    class ConnexionORMFail extends Controller{
        /**
         * ConnexionORMFail constructor.
         */
        public function __construct(){
            new CreateErrorLog('La connexion à la base de données par l\'ORM n\'a pu être effectuée');

            return $this->view('ConnexionORMFail.html.twig', 'Exception');
        }
    }