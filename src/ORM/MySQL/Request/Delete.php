<?php
namespace Frash\ORM\MySQL\Request;
use Frash\ORM\RequestInterface;
use Frash\ORM\MySQL\Request\Where;

/**
 * Class Delete
 * @package Frash\ORM\MySQL\Request
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
     * @param $table
     */
    public function __construct(string $table){
        $this->table = $table;
    }

    /**
     * @param array $exec
     */
    public function execute(array $exec = []){
        if(count($exec) == count($this->arrayWhere)){
            $this->execute = array_combine($this->arrayWhere, $exec);
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
            $where = ($this->where == 'WHERE ') ? '' : $this->where;
            $request = 'DELETE FROM '.$this->table.' '.$where;

            return $request;
        }
    }
}