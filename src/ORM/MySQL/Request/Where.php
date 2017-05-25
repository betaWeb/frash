<?php
namespace Frash\ORM\MySQL\Request;

/**
 * Class Where
 * @package Frash\ORM\MySQL\Request
 */
class Where{
    /**
     * @var string
     */
    protected $where = 'WHERE ';

    /**
     * @var array
     */
    protected $arrayWhere = [];

    /**
     * @param string $where
     * @return string
     */
    private function defineFunc(string $where): string{
        return (substr($where, 0, 2) == 'f ') ? substr($where, 2) : $where;
    }

    /**
     * @param string $where
     * @param array $attributes
     */
    public function simple(string $where, array $attributes){
        $this->where = ' '.$where;

        foreach($attributes as $name){
            $this->arrayWhere[] = $name;
        }

        return $this;
    }

    /**
     * @param string $where
     * @param string $sign
     * @param string $exec
     */
    public function where(string $where, string $sign = '', string $exec = ''){
        if($exec == '' && strlen($sign) > 1){
            $this->where .= ' '.$this->defineFunc($where).' = '.$sign;
            $this->arrayWhere[] = substr($sign, 1);
        } elseif($exec != ''){
            $this->where .= ' '.$this->defineFunc($where).' '.$sign.' '.$exec;
            $this->arrayWhere[] = substr($exec, 1);
        }

        return $this;
    }

    /**
     * @param string $where
     * @param string $sign
     * @param string $exec
     */
    public function andWhere(string $where, string $sign = '', string $exec = ''){
        if($exec == '' && strlen($sign) > 1){
            $this->where .= ' AND '.$this->defineFunc($where).' = '.$sign;
            $this->arrayWhere[] = substr($sign, 1);
        } elseif($exec != ''){
            $this->where .= ' AND '.$this->defineFunc($where).' '.$sign.' '.$exec;
            $this->arrayWhere[] = substr($exec, 1);
        }

        return $this;
    }

    /**
     * @param string $where
     * @param string $sign
     * @param string $exec
     */
    public function orWhere(string $where, string $sign = '', string $exec = ''){
        if($exec == '' && strlen($sign) > 1){
            $this->where .= ' OR '.$this->defineFunc($where).' = '.$sign;
            $this->arrayWhere[] = substr($sign, 1);
        } elseif($exec != ''){
            $this->where .= ' OR '.$this->defineFunc($where).' '.$sign.' '.$exec;
            $this->arrayWhere[] = substr($exec, 1);
        }

        return $this;
    }

    /**
     * @param $where
     */
    public function isNullWhere(string $where){
        $this->where .= $where.' IS NULL';
        return $this;
    }

    /**
     * @param $where
     */
    public function isNotNullWhere(string $where){
        $this->where .= $where.' IS NOT NULL';
        return $this;
    }

    /**
     * @param string $where
     * @param string $exec
     */
    public function inWhere(string $where, string $exec){
        $this->where .= $where.' IN ('.$exec.')';
        $this->arrayWhere[] = substr($exec, 1);

        return $this;
    }
}