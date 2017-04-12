<?php
namespace Frash\ORM\Query;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Log\CreateLog;

/**
 * Class Counter
 * @package Frash\ORM\Query
 */
class Counter{
    /**
     * @var Dic
     */
    private $dic;

    /**
     * Counter constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        $this->dic = $dic;
    }

    /**
     * @param string $entity
     * @param string $where
     * @param array $arguments
     * @return int
     */
    private function count(string $entity, string $where, array $arguments): int{
        try{
            if($this->dic->load('orm')->system == 'PGSQL'){
                $table = lcfirst($entity);
                $request = 'SELECT COUNT(*) as count FROM '."\"$table\"".' '.$where;
            } else {
                $request = 'SELECT COUNT(*) as count FROM '.lcfirst($entity).' '.$where;
            }
            
            CreateLog::request($request, $this->dic->conf['config']['log']);

            $req = $this->dic->pdo->prepare($request);
            $req->execute($arguments);
            return $req->fetch(\PDO::FETCH_ASSOC)['count'];
        } catch(\Exception $e) {
            return $this->dic->load('exception')->publish($e->getMessage());
        }
    }

    /**
     * @param string $method
     * @param array $arg
     * @return int
     */
    public function __call(string $method, array $arg): int{
        $entity = $arg[0];
        array_shift($arg);

        if(substr($method, 0, 7) == 'countBy'){
            $expl_method = explode('And', str_replace('countBy', '', $method));
            $array_method = [];

            foreach($expl_method as $method){
                $array_method[] = lcfirst($method).' = ?';
            }

            return $this->count($entity, 'WHERE '.implode(' AND ', $array_method), $arg);
        } elseif($method == 'count') {
            return $this->count($entity, "WHERE id = ?", $arg);
        }
    }
}