<?php
namespace LFW\ORM\PGSQL\Request;
use LFW\ORM\RequestInterface;

/**
 * Class Delete
 * @package LFW\ORM\PGSQL\Request
 */
class Delete implements RequestInterface{
    /**
     * @var string
     */
    private $table = '';

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
     * Delete constructor.
     * @param string $table
     */
    public function __construct(string $table){
        $this->table = $table;
    }

    /**
     * @param string $where
     * @param array $arrayWhere
     */
    public function setWhere(string $where, array $arrayWhere){
        $this->where = $where;
        $this->arrayWhere = $arrayWhere;
    }

    /**
     * @param array $exec
     */
    public function setExecute(array $exec = []){
        if(count($exec) == count($this->arrayWhere)){
            $this->execute = $exec;
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
        if(!empty($this->table)){
            $request = 'DELETE FROM '.$this->table;
            if($this->where != ''){ $request .= $this->where; }

            return $request;
        }
    }
}