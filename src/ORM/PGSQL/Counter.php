<?php
namespace Frash\ORM\PGSQL;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Log\CreateLog;

/**
 * Class Counter
 * @package Frash\ORM\PGSQL
 */
class Counter{
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
     * @return int
     */
    private function count(string $entity, string $where, array $arguments): int{
        try{
            $table = lcfirst($entity);
            $request = 'SELECT * FROM '."\"$table\"".' '.$where;

            CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$request, $this->dic->get('conf')['config']['log']);

            $req = $this->pdo->prepare($request);
            $req->execute($arguments);

            return $req->rowCount();
        }
        catch(\Exception $e){
            CreateLog::error($e->getMessage());
            die('Il y a eu une erreur.');
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
            $method = str_replace('countBy', '', $method);
            $expl_method = explode('And', $method);

            $array_method = [];
            foreach($expl_method as $method){
                $lc_method = lcfirst($method);
                $array_method[] = "\"$lc_method\"".' = ?';
            }

            return $this->count($entity, 'WHERE '.implode(' AND ', $array_method), $arg);
        } elseif($method == 'count') {
            return $this->count($entity, "WHERE \"id\" = ?", $arg);
        }
    }
}