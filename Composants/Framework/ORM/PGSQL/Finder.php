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
        private $pdo;

        /**
         * @var object
         */
        private $hydrator;

        /**
         * Finder constructor.
         * @param \PDO $pdo
         */
        public function __construct(\PDO $pdo){
            $this->pdo = $pdo;
            $this->hydrator = new Hydrator;
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

                $req = $this->pdo->prepare($request);
                $req->execute($arguments);
                $res = $req->fetchAll(\PDO::FETCH_OBJ);

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);

                $count = count($res) - 1;
                $array_obj = [];

                for($i = 0; $i <= $count; $i++){
                    $array_obj[ $i ] = $this->hydrator->hydration($res[ $i ], $bundle.'Bundle', $entity);
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

                $req = $this->pdo->prepare($request);
                $req->execute($arguments);
                $res = $req->fetch(\PDO::FETCH_OBJ);

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);

                return $this->hydrator->hydration($res, $bundle.'Bundle', $entity);
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
        public function __call($method, $arg){
            if(substr($method, 0, 6) == 'findBy'){
                list($bundle, $entity) = explode(':', $arg['0']);

                array_shift($arg);

                $method = str_replace('findBy', '', $method);
                $expl_method = explode('And', $method);

                $array_method = [];
                foreach($expl_method as $method){
                    $lc_method = lcfirst($method);
                    $array_method[] = "\"$lc_method\"".' = ?';
                }

                return $this->findBy($bundle, $entity, 'WHERE '.implode(' AND ', $array_method), $arg);
            }
            elseif(substr($method, 0, 9) == 'findOneBy'){
                list($bundle, $entity) = explode(':', $arg['0']);

                array_shift($arg);

                $method = str_replace('findOneBy', '', $method);
                $expl_method = explode('And', $method);

                $array_method = [];
                foreach($expl_method as $method){
                    $lc_method = lcfirst($method);
                    $array_method[] = "\"$lc_method\"".' = ?';
                }

                return $this->findOneBy($bundle, $entity, 'WHERE '.implode(' AND ', $array_method), $arg);
            }
        }
    }