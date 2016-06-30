<?php
    namespace Composants\Framework\ORM\PGSQL;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Framework\CreateLog\CreateRequestLog;

    /**
     * Class Finder
     * @package Composants\Framework\ORM\PGSQL
     */
    class Finder{
        /**
         * @var \PDO
         */
        private static $pdo;

        /**
         * @var object
         */
        private static $hydrator;

        /**
         * Finder constructor.
         * @param \PDO $pdo
         */
        public function __construct(\PDO $pdo){
            self::$pdo = $pdo;
            self::$hydrator = new Hydrator;
        }

        /**
         * @param string $bundle
         * @param string $entity
         * @param string $where
         * @param array $arguments
         * @return array
         */
        private function findBy($bundle, $entity, $where, $arguments){
            try{
                $table = lcfirst($entity);
                $request = 'SELECT * FROM '."\"$table\"".' '.$where;

                $req = self::$pdo->prepare($request);
                $req->execute($arguments);
                $res = $req->fetchAll(\PDO::FETCH_OBJ);

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);

                $count = count($res) - 1;
                $array_obj = [];

                for($i = 0; $i <= $count; $i++){
                    $array_obj[ $i ] = self::$hydrator->hydration($res[ $i ], $bundle.'Bundle', $entity);
                }

                return $array_obj;
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param string $bundle
         * @param string $entity
         * @param string $where
         * @param array $arguments
         * @return object
         */
        private function findOneBy($bundle, $entity, $where, $arguments){
            try{
                $table = lcfirst($entity);
                $request = 'SELECT * FROM '."\"$table\"".' '.$where;

                $req = self::$pdo->prepare($request);
                $req->execute($arguments);
                $res = $req->fetch(\PDO::FETCH_OBJ);

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);

                return self::$hydrator->hydration($res, $bundle.'Bundle', $entity);
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param string $method
         * @param array $arg
         * @return array|object
         */
        public static function __callStatic($method, $arg){
            list($bundle, $entity) = explode(':', $arg['0']);
            array_shift($arg);

            if(substr($method, 0, 6) == 'findBy'){
                $method = str_replace('findBy', '', $method);
                $expl_method = explode('And', $method);

                $array_method = [];
                foreach($expl_method as $method){
                    $lc_method = lcfirst($method);
                    $array_method[] = "\"$lc_method\"".' = ?';
                }

                return self::findBy($bundle, $entity, 'WHERE '.implode(' AND ', $array_method), $arg);
            }
            elseif(substr($method, 0, 9) == 'findOneBy'){
                $method = str_replace('findOneBy', '', $method);
                $expl_method = explode('And', $method);

                $array_method = [];
                foreach($expl_method as $method){
                    $lc_method = lcfirst($method);
                    $array_method[] = "\"$lc_method\"".' = ?';
                }

                return self::findOneBy($bundle, $entity, 'WHERE '.implode(' AND ', $array_method), $arg);
            }
        }
    }