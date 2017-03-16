<?php
namespace Frash\ORM;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Exception\Exception;

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
     * @param string $bundle
     * @param Dic $dic
     * @return Exception
     */
    public function __construct(string $bundle, Dic $dic){
        if(!empty($dic->get('conf')['database']) && !empty($dic->get('conf')['database'][ $bundle ])){
            try{
                $conf = $dic->get('conf')['database'][ $bundle ];
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
                        return new Exception('Connexion à l\'ORM impossible.', $dic->get('conf')['config']['log']);
                }
            } catch(\Exception $e) {
                return new Exception($e->getMessage(), $dic->get('conf')['config']['log']);
            }
        }
    }

    /**
     * @return \PDO
     */
    public function getConnexion(): \PDO{
        return $this->connexion;
    }

    /**
     * @return string
     */
    public function getSystem(): string{
        return $this->system;
    }
}