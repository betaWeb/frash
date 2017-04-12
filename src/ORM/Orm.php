<?php
namespace Frash\ORM;
use Frash\Framework\DIC\Dic;

/**
 * Class Orm
 * @package Frash\ORM
 */
class Orm{
    /**
     * @var \PDO
     */
    private $connexion;

    /**
     * @var string
     */
    private $system;

    /**
     * Orm constructor.
     * @param Dic $dic
     * @return Exception
     */
    public function __construct(Dic $dic){
        if(!empty($dic->conf['database']) && !empty($dic->conf['database'][ $dic->bundle ])){
            try{
                $conf = $dic->conf['database'][ $dic->bundle ];
                $this->system = $conf['system'];

                switch($conf['system']){
                    case 'MySQL':
                        $this->connexion = new \PDO('mysql:host='.$conf['host'].';dbname='. $conf['dbname'].';charset=UTF8;', $conf['username'], $conf['password'], []);
                        break;
                    case 'PGSQL':
                        $this->connexion = new \PDO('pgsql:dbname='.$conf['dbname'].';port='.$conf['port'].';host='.$conf['host'], $conf['username'], $conf['password']);
                        $this->connexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                        break;
                    default:
                        return $dic->load('exception')->publish('Connexion à l\'ORM impossible.');
                }
            } catch(\Exception $e) {
                return $dic->load('exception')->publish($e->getMessage());
            }
        }
    }

    /**
     * @param string $prop
     * @return mixed
     */
    public function __get(string $prop){
        return $this->$prop;
    }
}