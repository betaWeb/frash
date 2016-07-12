<?php
    namespace Composants\Framework\ORM\PGSQL;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Framework\CreateLog\CreateRequestLog;

    /**
     * Class Custom
     * @package Composants\Framework\ORM\PGSQL
     */
    class Custom{
        /**
         * @var object
         */
        private static $pdo;

        /**
         * Custom constructor.
         * @param object $pdo
         */
        public function __construct($pdo){
            self::$pdo = $pdo;
        }

        /**
         * @param string $entity
         * @param string $bundle
         * @param string $request
         * @param array $execute
         * @param string $obj
         * @return object
         */
        public static function selectOne($entity, $bundle, $request, $execute = [], $obj = '\PDO::FETCH_OBJ'){
            try{
                if($obj == '\PDO::FETCH_OBJ'){
                    $req = self::$pdo->prepare($request);
                    $req->execute($execute);
                    $res = $req->fetch(\PDO::FETCH_OBJ);

                    new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);

                    return Hydrator::hydration($res, $bundle.'Bundle', $entity);
                }
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param string $entity
         * @param string $bundle
         * @param string $request
         * @param array $execute
         * @param string $obj
         * @return array
         */
        public static function selectMany($entity, $bundle, $request, $execute = [], $obj = '\PDO::FETCH_OBJ'){
            try{
                if($obj == '\PDO::FETCH_OBJ'){
                    $req = self::$pdo->prepare($request);
                    $req->execute($execute);
                    $res = $req->fetchAll(\PDO::FETCH_OBJ);

                    new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);

                    $count = count($res) - 1;
                    $array_obj = [];

                    for($i = 0; $i <= $count; $i++){
                        $array_obj[ $i ] = Hydrator::hydration($res[ $i ], $bundle.'Bundle', $entity);
                    }

                    return $array_obj;
                }
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param string $request
         * @param array $execute
         * @param string $return
         * @return int
         */
        public static function insert($request, $execute = [], $return = ''){
            try{
                $req = self::$pdo->prepare($request);
                $req->execute($execute);

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);

                return (!empty($lastid)) ? self::$pdo->lastInsertId($return) : '';
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param string $request
         * @param array $execute
         */
        public static function update($request, $execute = []){
            try{
                $req = self::$pdo->prepare($request);
                $req->execute($execute);

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param string $request
         * @param array $execute
         */
        public static function delete($request, $execute = []){
            try{
                $req = self::$pdo->prepare($request);
                $req->execute($execute);

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }
    }