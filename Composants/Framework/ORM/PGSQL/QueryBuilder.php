<?php
    namespace Composants\Framework\ORM\PGSQL;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Framework\CreateLog\CreateRequestLog;
    use Composants\Yaml\Yaml;

    /**
     * Class QueryBuilder
     * @package Composants\Framework\ORM\PGSQL
     */
    class QueryBuilder{
        /**
         * @var mixed
         */
        private $conn;

        /**
         * @var array
         */
        private $yaml = [];

        /**
         * QueryBuilder constructor.
         */
        public function __construct($conn){
            $this->yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));
            $this->conn = $conn;
        }

        /**
         * @param string $request
         * @param array $exec
         * @param bool $lastid
         * @return int
         */
        public function insert($request, $exec = [], $lastid = false){
            try{
                $req = $this->conn->prepare($request);
                $req->execute($exec);

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);

                if(!empty($lastid)){
                    return $this->conn->lastInsertId($lastid);
                }
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param string $request
         * @param array $exec
         * @param string $class
         * @param string $bundle
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

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);

                return $array;
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param string $request
         * @param array $exec
         */
        public function delete($request, $exec = []){
            try{
                $req = $this->conn->prepare($request);
                $req->execute($exec);

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param string $request
         * @param array $exec
         */
        public function update($request, $exec = []){
            try{
                $req = $this->conn->prepare($request);
                $req->execute($exec);

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param string $table
         * @param string $bundle
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

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : SELECT * FROM '.$table);

                return $array;
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param string $request
         * @param array $exec
         * @return int
         */
        public function countResult($request, $exec = []){
            try{
                $req = $this->conn->prepare($request);
                $req->execute($exec);

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);

                return $req->rowCount();
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }
    }