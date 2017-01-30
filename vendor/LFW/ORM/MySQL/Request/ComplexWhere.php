<?php
namespace LFW\ORM\MySQL\Request;

/**
 * Class ComplexWhere
 * @package LFW\ORM\MySQL\Request
 */
class ComplexWhere{
    /**
     * @var string
     */
    private $where = 'WHERE ';

    /**
     * @var array
     */
    private $arrayWhere = [];

    /**
     * @param array $where
     */
    public function setWhere(array $where){
        $this->where .= implode(' ', $where);
    }

    /**
     * @param string $where
     * @param string $sign
     * @param string $exec
     */
    public function normal(string $where, string $sign, string $exec){
        $this->arrayWhere[] = substr($exec, 1);
        return $where.' '.$sign.' '.$exec;
    }

    /**
     * @param string $where
     */
    public function isNull(string $where){
        return $where.' IS NULL';
    }

    /**
     * @param string $where
     */
    public function isNotNull(string $where){
        return $where.' IS NOT NULL';
    }

    /**
     * @return array
     */
    public function getArrayWhere(): array{
        return $this->arrayWhere;
    }

    /**
     * @return string
     */
    public function getWhere(): string{
        return $this->where;
    }
}