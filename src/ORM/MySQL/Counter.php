<?php
namespace LFW\ORM\MySQL;
use LFW\Framework\Log\CreateLog;
use LFW\ORM\PDO;

/**
 * Class Counter
 * @package Composants\ORM\MySQL
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
    private function count(string $entity, string $where, array $arguments): int{
        try{
            $request = 'SELECT * FROM '.lcfirst($entity).' '.$where;
            CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$request);

            $this->pdo->request($request, $arguments);
            return $this->pdo->rowCount();
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
                $array_method[] = lcfirst($method).' = ?';
            }

            return $this->count($entity, 'WHERE '.implode(' AND ', $array_method), $arg);
        } elseif($method == 'count') {
            return $this->count($entity, "WHERE id = ?", $arg);
        }
    }
}