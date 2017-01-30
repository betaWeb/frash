<?php
namespace LFW\ORM\MySQL\Request;

/**
 * Class Where
 * @package LFW\ORM\MySQL\Request
 */
class Where{
    /**
     * @var string
     */
    private $where = 'WHERE ';

    /**
     * @var array
     */
    private $arrayWhere = [];

    /**
     * @param string $where
     * @param string $sign
     * @param string $exec
     * @param string $prefix
     * @param string $suffix
     */
    public function where(string $where, string $sign, string $exec, string $prefix = '', string $suffix = ''){
        $this->where .= ' '.$prefix.$where.' '.$sign.' '.$exec.' '.$suffix;
        $this->arrayWhere[] = substr($exec, 1);
    }

    /**
     * @param string $where
     * @param string $sign
     * @param string $exec
     */
    public function andWhere(string $where, string $sign, string $exec){
        $this->where .= ' AND '.$where.' '.$sign.' '.$exec;
        $this->arrayWhere[] = substr($exec, 1);
    }

    /**
     * @param string $where
     * @param string $sign
     * @param string $exec
     */
    public function orWhere(string $where, string $sign, string $exec){
        $this->where .= ' OR '.$where.' '.$sign.' '.$exec;
        $this->arrayWhere[] = substr($exec, 1);
    }

    /**
     * @param $where
     */
    public function isNullWhere(string $where){
        $this->where .= $where.' IS NULL';
    }

    /**
     * @param $where
     */
    public function isNotNullWhere(string $where){
        $this->where .= $where.' IS NOT NULL';
    }

    /**
     * @param string $where
     * @param string $exec
     */
    public function inWhere(string $where, string $exec){
        $this->where .= $where.' IN ('.$exec.')';
        $this->arrayWhere[] = substr($exec, 1);
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