<?php
namespace LFW\ORM\MySQL\Request;
use LFW\ORM\RequestInterface;

/**
 * Class Update
 * @package LFW\ORM\MySQL\Request
 */
class Update implements RequestInterface{
    /**
     * @var string
     */
    private $table = '';

    /**
     * @var string
     */
    private $update = '';

    /**
     * @var array
     */
    private $updateExecute = [];

    /**
     * @var string
     */
    private $where = '';

    /**
     * @var array
     */
    private $arrayWhere = [];

    /**
     * @var array
     */
    private $execute = [];

    /**
     * Update constructor.
     * @param string $table
     */
    public function __construct(string $table){
        $this->table = $table;
    }

    /**
     * @param string $exec
     */
    public function setAddExec(string $exec){
        $this->updateExecute[] = $exec;
    }

    /**
     * @param Where $where
     */
    public function setWhere(Where $where){
        $this->where = $where->getWhere();
        $this->arrayWhere = $where->getArrayWhere();
    }

    /**
     * @param array $update
     */
    public function setUpdate(array $update = []){
        $upd = [];

        foreach($update as $k => $v){
            $comp = substr($k, -2);
            $col = substr($k, 0, -2);

            switch($comp){
                case ' +':
                    $upd[] = $col.' = '.$col.' + '.$v;
                    $this->updateExecute[] = substr($v, 1);
                    break;
                case ' -':
                    $upd[] = $col.' = '.$col.' - '.$v;
                    $this->updateExecute[] = substr($v, 1);
                    break;
                case ' /':
                    $upd[] = $col.' = '.$v;
                    break;
                default:
                    $upd[] = $k.' = '.$v;
                    $this->updateExecute[] = substr($v, 1);
            }
        }

        $this->update = implode(', ', $upd);
    }

    /**
     * @param array $exec
     */
    public function setExecute(array $exec){
        $arrayUpd = [];

        foreach($this->updateExecute as $v){
            $arrayUpd[] = $v;
        }

        $result = array_merge($arrayUpd, $this->arrayWhere);

        if(count($exec) == count($result)){
            $this->execute = array_combine($result, $exec);
        }
    }

    /**
     * @return array
     */
    public function getExecute(): array{
        return $this->execute;
    }

    /**
     * @return string
     */
    public function getRequest(): string{
        if(!empty($this->table) && !empty($this->update)){
            $request = 'UPDATE '.$this->table.' SET '.$this->update.' ';
            if($this->where != ''){ $request .= $this->where; }
            return $request;
        }
    }
}