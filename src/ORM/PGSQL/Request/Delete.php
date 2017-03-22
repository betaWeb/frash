<?php
namespace Frash\ORM\PGSQL\Request;
use Frash\ORM\RequestInterface;
use Frash\ORM\PGSQL\Request\Where;

/**
 * Class Delete
 * @package Frash\ORM\PGSQL\Request
 */
class Delete extends Where implements RequestInterface{
    /**
     * @var string
     */
    private $table = '';

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
     * @param array $exec
     */
    public function execute(array $exec = []){
        if(count($exec) == count($this->arrayWhere)){
            $this->execute = $exec;
        }

        return $this;
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
            $where = ($this->where == 'WHERE ') ? '' : $this->where;
            return 'DELETE FROM '.$this->table.' '.$where;
        }
    }
}