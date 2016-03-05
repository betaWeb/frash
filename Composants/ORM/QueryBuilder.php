<?php
    namespace Composants\ORM;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Framework\CreateLog\CreateRequestLog;
    use Composants\ORM\Orm;
    use Composants\Yaml\Yaml;

    /**
     * Class QueryBuilder
     * @package Composants\ORM\Request
     */
    class QueryBuilder{
        /**
         * @var
         */
        private $conn;

        /**
         * @var
         */
        private $yaml;

        /**
         * QueryBuilder constructor.
         */
        public function __construct(){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));
            Orm::init($yaml['database']['host'], $yaml['database']['dbname'], $yaml['database']['username'], $yaml['database']['password']);
            $this->yaml = $yaml;
            $this->conn = Orm::getConnexion();
        }

        /**
         * @param $request
         * @param array $exec
         * @param bool $lastid
         * @return mixed
         */
        public function execRequest($request, $exec = [], $lastid = false){
            try{
                $req = $this->conn->prepare($request);
                $req->execute($exec);

                if($this->yaml['log']['request'] == 'yes'){
                    new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request."\n");
                }

                if($lastid === true){
                    return $this->conn->lastInsertId();
                }
            }
            catch(\Exception $e){
                if($this->yaml['log']['error'] == 'yes'){
                    new CreateErrorLog($e->getMessage());
                }

                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param $request
         * @param array $exec
         * @param $class
         * @return array
         */
        public function execRequestSelect($request, $exec = [], $class){
            try{
                $req = $this->conn->prepare($request);
                $req->execute($exec);
                $data = $req->fetchAll(\PDO::FETCH_CLASS, $class);

                $array = [];
                foreach($data as $v){
                    $array[] = $v;
                }

                if($this->yaml['log']['request'] == 'yes'){
                    new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request."\n");
                }

                return $array;
            }
            catch(\Exception $e){
                if($this->yaml['log']['error'] == 'yes'){
                    new CreateErrorLog($e->getMessage());
                }

                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param $table
         * @param $bundle
         * @return array
         */
        public function findAll($table, $bundle){
            try{
                $req = $this->conn->prepare('SELECT * FROM '.$table);
                $req->execute();
                $data = $req->fetchAll(\PDO::FETCH_CLASS, 'Bundles\\'.$bundle.'\\Entity\\'.ucfirst($table));

                $array = [];
                foreach($data as $v){
                    $array[] = $v;
                }

                if($this->yaml['log']['request'] == 'yes'){
                    new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : SELECT * FROM '.$table."\n");
                }

                return $array;
            }
            catch(\Exception $e){
                if($this->yaml['log']['error'] == 'yes'){
                    new CreateErrorLog($e->getMessage());
                }

                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param $request
         * @param array $exec
         * @return mixed
         */
        public function countResult($request, $exec = []){
            try{
                $req = $this->conn->prepare($request);
                $req->execute($exec);

                if($this->yaml['log']['request'] == 'yes'){
                    new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request."\n");
                }

                return $req->rowCount();
            }
            catch(\Exception $e){
                if($this->yaml['log']['error'] == 'yes'){
                    new CreateErrorLog($e->getMessage());
                }

                die('Il y a eu une erreur.');
            }
        }
    }