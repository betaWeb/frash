<?php
namespace Frash\ORM\PGSQL;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Log\CreateLog;
use Frash\ORM\Hydrator;

/**
 * Class Finder
 * @package Frash\ORM\PGSQL
 */
class Finder extends Hydrator{
    /**
     * @var Dic
     */
    private $dic;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * Finder constructor.
     * @param Dic $dic
     * @param \PDO $pdo
     */
    public function __construct(Dic $dic, \PDO $pdo){
        $this->dic = $dic;
        $this->pdo = $pdo;
    }

    /**
     * @param string $entity
     * @param string $where
     * @param array $arguments
     * @return array
     */
    private function findBy(string $entity, string $where, array $arguments): array{
        try{
            $table = lcfirst($entity);
            $request = 'SELECT * FROM '."\"$table\"".' '.$where;

            CreateLog::request($request, $this->dic->conf['config']['log']);

            $req = $this->pdo->prepare($request);
            $req->execute($arguments);
            $res = $req->fetchAll(\PDO::FETCH_OBJ);

            $count = count($res);
            $array_obj = [];
            $ent = ucfirst($entity);

            for($i = 0; $i < $count; $i++){
                $array_obj[ $i ] = $this->hydration($res[ $i ], 'Bundles\\'.$this->dic->bundle.'\Entity\\'.$ent);
            }

            return $array_obj;
        } catch(\Exception $e) {
            return $this->dic->load('exception')->publish($e->getMessage());
        }
    }

    /**
     * @param string $entity
     * @param string $where
     * @param array $arguments
     * @return object
     */
    private function findOneBy(string $entity, string $where, array $arguments){
        try{
            $table = lcfirst($entity);
            $request = 'SELECT * FROM '."\"$table\"".' '.$where;

            CreateLog::request($request, $this->dic->conf['config']['log']);

            $req = $this->pdo->prepare($request);
            $req->execute($arguments);
            $res = $req->fetch(\PDO::FETCH_OBJ);

            return $this->hydration($res, 'Bundles\\'.$this->dic->bundle.'\Entity\\'.ucfirst($entity));
        } catch(\Exception $e) {
            return $this->dic->load('exception')->publish($e->getMessage());
        }
    }

    /**
     * @param string $method
     * @param array $arg
     * @return array|object
     */
    public function __call(string $method, array $arg){
        $entity = $arg[0];
        array_shift($arg);

        if(substr($method, 0, 6) == 'findBy'){
            $expl_method = explode('And', str_replace('findBy', '', $method));

            $array_method = [];
            foreach($expl_method as $method){
                $lc_method = lcfirst($method);
                $array_method[] = "\"$lc_method\"".' = ?';
            }

            return $this->findBy($entity, 'WHERE '.implode(' AND ', $array_method), $arg);
        } elseif(substr($method, 0, 9) == 'findOneBy') {
            $expl_method = explode('And', str_replace('findOneBy', '', $method));

            $array_method = [];
            foreach($expl_method as $method){
                $lc_method = lcfirst($method);
                $array_method[] = "\"$lc_method\"".' = ?';
            }

            return $this->findOneBy($entity, 'WHERE '.implode(' AND ', $array_method), $arg);
        } elseif($method == 'find') {
            return $this->findBy($entity, "WHERE \"id\" = ?", $arg);
        } elseif($method == 'findOne') {
            return $this->findOneBy($entity, "WHERE \"id\" = ?", $arg);
        }
    }
}