<?php
    namespace Composants\ORM\MySQL;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Framework\CreateLog\CreateRequestLog;
    use Composants\ORM\Hydrator;
    use Composants\ORM\MySQL\Request\Delete;
    use Composants\ORM\MySQL\Request\Insert;
    use Composants\ORM\MySQL\Request\Select;
    use Composants\ORM\MySQL\Request\Update;

    /**
     * Class QueryBuilder
     * @package Composants\ORM\MySQL
     */
    class QueryBuilder{
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
         * @return int
         */
        public static function insert(Insert $request){
            try{
                $req = self::$conn->prepare($request->getRequest());
                $req->execute($request->getExecute());

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest());

                return self::$conn->lastInsertId();
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
        public static function selectOne(Select $select, $entity, $bundle){
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest());
                $ent = 'Bundles\\'.$bundle.'\Entity\\'.$entity;

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
        public static function selectMany(Select $select, $entity, $bundle){
            try{
                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest());
                $ent = 'Bundles\\'.$bundle.'\Entity\\'.$entity;

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
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param Delete $request
         */
        public static function delete(Delete $request){
            try{
                $req = self::$conn->prepare($request->getRequest());
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
        public static function update(Update $request){
            try{
                $req = self::$conn->prepare($request->getRequest());
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
        public static function count(Select $request){
            try{
                $req = self::$conn->prepare($request->getRequest());
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