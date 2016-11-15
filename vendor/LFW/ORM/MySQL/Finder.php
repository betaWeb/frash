<?php
    namespace LFW\ORM\MySQL;
    use LFW\Framework\CreateLog\CreateErrorLog;
    use LFW\Framework\CreateLog\CreateRequestLog;
    use LFW\ORM\Hydrator;
    use LFW\ORM\PDO\PDO;

    /**
     * Class Finder
     * @package Composants\ORM\MySQL
     */
    class Finder{
        /**
         * @var string
         */
        private $bundle;

        /**
         * @var PDO
         */
        private $pdo;

        /**
         * Finder constructor.
         * @param PDO $pdo
         * @param string $bundle
         */
        public function __construct(PDO $pdo, $bundle){
            $this->bundle = $bundle;
            $this->pdo = $pdo;
        }

        /**
         * @param string $entity
         * @param string $where
         * @param array $arguments
         * @return array
         */
        private function findBy($entity, $where, $arguments){
            try{
                $request = 'SELECT * FROM '.lcfirst($entity).' '.$where;

                $this->pdo->request($request, $arguments);
                $res = $this->pdo->fetchAllObj();

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);

                $count = count($res) - 1;
                $array_obj = [];

                for($i = 0; $i <= $count; $i++){
                    $array_obj[ $i ] = Hydrator::hydration($res[ $i ], 'Bundles\\'.$this->bundle.'\Entity\\'.$entity);
                }

                return $array_obj;
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage(), false);
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param string $entity
         * @param string $where
         * @param array $arguments
         * @return object
         */
        private function findOneBy($entity, $where, $arguments){
            try{
                $request = 'SELECT * FROM '.lcfirst($entity).' '.$where;

                $this->pdo->request($request, $arguments);
                $res = $this->pdo->fetchObj();

                new CreateRequestLog(date('d/m/Y à H:i:s').' - Requête : '.$request);

                return Hydrator::hydration($res, 'Bundles\\'.$this->bundle.'\Entity\\'.$entity);
            }
            catch(\Exception $e){
                new CreateErrorLog($e->getMessage(), false);
                die('Il y a eu une erreur.');
            }
        }

        /**
         * @param string $method
         * @param array $arg
         * @return array|object
         */
        public function __call($method, $arg){
            $entity = $arg[0];
            array_shift($arg);

            if(substr($method, 0, 6) == 'findBy'){
                $expl_method = explode('And', str_replace('findBy', '', $method));

                $array_method = [];
                foreach($expl_method as $meth){
                    $array_method[] = lcfirst($meth).' = ?';
                }

                return $this->findBy($entity, 'WHERE '.implode(' AND ', $array_method), $arg);
            }
            elseif(substr($method, 0, 9) == 'findOneBy'){
                $method = str_replace('findOneBy', '', $method);
                $expl_method = explode('And', $method);

                $array_method = [];
                foreach($expl_method as $method){
                    $array_method[] = lcfirst($method).' = ?';
                }

                return $this->findOneBy($entity, 'WHERE '.implode(' AND ', $array_method), $arg);
            }
            elseif($method == 'find'){
                return $this->findBy($entity, "WHERE id = ?", $arg);
            }
            elseif($method == 'findOne'){
                return $this->findOneBy($entity, "WHERE id = ?", $arg);
            }
        }
    }