<?php
    namespace Composants\Framework\ORM\PGSQL;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Framework\CreateLog\CreateRequestLog;
    use Composants\Framework\ORM\PGSQL\Hydrator;
    use Composants\Framework\ORM\PGSQL\Request\Delete;
    use Composants\Framework\ORM\PGSQL\Request\Insert;
    use Composants\Framework\ORM\PGSQL\Request\Select;
    use Composants\Framework\ORM\PGSQL\Request\Update;

    /**
     * Class QueryBuilder
     * @package Composants\Framework\ORM\PGSQL
     */
    class QueryBuilder extends Hydrator{
        /**
         * @var object
         */
        private $conn;

        /**
         * QueryBuilder constructor.
         * @param object $conn
         */
        public function __construct($conn){
            $this->conn = $conn;
        }

        /**
         * @param Insert $request
         * @param string $lastid
         * @return int
         */
        public function insert(Insert $request, $lastid = ''){
            try{
                $req = $this->conn->prepare($request->getRequest());
                $req->execute($request->getExecute());

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());

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
         * @param Select $select
         * @param string $entity
         * @param string $bundle
         * @return array
         */
        public function selectOne(Select $select, $entity, $bundle){
            try{
                $req = $this->conn->prepare($select->getRequest());
                $req->execute($select->getExecute());
                $res = $req->fetch(\PDO::FETCH_OBJ);

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest());

                return self::hydration($res, $bundle, $entity);
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param Select $select
         * @param string $entity
         * @param string $bundle
         * @return array
         */
        public function selectMany(Select $select, $entity, $bundle){
            try{
                $req = $this->conn->prepare($select->getRequest());
                $req->execute($select->getExecute());
                $res = $req->fetchAll(\PDO::FETCH_OBJ);

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest());

                $count = count($res) - 1;
                $array_obj = [];

                for($i = 0; $i <= $count; $i++){
                    $array_obj[ $i ] = self::hydration($res[ $i ], $bundle, $entity);
                }

                return $array_obj;
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param Delete $request
         */
        public function delete(Delete $request){
            try{
                $req = $this->conn->prepare($request->getRequest());
                $req->execute($request->getExecute());

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param Update $request
         */
        public function update(Update $request){
            try{
                $req = $this->conn->prepare($request->getRequest());
                $req->execute($request->getExecute());

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param Select $request
         * @return int
         */
        public function count(Select $request){
            try{
                $req = $this->conn->prepare($request->getRequest());
                $req->execute($request->getExecute());

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());

                return $req->rowCount();
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }
    }