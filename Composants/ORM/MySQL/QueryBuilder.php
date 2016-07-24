<?php
    namespace Composants\ORM\MySQL;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Framework\CreateLog\CreateRequestLog;
    use Composants\Framework\Orm;
    use Composants\Yaml\Yaml;

    /**
     * Class QueryBuilder
     * @package Composants\ORM\MySQL
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
            $conn = Yaml::parse(file_get_contents('Others/config/database.yml'));
            $logs = Yaml::parse(file_get_contents('Others/config/config.yml'));

            Orm::init($conn['host'], $conn['dbname'], $conn['username'], $conn['password']);
            $this->yaml = $logs;
            $this->conn = Orm::getConnexion();
        }

        /**
         * @param $request
         * @param array $exec
         * @param bool $lastid
         * @return mixed
         */
        public function insert($request, $exec = [], $lastid = false){
            try{
                $req = $this->conn->prepare($request);
                $req->execute($exec);

                if($this->yaml['log']['request'] == 'yes'){
                    new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);
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
        public function select($request, $exec = [], $class, $bundle){
            try{
                $req = $this->conn->prepare($request);
                $req->execute($exec);
                $data = $req->fetchAll(\PDO::FETCH_CLASS, 'Bundles\\'.$bundle.'\Entity\\'.$class);

                $array = [];
                foreach($data as $v){
                    $array[] = $v;
                }

                if($this->yaml['log']['request'] == 'yes'){
                    new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);
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
         * @param $class
         * @param $bundle
         * @return array
         */
        public function jointure($request, $exec = [], $class, $bundle){
            try{
                $req = $this->conn->prepare($request);
                $req->execute($exec);
                $data = $req->fetchAll(\PDO::FETCH_CLASS, 'Bundles\\'.$bundle.'\Entity\Jointure\\'.$class);

                $array = [];
                foreach($data as $v){
                    $array[] = $v;
                }

                if($this->yaml['log']['request'] == 'yes'){
                    new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);
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
         */
        public function delete($request, $exec = []){
            try{
                $req = $this->conn->prepare($request);
                $req->execute($exec);

                if($this->yaml['log']['request'] == 'yes'){
                    new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);
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
         */
        public function update($request, $exec = []){
            try{
                $req = $this->conn->prepare($request);
                $req->execute($exec);

                if($this->yaml['log']['request'] == 'yes'){
                    new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);
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
                    new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : SELECT * FROM '.$table);
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
                    new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);
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