<?php
    namespace Composants\ORM;
    use Composants\Framework\Exception\Exception;
    use Composants\ORM\PDO\PDO;
    use Symfony\Component\Yaml\Yaml;

    /**
     * Class Orm
     * @package Composants\ORM
     */
    class Orm{
        /**
         * @var PDO
         */
        private $connexion;

        /**
         * Orm constructor.
         * @param string $bundle
         * @return Exception
         */
        public function __construct($bundle){
            $path = 'Composants/Configuration/database.yml';
            if(!file_exists($path)){ return new Exception('Le fichier database.yml n\'existe pas.'); }

            $yaml = Yaml::parse(file_get_contents($path));
            $bund = $yaml[ $bundle.'Bundle' ];
            if(empty($bund)){ return new Exception('Le bundle '.$bundle.' n\'existe pas.'); }

            try{
                switch($bund['system']){
                    case 'MySQL':
                        $this->connexion = new PDO('mysql:host='.$bund['host'].';dbname='. $bund['dbname'].';charset=UTF8;', $bund['username'], $bund['password'], []);
                        break;
                    case 'PGSQL':
                        $this->connexion = new PDO('pgsql:dbname='. $bund['dbname'].';host='.$bund['host'], $bund['username'], $bund['password']);
                        $this->connexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                        break;
                }
            }
            catch(\Exception $e){
                return new Exception($e->getMessage());
            }
        }

        /**
         * @return PDO
         */
        public function getConnexion(){
            return $this->connexion;
        }

        /**
         * @return int
         */
        public function getCountReq(){
            return $this->connexion->getCountReq();
        }
    }