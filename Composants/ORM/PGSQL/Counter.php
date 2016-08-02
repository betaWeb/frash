<?php
    namespace Composants\ORM\PGSQL;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Framework\CreateLog\CreateRequestLog;

    /**
     * Class Counter
     * @package Composants\ORM\PGSQL
     */
    class Counter{
        /**
         * @var \PDO
         */
        private static $pdo;

        /**
         * Finder constructor.
         * @param \PDO $pdo
         */
        public function __construct(\PDO $pdo){
            self::$pdo = $pdo;
        }

        /**
         * @param string $entity
         * @param string $where
         * @param array $arguments
         * @return int
         */
        private static function count($entity, $where, $arguments){
            try{
                $table = lcfirst($entity);
                $request = 'SELECT * FROM '."\"$table\"".' '.$where;

                $req = self::$pdo->prepare($request);
                $req->execute($arguments);

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);

                return $req->rowCount();
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage());
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param string $method
         * @param array $arg
         * @return int
         */
        public static function __callStatic($method, $arg){
            $entity = $arg[0];
            array_shift($arg);

            if(substr($method, 0, 7) == 'countBy'){
                $method = str_replace('countBy', '', $method);
                $expl_method = explode('And', $method);

                $array_method = [];
                foreach($expl_method as $method){
                    $lc_method = lcfirst($method);
                    $array_method[] = "\"$lc_method\"".' = ?';
                }

                return self::count($entity, 'WHERE '.implode(' AND ', $array_method), $arg);
            }
            elseif($method == 'count'){
                return self::count($entity, "WHERE \"id\" = ?", $arg);
            }
        }
    }