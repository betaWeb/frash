<?php
namespace Frash\ORM\Query;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Log\CreateLog;
use Frash\ORM\Hydrator;

/**
 * Class Finder
 * @package Frash\ORM\Query
 */
class Finder extends Hydrator{
    /**
     * @var Dic
     */
    private $dic;

    /**
     * @var string
     */
    private $system;

    /**
     * Finder constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        $this->dic = $dic;
        $this->system = $this->dic->load('orm')->system;
    }

    /**
     * @param string $entity
     * @param string $where
     * @param array $arguments
     * @return array
     */
    private function findBy(string $entity, string $where, array $arguments): array{
        try{
            if(strstr($entity, ':')){
                list($bundle, $table) = explode(':', $entity);
            } else {
                $bundle = $this->dic->bundle;
                $table = $entity;
            }

            if($this->system == 'PGSQL'){
                $request = 'SELECT * FROM '."\"$table\"".' '.$where;
            } else {
                $request = 'SELECT * FROM '.$table.' '.$where;
            }

            $req = $this->dic->pdo->prepare($request);
            $req->execute($arguments);
            $res = $req->fetchAll(\PDO::FETCH_OBJ);

            CreateLog::request($request, $this->dic->config['log']);

            $count = count($res);
            $array_obj = [];

            $ent = 'Bundles\\'.$bundle.'\Entity\\'.ucfirst($table);
            $this->preloadHydration($this->dic);

            for($i = 0; $i < $count; $i++){
                $array_obj[ $i ] = $this->hydration($res[ $i ], $ent);
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
            if(strstr($entity, ':')){
                list($bundle, $table) = explode(':', $entity);
            } else {
                $bundle = $this->dic->bundle;
                $table = $entity;
            }

            if($this->system == 'PGSQL'){
                $request = 'SELECT * FROM '."\"$table\"".' '.$where;
            } else {
                $request = 'SELECT * FROM '.$table.' '.$where;
            }

            $req = $this->dic->pdo->prepare($request);
            $req->execute($arguments);
            $res = $req->fetch(\PDO::FETCH_OBJ);

            CreateLog::request($request, $this->dic->config['log']);
            $this->preloadHydration($this->dic);

            return $this->hydration($res, 'Bundles\\'.$bundle.'\Entity\\'.ucfirst($table));
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
            foreach($expl_method as $meth){
                if($this->system == 'PGSQL'){
                    $lc_method = lcfirst($meth);
                    $array_method[] = "\"$lc_method\"".' = ?';
                } else {
                    $array_method[] = lcfirst($meth).' = ?';
                }
            }

            return $this->findBy($entity, 'WHERE '.implode(' AND ', $array_method), $arg);
        } elseif(substr($method, 0, 9) == 'findOneBy') {
            $expl_method = explode('And', str_replace('findOneBy', '', $method));

            $array_method = [];
            foreach($expl_method as $meth){
                if($this->system == 'PGSQL'){
                    $lc_method = lcfirst($meth);
                    $array_method[] = "\"$lc_method\"".' = ?';
                } else {
                    $array_method[] = lcfirst($meth).' = ?';
                }
            }

            return $this->findOneBy($entity, 'WHERE '.implode(' AND ', $array_method), $arg);
        } elseif($method == 'find') {
            if($this->system == 'PGSQL'){
                return $this->findBy($entity, "WHERE \"id\" = ?", $arg);
            } else {
                return $this->findBy($entity, "WHERE id = ?", $arg);
            }
        } elseif($method == 'findOne') {
            if($this->system == 'PGSQL'){
                return $this->findOneBy($entity, "WHERE \"id\" = ?", $arg);
            } else {
                return $this->findOneBy($entity, "WHERE id = ?", $arg);
            }
        }
    }
}