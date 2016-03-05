<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Response\Response;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Yaml\Yaml;

    /**
     * Class ConnexionORMFail
     * @package Composants\Framework\Exception
     */
    class ConnexionORMFail{
        /**
         * ConnexionORMFail constructor.
         */
        public function __construct(){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));

            if($yaml['log']['error'] == 'yes'){
                new CreateErrorLog('La connexion à la base de données par l\'ORM n\'a pu être effectuée');
            }
            
            return new Response('ConnexionORMFail.html.twig', 'Exception');
        }
    }