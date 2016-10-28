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
        protected static $conn;

        /**
         * QueryBuilder constructor.
         * @param PDO $conn
         */
        public function __construct(PDO $conn){
            self::$conn = $conn;
        }

        /**
         * @param RequestInterface $request
         * @return int
         */
        public static function insert(RequestInterface $request){
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());
                self::$conn->request($request->getRequest(), $request->getExecute());
                return self::$conn->lastInsertId(str_replace('"', '', $request->getTable()).'_id_seq');
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
        public static function selectOne(RequestInterface $select, $bundle){
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest());
                $ent = 'Bundles\\'.$bundle.'\Entity\\'.$select->getEntity();

                self::$conn->request($select->getRequest(), $select->getExecute());
                $res = self::$conn->fetchObj();

                return self::hydration($res, $ent);
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
        public static function selectMany(RequestInterface $select, $bundle){
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest());
                $ent = 'Bundles\\'.$bundle.'\Entity\\'.$select->getEntity();

                self::$conn->request($select->getRequest(), $select->getExecute());
                $res = self::$conn->fetchAllObj();

                $count = count($res) - 1;
                $array_obj = [];

                for($i = 0; $i <= $count; $i++){
                    $array_obj[ $i ] = self::hydration($res[ $i ], $ent);
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
        public static function delete(RequestInterface $request){
            try{
                self::$conn->request($request->getRequest(), $request->getExecute());
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
        public static function update(RequestInterface $request){
            try{
                self::$conn->request($request->getRequest(), $request->getExecute());
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
        public static function count(RequestInterface $request){
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());
                self::$conn->request($request->getRequest(), $request->getExecute());
                return self::$conn->rowCount();
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }
    }