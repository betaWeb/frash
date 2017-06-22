<?php
namespace Frash\ORM\PGSQL\Request;
use Frash\ORM\RequestInterface;
use Frash\ORM\PGSQL\Request\Where;

/**
 * Class Join
 * @package Frash\ORM\PGSQL\Request
 */
class Join extends Where implements RequestInterface
{
    /**
     * @var array
     */
    private $colSel = [];

    /**
     * @var array
     */
    private $execute = [];

    /**
     * @var string
     */
    private $groupBy = '';

    /**
     * @var string
     */
    private $join = '';

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
    private $order = '';

    /**
     * @var string
     */
    private $table = '';

    /**
     * Join constructor.
     * @param string $table
     * @param array $array
     */
    public function __construct(string $table, array $array){
        $this->table = "\"$table\"";

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

    /**
     * @return Join
     */
    public function count(): Join
    {
        $this->colSel[] = 'COUNT(*) AS number_result';
        return $this;
    }

    /**
     * @param string $col
     * @param string $alias
     * @return Join
     */
    public function colJoin(string $col, string $alias = ''): Join
    {
    	if($alias == ''){
    		$this->colSel[] = $col;
    	} else {
    		$this->colSel[] = $col.' AS '.$alias;
    	}

    	return $this;
    }

    /**
     * @param string $cols
     * @return Join
     */
    public function cols(string $cols): Join
    {
    	$this->colSel[] = $cols;
        return $this;
    }

    /**
     * @param string $type
     * @param string $table
     * @param string $col_one
     * @param string $col_two
     * @param string $sign
     * @return Join
     */
    public function join(string $type, string $table, string $col_one, string $col_two, string $sign = '='): Join
    {
        $this->join .= $type.' '.$table.' ON '.$col_one.' '.$sign.' '.$col_two.' ';
        return $this;
    }

    /**
     * @param string $exec
     * @return Join
     */
    public function exec(string $exec): Join
    {
        $this->arrayWhere[] = $exec;
        return $this;
    }

    /**
     * @param string $col
     * @param string $having
     * @return Join
     */
    public function groupBy(string $col, string $having = ''): Join
    {
        $this->groupBy = 'GROUP BY '.$col;
        $this->groupBy .= ($having == '') ? '' : ' HAVING '.$having;

        return $this;
    }

    /**
     * @param array $exec
     * @return Join
     */
    public function execute(array $exec = []): Join
    {
        if(count($exec) == count($this->arrayWhere)){
            $this->execute = array_combine($this->arrayWhere, $exec);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getExecute(): array
    {
        return $this->execute;
    }

    /**
     * @return string
     */
    public function getRequest(): string
    {
        if(!empty($this->table) && !empty($this->colSel)){
        	$colSel = (!empty($this->colSel)) ? implode(', ', $this->colSel) : '*';
            $where = ($this->where == 'WHERE ') ? '' : $this->where;

            return 'SELECT '.$colSel.' FROM '.$this->table.' '.$this->join.' '.$where.' '.$this->groupBy.' '.$this->order.' '.$this->limit.' '.$this->offset;
        }
    }

    /**
     * @return string
     */
    public function getColSel(): string
    {
        return $this->colSel;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getEntity(): string
    {
        return ucfirst($this->table);
    }
}