<?php
namespace LFW\ORM\MySQL\Request;
use LFW\ORM\RequestInterface;

/**
 * Class Select
 * @package LFW\ORM\MySQL\Request
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
     * Select constructor.
     * @param array $array
     */
    public function __construct(array $array){
        $this->table = $array['table'];
        $this->entity = ucfirst($array['table']);

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
     * @param Where $where
     */
    public function setWhere(Where $where){
        $this->where = $where->getWhere();
        $this->arrayWhere = $where->getArrayWhere();
    }

    /**
     * @param string $col
     */
    public function setColSel(string $col){
        $this->colSel = $col;
    }

    /**
     * @param array $exec
     */
    public function setExecute(array $exec = []){
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
        if(!empty($this->table) && !empty($this->colSel)){
            return 'SELECT '.$this->colSel.' FROM '.$this->table.' '.$this->where.' '.$this->order.' '.$this->limit.' '.$this->offset;
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
    public function getEntity(): string{
        return $this->entity;
    }
}