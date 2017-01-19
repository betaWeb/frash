<?php
    namespace LFW\ORM\PGSQL;
    use LFW\Framework\Log\CreateLog;
    use LFW\ORM\{ Hydrator, RequestInterface };

    /**
     * Class QueryBuilder
     * @package LFW\ORM\PGSQL
     */
    class QueryBuilder extends Hydrator{
        /**
         * @var string
         */
        protected $bundle = '';

        /**
         * @var \PDO
         */
        protected $conn;

        /**
         * QueryBuilder constructor.
         * @param \PDO $conn
         * @param string $bundle
         */
        public function __construct(\PDO $conn, string $bundle){
            $this->bundle = $bundle;
            $this->conn = $conn;
        }

        /**
         * @param RequestInterface $request
         * @return int
         */
        public function insert(RequestInterface $request): int{
            try{
                CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());

                $req = $this->conn->prepare($request->getRequest());
                $req->execute($request->getExecute());

                return $this->conn->lastInsertId(str_replace('"', '', $request->getTable()).'_id_seq');
            }
            catch(\Exception $e){
                CreateLog::error($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param RequestInterface $select
         * @param string $hydrat
         * @return object
         */
        public function selectOne(RequestInterface $select, string $hydrat = 'without'){
            try{
                CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest());

                $request = $this->conn->prepare($select->getRequest());
                $request->execute($select->getExecute());
                $res = $request->fetch(\PDO::FETCH_OBJ);

                if($hydrat == 'without'){
                    return $res;
                }
                elseif($hydrat == 'with'){
                    return $this->hydration($res, 'Bundles\\'.$this->bundle.'\Entity\\'.$select->getEntity());
                }
            }
            catch(\Exception $e){
                CreateLog::error($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param RequestInterface $select
         * @param string $hydrat
         * @return array
         */
        public function selectMany(RequestInterface $select, string $hydrat = 'without'){
            try{
                CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest());

                $request = $this->conn->prepare($select->getRequest());
                $request->execute($select->getExecute());
                $res = $request->fetchAll(\PDO::FETCH_OBJ);

                if($hydrat == 'without'){
                    return $res;
                }
                elseif($hydrat == 'with'){
                    $count = count($res) - 1;
                    $array_obj = [];
                    $class = 'Bundles\\'.$this->bundle.'\Entity\\'.$select->getEntity();

                    for($i = 0; $i <= $count; $i++){
                        $array_obj[ $i ] = $this->hydration($res[ $i ], $class);
                    }

                    return $array_obj;
                }
            }
            catch(\Exception $e){
                CreateLog::error($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param RequestInterface $request
         */
        public function delete(RequestInterface $request){
            try{
                $req = $this->conn->prepare($request->getRequest());
                $req->execute($request->getExecute());

                CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());
            }
            catch(\Exception $e){
                CreateLog::error($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param RequestInterface $request
         */
        public function update(RequestInterface $request){
            try{
                $req = $this->conn->prepare($request->getRequest());
                $req->execute($request->getExecute());

                CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());
            }
            catch(\Exception $e){
                CreateLog::error($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param Custom $request
         * @return array
         */
        public function custom(RequestInterface $request){
            try{
                CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());

                $req = $this->conn->prepare($request->getRequest());
                $req->execute($request->getExecute());

                return $req->fetch(\PDO::FETCH_ASSOC);
            }
            catch(\Exception $e){
                CreateLog::error($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param Custom $request
         * @return array
         */
        public function customMany(RequestInterface $request){
            try{
                CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());

                $req = $this->conn->prepare($request->getRequest());
                $req->execute($request->getExecute());

                return $req->fetchAll(\PDO::FETCH_ASSOC);
            }
            catch(\Exception $e){
                CreateLog::error($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }
    }