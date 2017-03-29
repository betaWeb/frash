<?php
namespace Frash\ORM\Query;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Log\CreateLog;
use Frash\ORM\{ Hydrator, RequestInterface };

/**
 * Class QueryBuilder
 * @package Frash\ORM
 */
class QueryBuilder extends Hydrator{
    /**
     * @var string
     */
    protected $bundle = '';

    /**
     * @var \PDO
     */
    protected $conn;

    /**
     * @var Dic
     */
    protected $dic;

    /**
     * @var string
     */
    protected $system = '';

    /**
     * QueryBuilder constructor.
     * @param Dic $dic
     * @param \PDO $conn
     */
    public function __construct(Dic $dic, \PDO $conn){
        $this->dic = $dic;

        $this->bundle = $this->dic->bundle;
        $this->conn = $conn;
        $this->system = $this->dic->load('orm')->system;
    }

    /**
     * @param RequestInterface $request
     * @return int
     */
    public function insert(RequestInterface $request): int{
        try{
            CreateLog::request($request->getRequest(), $this->dic->conf['config']['log']);

            $req = $this->conn->prepare($request->getRequest());
            $req->execute($request->getExecute());

            if($this->system == 'PGSQL'){
                return $this->conn->lastInsertId(str_replace('"', '', $request->getTable()).'_id_seq');
            } else {
                return $this->conn->lastInsertId();
            }
        } catch(\Exception $e) {
            return $this->dic->load('exception')->publish($e->getMessage());
        }
    }

    /**
     * @param RequestInterface $select
     * @param string $hydrat
     * @return array
     */
    public function select(RequestInterface $select, string $hydrat = 'without'){
        try{
            CreateLog::request($select->getRequest(), $this->dic->conf['config']['log']);

            $request = $this->conn->prepare($select->getRequest());
            $request->execute($select->getExecute());
            $res = $request->fetchAll(\PDO::FETCH_OBJ);

            $entity = 'Bundles\\'.$this->bundle.'\Entity\\'.$select->getEntity();

            if(count($res) == 1){
                if($hydrat == 'without'){
                    return $res[0];
                } elseif($hydrat == 'with') {
                    return $this->hydration($res[0], $entity);
                }
            } else {
                if($hydrat == 'without'){
                    return $res;
                } elseif($hydrat == 'with') {
                    $count = count($res);
                    $array_obj = [];

                    for($i = 0; $i < $count; $i++){
                        $array_obj[ $i ] = $this->hydration($res[ $i ], $entity);
                    }

                    return $array_obj;
                }
            }
        } catch(\Exception $e) {
            return $this->dic->load('exception')->publish($e->getMessage());
        }
    }

    /**
     * @param RequestInterface $request
     */
    public function delete(RequestInterface $request){
        try{
            $req = $this->conn->prepare($request->getRequest());
            $req->execute($request->getExecute());

            CreateLog::request($request->getRequest(), $this->dic->conf['config']['log']);
        } catch(\Exception $e) {
            return $this->dic->load('exception')->publish($e->getMessage());
        }
    }

    /**
     * @param RequestInterface $request
     */
    public function update(RequestInterface $request){
        try{
            $req = $this->conn->prepare($request->getRequest());
            $req->execute($request->getExecute());

            CreateLog::request($request->getRequest(), $this->dic->conf['config']['log']);
        } catch(\Exception $e) {
            return $this->dic->load('exception')->publish($e->getMessage());
        }
    }

    /**
     * @param RequestInterface $request
     * @return array
     */
    public function custom(RequestInterface $request){
        try{
            CreateLog::request($request->getRequest(), $this->dic->conf['config']['log']);

            $req = $this->conn->prepare($request->getRequest());
            $req->execute($request->getExecute());

            return $req->fetch(\PDO::FETCH_ASSOC);
        } catch(\Exception $e) {
            return $this->dic->load('exception')->publish($e->getMessage());
        }
    }
}