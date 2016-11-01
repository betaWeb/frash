<?php
    namespace LFW\ORM\PGSQL;
    use LFW\Framework\CreateLog\CreateErrorLog;
    use LFW\Framework\CreateLog\CreateRequestLog;
    use LFW\ORM\Hydrator;
    use LFW\ORM\RequestInterface;
    use LFW\ORM\PDO\PDO;

    /**
     * Class QueryBuilder
     * @package LFW\ORM\PGSQL
     */
    class QueryBuilder extends Hydrator{
        /**
         * @var PDO
         */
        protected $conn;

        /**
         * QueryBuilder constructor.
         * @param PDO $conn
         */
        public function __construct(PDO $conn){
            $this->conn = $conn;
        }

        /**
         * @param RequestInterface $request
         * @return int
         */
        public function insert(RequestInterface $request){
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());
                $this->conn->request($request->getRequest(), $request->getExecute());
                return $this->conn->lastInsertId(str_replace('"', '', $request->getTable()).'_id_seq');
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param RequestInterface $select
         * @param string $bundle
         * @return object
         */
        public function selectOne(RequestInterface $select, $bundle){
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest());

                $this->conn->request($select->getRequest(), $select->getExecute());
                $res = $this->conn->fetchObj();
                return $this->hydration($res, 'Bundles\\'.$bundle.'\Entity\\'.$select->getEntity());
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param RequestInterface $select
         * @param string $bundle
         * @return array
         */
        public function selectMany(RequestInterface $select, $bundle){
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest());

                $this->conn->request($select->getRequest(), $select->getExecute());
                $res = $this->conn->fetchAllObj();

                $count = count($res) - 1;
                $array_obj = [];

                for($i = 0; $i <= $count; $i++){
                    $array_obj[ $i ] = $this->hydration($res[ $i ], 'Bundles\\'.$bundle.'\Entity\\'.$select->getEntity());
                }

                return $array_obj;
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param RequestInterface $request
         */
        public function delete(RequestInterface $request){
            try{
                $this->conn->request($request->getRequest(), $request->getExecute());
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param RequestInterface $request
         */
        public function update(RequestInterface $request){
            try{
                $this->conn->request($request->getRequest(), $request->getExecute());
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param RequestInterface $request
         * @return int
         */
        public function count(RequestInterface $request){
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());
                $this->conn->request($request->getRequest(), $request->getExecute());
                return $this->conn->rowCount();
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param Custom $request
         * @return array
         */
        public function custom(RequestInterface $request){
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());
                $this->conn->request($request->getRequest(), $request->getExecute());
                return $this->conn->fetchAssoc();
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param Custom $request
         * @return array
         */
        public function customMany(RequestInterface $request){
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());
                $this->conn->request($request->getRequest(), $request->getExecute());
                return $this->conn->fetchAllAssoc();
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }
    }