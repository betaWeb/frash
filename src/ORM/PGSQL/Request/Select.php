<?php
namespace Frash\ORM\PGSQL\Request;
use Frash\ORM\RequestInterface;
use Frash\ORM\PGSQL\Request\Where;

/**
 * Class Select
 * @package Frash\ORM\PGSQL\Request
 */
class Select extends Where implements RequestInterface
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
     * Select constructor.
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
     * @return Select
     */
    public function count(): Select
    {
        $this->colSel[] = 'COUNT(*) AS number_result';
        return $this;
    }

    /**
     * @param string $cols
     * @return Select
     */
    public function cols(string $cols): Select
    {
        $this->colSel[] = $cols;
        return $this;
    }

    /**
     * @param string $exec
     * @return Select
     */
    public function exec(string $exec): Select
    {
        $this->arrayWhere[] = $exec;
        return $this;
    }

    /**
     * @param string $col
     * @param string $having
     * @return Select
     */
    public function groupBy(string $col, string $having = ''): Select
    {
        $this->groupBy = 'GROUP BY '.$col;
        $this->groupBy .= ($having == '') ? '' : ' HAVING '.$having;

        return $this;
    }

    /**
     * @param array $exec
     * @return Select
     */
    public function execute(array $exec = []): Select
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

            return 'SELECT '.$colSel.' FROM '.$this->table.' '.$where.' '.$this->groupBy.' '.$this->order.' '.$this->limit.' '.$this->offset;
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