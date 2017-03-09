<?php
namespace Frash\ORM\PGSQL\Request;
use Frash\ORM\RequestInterface;

/**
 * Class Select
 * @package Frash\ORM\PGSQL\Request
 */
class Select implements RequestInterface{
    /**
     * @var string
     */
    private $table = '';

    /**
     * @var string
     */
    private $entity = '';

    /**
     * @var string
     */
    private $colSel = '*';

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
     * @var string
     */
    private $order = '';

    /**
     * @var string
     */
    private $limit = '';

    /**
     * @var string
     */
    private $offset = '';

    /**
     * @var string
     */
    private $groupBy = '';

    /**
     * Select constructor.
     * @param array $array
     */
    public function __construct(array $array){
        $table = $array['table'];
        $this->table = "\"$table\"";
        $this->entity = ucfirst($table);

        if(!empty($array['order'])){
            $this->order = 'ORDER BY '.$array['order'];
        }

        if(!empty($array['limit'])){
            $this->limit = 'LIMIT '.$array['limit'];
        }

        if(!empty($array['offset'])){
            $this->offset = 'OFFSET '.$array['offset'];
        }
    }

    public function setCount(){
        if($this->colSel == '*'){
            $this->colSel = 'COUNT(*) AS number_result';
        } else {
            $this->colSel .= ', COUNT(*) AS number_result';
        }

        return $this;
    }

    /**
     * @param Where $where
     */
    public function setWhere(Where $where){
        $this->where = $where->getWhere();
        $this->arrayWhere = $where->getArrayWhere();

        return $this;
    }

    /**
     * @param string $col
     */
    public function setColSel(string $col){
        $this->colSel = $col;

        return $this;
    }

    /**
     * @param string $exec
     */
    public function setAddExec(string $exec){
        $this->arrayWhere[] = $exec;

        return $this;
    }

    /**
     * @param string $col
     * @param string $having
     */
    public function setGroupBy(string $col, string $having = ''){
        $this->groupBy = 'GROUP BY '.$col;
        $this->groupBy .= ($having == '') ? '' : ' HAVING '.$having;

        return $this;
    }

    /**
     * @param array $exec
     */
    public function setExecute(array $exec = []){
        if(count($exec) == count($this->arrayWhere)){
            $this->execute = array_combine($this->arrayWhere, $exec);
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
        if(!empty($this->table) && !empty($this->colSel)){
            return 'SELECT '.$this->colSel.' FROM '.$this->table.' '.$this->where.' '.$this->groupBy.' '.$this->order.' '.$this->limit.' '.$this->offset;
        }
    }

    /**
     * @return string
     */
    public function getColSel(): string{
        return $this->colSel;
    }

    /**
     * @return string
     */
    public function getTable(): string{
        return $this->table;
    }

    /**
     * @return string
     */
    public function getEntity(): string{
        return $this->entity;
    }
}