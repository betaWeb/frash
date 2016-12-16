<?php
    namespace LFW\ORM\MySQL;
    use LFW\Framework\CreateLog\{ CreateErrorLog, CreateRequestLog };
    use LFW\ORM\{ Hydrator, RequestInterface };
    use LFW\ORM\PDO\PDO;

    /**
     * Class QueryBuilder
     * @package LFW\ORM\MySQL
     */
    class QueryBuilder extends Hydrator{
        /**
         * @var PDO
         */
        protected $conn;

        /**
         * @var string
         */
        protected $bundle;

        /**
         * QueryBuilder constructor.
         * @param PDO $conn
         * @param string $bundle
         */
        public function __construct(PDO $conn, string $bundle){
            $this->bundle = $bundle;
            $this->conn = $conn;
        }

        /**
         * @param RequestInterface $request
         * @return int
         */
        public function insert(RequestInterface $request): int{
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());
                $this->conn->request($request->getRequest(), $request->getExecute());
                return $this->conn->lastInsertId();
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param RequestInterface $select
         * @return object
         */
        public function selectOne(RequestInterface $select){
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest());

                $this->conn->request($select->getRequest(), $select->getExecute());
                $res = $this->conn->fetchObj();
                return $this->hydration($res, 'Bundles\\'.$this->bundle.'\Entity\\'.$select->getEntity());
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param RequestInterface $select
         * @return array
         */
        public function selectMany(RequestInterface $select): array{
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest());
                $ent = 'Bundles\\'.$this->bundle.'\Entity\\'.$select->getEntity();

                $this->conn->request($select->getRequest(), $select->getExecute());
                $res = $this->conn->fetchAllObj();

                $count = count($res) - 1;
                $array_obj = [];

                for($i = 0; $i <= $count; $i++){
                    $array_obj[ $i ] = $this->hydration($res[ $i ], $ent);
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
        public function count(RequestInterface $request): int{
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());

                $this->conn->request($request->getRequest(), $request->getExecute());
                return $req->rowCount();
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }
    }