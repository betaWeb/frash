<?php
    namespace LFW\ORM\PGSQL;
    use LFW\Framework\CreateLog\CreateErrorLog;
    use LFW\Framework\CreateLog\CreateRequestLog;
    use LFW\ORM\Hydrator;
    use LFW\ORM\PDO\PDO;
    use LFW\ORM\PGSQL\Request\Delete;
    use LFW\ORM\PGSQL\Request\Insert;
    use LFW\ORM\PGSQL\Request\Select;
    use LFW\ORM\PGSQL\Request\Update;

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
         * @param Insert $request
         * @return int
         */
        public static function insert(Insert $request){
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
         * @param Select $select
         * @param string $bundle
         * @param string $type
         * @return object
         */
        public static function selectOne(Select $select, $bundle, $type = 'array'){
            if($type == 'array' || $type == 'object'){
                try{
                    new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest());
                    $ent = 'Bundles\\'.$bundle.'\Entity\\'.$select->getEntity();

                    self::$conn->request($select->getRequest(), $select->getExecute());
                    $res = self::$conn->fetch();

                    return self::hydration($res, $ent);
                }
                catch(\Exception $e){
                    new CreateErrorLog($e->getMessage());
                    die('Il y a eu une erreur.');
                }
            }
        }

        /**
         * @param Select $select
         * @param string $bundle
         * @return array
         */
        public static function selectMany(Select $select, $bundle){
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest());
                $ent = 'Bundles\\'.$bundle.'\Entity\\'.$select->getEntity();

                self::$conn->request($select->getRequest(), $select->getExecute());
                $res = self::$conn->fetchAll();

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
         * @param Delete $request
         */
        public static function delete(Delete $request){
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
         * @param Update $request
         */
        public static function update(Update $request){
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
         * @param Select $request
         * @return int
         */
        public static function count(Select $request){
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