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
         * QueryBuilder constructor.
         */
        public function __construct(){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));
            Orm::init($yaml['database']['host'], $yaml['database']['dbname'], $yaml['database']['username'], $yaml['database']['password']);
            $this->conn = Orm::getConnexion();
        }

        /**
         * @param $request
         * @param bool $exec
         */
        public function execRequest($request, $exec = false){
            try{
                $req = $this->conn->prepare($request);

                if(!empty($exec)){ $req->execute($exec); }
                else{ $req->execute(); }

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request."\n");
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param $request
         * @param bool $exec
         * @param $class
         * @return array
         */
        public function execRequestSelect($request, $exec = false, $class){
            try{
                $req = $this->conn->prepare($request);

                if(!empty($exec)){ $req->execute($exec); }
                else{ $req->execute(); }

                $data = $req->fetchAll(\PDO::FETCH_CLASS, $class);
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }

            $array = [];

            foreach($data as $v){
                $array[] = $v;
            }

            new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request."\n");
            return $array;
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
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }

            $array = [];
            foreach($data as $v){
                $array[] = $v;
            }

            new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : SELECT * FROM '.$table."\n");
            return $array;
        }

        /**
         * @param $request
         * @param bool $exec
         * @return mixed
         */
        public function countResult($request, $exec = false){
            if(!empty($request) && !strstr(' LIMIT ', $request) && !strstr(' ORDER BY ', $request)){
                try{
                    $req = $this->conn->prepare($request);

                    if(!empty($exec)){ $req->execute($exec); }
                    else{ $req->execute(); }
                }
                catch(\Exception $e){
                    new CreateErrorLog($e->getMessage());
                    die('Il y a eu une erreur.');
                }

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request."\n");
                return $req->rowCount();
            }
        }
    }