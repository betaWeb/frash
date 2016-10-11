<?php
    namespace LFW\ORM\PGSQL;
    use LFW\Framework\CreateLog\CreateErrorLog;
    use LFW\Framework\CreateLog\CreateRequestLog;
    use LFW\ORM\PDO\PDO;

    /**
     * Class Counter
     * @package Composants\ORM\PGSQL
     */
    class Counter{
        /**
         * @var PDO
         */
        private $pdo;

        /**
         * Finder constructor.
         * @param PDO $pdo
         */
        public function __construct(PDO $pdo){
            $this->pdo = $pdo;
        }

        /**
         * @param string $entity
         * @param string $where
         * @param array $arguments
         * @return int
         */
        private function count($entity, $where, $arguments){
            try{
                $table = lcfirst($entity);
                $request = 'SELECT * FROM '."\"$table\"".' '.$where;

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);

                $this->pdo->request($request, $arguments);
                return $this->pdo->rowCount();
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage(), false);
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param string $method
         * @param array $arg
         * @return int
         */
        public function __call($method, $arg){
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

                return $this->count($entity, 'WHERE '.implode(' AND ', $array_method), $arg);
            }
            elseif($method == 'count'){
                return $this->count($entity, "WHERE \"id\" = ?", $arg);
            }
        }
    }