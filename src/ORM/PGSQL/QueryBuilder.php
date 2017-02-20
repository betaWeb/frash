<?php
namespace Frash\ORM\PGSQL;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Log\CreateLog;
use Frash\ORM\{ Hydrator, RequestInterface };

/**
 * Class QueryBuilder
 * @package Frash\ORM\PGSQL
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
     * QueryBuilder constructor.
     * @param Dic $dic
     * @param \PDO $conn
     */
    public function __construct(Dic $dic, \PDO $conn){
        $this->dic = $dic;

        $this->bundle = $this->dic->get('bundle');
        $this->conn = $conn;
    }

    /**
     * @param RequestInterface $request
     * @return int
     */
    public function insert(RequestInterface $request): int{
        try{
            CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest(), $this->dic->get('conf')['config']['log']);

            $req = $this->conn->prepare($request->getRequest());
            $req->execute($request->getExecute());

            return $this->conn->lastInsertId(str_replace('"', '', $request->getTable()).'_id_seq');
        }
        catch(\Exception $e){
            CreateLog::error($e->getMessage(), $this->dic->get('conf')['config']['log']);
            die('Il y a eu une erreur.');
        }
    }

    /**
     * @param RequestInterface $select
     * @param string $hydrat
     * @return object
     */
    public function selectOne(RequestInterface $select, string $hydrat = 'without'){
        try{
            CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest(), $this->dic->get('conf')['config']['log']);

            $request = $this->conn->prepare($select->getRequest());
            $request->execute($select->getExecute());
            $res = $request->fetch(\PDO::FETCH_OBJ);

            if($hydrat == 'without'){
                return $res;
            }
            elseif($hydrat == 'with'){
                return $this->hydration($res, 'Bundles\\'.$this->bundle.'\Entity\\'.$select->getEntity());
            }
        }
        catch(\Exception $e){
            CreateLog::error($e->getMessage(), $this->dic->get('conf')['config']['log']);
            die('Il y a eu une erreur.');
        }
    }

    /**
     * @param RequestInterface $select
     * @param string $hydrat
     * @return array
     */
    public function selectMany(RequestInterface $select, string $hydrat = 'without'){
        try{
            CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$select->getRequest(), $this->dic->get('conf')['config']['log']);

            $request = $this->conn->prepare($select->getRequest());
            $request->execute($select->getExecute());
            $res = $request->fetchAll(\PDO::FETCH_OBJ);

            if($hydrat == 'without'){
                return $res;
            }
            elseif($hydrat == 'with'){
                $count = count($res) - 1;
                $array_obj = [];
                $class = 'Bundles\\'.$this->bundle.'\Entity\\'.$select->getEntity();

                for($i = 0; $i <= $count; $i++){
                    $array_obj[ $i ] = $this->hydration($res[ $i ], $class);
                }

                return $array_obj;
            }
        }
        catch(\Exception $e){
            CreateLog::error($e->getMessage(), $this->dic->get('conf')['config']['log']);
            die('Il y a eu une erreur.');
        }
    }

    /**
     * @param RequestInterface $request
     */
    public function delete(RequestInterface $request){
        try{
            $req = $this->conn->prepare($request->getRequest());
            $req->execute($request->getExecute());

            CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest(), $this->dic->get('conf')['config']['log']);
        }
        catch(\Exception $e){
            CreateLog::error($e->getMessage(), $this->dic->get('conf')['config']['log']);
            die('Il y a eu une erreur.');
        }
    }

    /**
     * @param RequestInterface $request
     */
    public function update(RequestInterface $request){
        try{
            $req = $this->conn->prepare($request->getRequest());
            $req->execute($request->getExecute());

            CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest(), $this->dic->get('conf')['config']['log']);
        }
        catch(\Exception $e){
            CreateLog::error($e->getMessage(), $this->dic->get('conf')['config']['log']);
            die('Il y a eu une erreur.');
        }
    }

    /**
     * @param RequestInterface $request
     * @return array
     */
    public function custom(RequestInterface $request){
        try{
            CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest(), $this->dic->get('conf')['config']['log']);

            $req = $this->conn->prepare($request->getRequest());
            $req->execute($request->getExecute());

            return $req->fetch(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e){
            CreateLog::error($e->getMessage(), $this->dic->get('conf')['config']['log']);
            die('Il y a eu une erreur.');
        }
    }

    /**
     * @param RequestInterface $request
     * @return array
     */
    public function customMany(RequestInterface $request){
        try{
            CreateLog::request(date('d/m/Y à H:i:s').' - Requête : '.$request->getRequest(), $this->dic->get('conf')['config']['log']);

            $req = $this->conn->prepare($request->getRequest());
            $req->execute($request->getExecute());

            return $req->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e){
            CreateLog::error($e->getMessage(), $this->dic->get('conf')['config']['log']);
            die('Il y a eu une erreur.');
        }
    }
}