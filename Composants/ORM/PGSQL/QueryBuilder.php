<?php
    namespace Composants\ORM\PGSQL;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Framework\CreateLog\CreateRequestLog;
    use Composants\ORM\Hydrator;
    use Composants\ORM\PGSQL\Request\Delete;
    use Composants\ORM\PGSQL\Request\Insert;
    use Composants\ORM\PGSQL\Request\Select;
    use Composants\ORM\PGSQL\Request\Update;

    /**
     * Class QueryBuilder
     * @package Composants\ORM\PGSQL
     */
    class QueryBuilder extends Hydrator{
        /**
         * @var \PDO
         */
        protected static $conn;

        /**
         * QueryBuilder constructor.
         * @param \PDO $conn
         */
        public function __construct(\PDO $conn){
            self::$conn = $conn;
        }

        /**
         * @param Insert $request
         * @param bool $ajax
         * @return int
         */
        public static function insert(Insert $request, $ajax = false){
            try{
                $req = self::$conn->prepare($request->getRequest());
                $req->execute($request->getExecute());

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest(), $ajax);

                return self::$conn->lastInsertId(str_replace('"', '', $request->getTable()).'_id_seq');
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage(), $ajax);
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param Select $select
         * @param string $bundle
         * @param bool $ajax
         * @return array
         */
        public static function selectOne(Select $select, $bundle, $ajax = false){
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest(), $ajax);
                $ent = 'Bundles\\'.$bundle.'\Entity\\'.$select->getEntity();

                $req = self::$conn->prepare($select->getRequest());
                $req->execute($select->getExecute());

                if($select->getColSel() == '*'){
                    $res = $req->fetch(\PDO::FETCH_OBJ);
                    return self::hydration($res, $ent);
                }
                else{
                    $req->setFetchMode(\PDO::FETCH_CLASS, $ent);
                    return $req->fetch();
                }
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage(), $ajax);
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param Select $select
         * @param string $bundle
         * @param bool $ajax
         * @return array
         */
        public static function selectMany(Select $select, $bundle, $ajax = false){
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest(), $ajax);
                $ent = 'Bundles\\'.$bundle.'\Entity\\'.$select->getEntity();

                $req = self::$conn->prepare($select->getRequest());
                $req->execute($select->getExecute());

                if($select->getColSel() == '*'){
                    $res = $req->fetchAll(\PDO::FETCH_OBJ);

                    $count = count($res) - 1;
                    $array_obj = [];

                    for($i = 0; $i <= $count; $i++){
                        $array_obj[ $i ] = self::hydration($res[ $i ], $ent);
                    }

                    return $array_obj;
                }
                else{
                    $res = $req->fetchAll(\PDO::FETCH_CLASS, $ent);

                    $array = [];
                    foreach($res as $v){
                        $array[] = $v;
                    }

                    return $array;
                }
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage(), $ajax);
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param Delete $request
         * @param bool $ajax
         */
        public static function delete(Delete $request, $ajax = false){
            try{
                $req = self::$conn->prepare($request->getRequest());
                $req->execute($request->getExecute());

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest(), $ajax);
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage(), $ajax);
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param Update $request
         * @param bool $ajax
         */
        public static function update(Update $request, $ajax = false){
            try{
                $req = self::$conn->prepare($request->getRequest());
                $req->execute($request->getExecute());

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest(), $ajax);
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage(), $ajax);
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param Select $request
         * @param bool $ajax
         * @return int
         */
        public static function count(Select $request, $ajax = false){
            try{
                $req = self::$conn->prepare($request->getRequest());
                $req->execute($request->getExecute());

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest(), $ajax);

                return $req->rowCount();
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage(), $ajax);
                die('Il y a eu une erreur.');
            }
        }
    }