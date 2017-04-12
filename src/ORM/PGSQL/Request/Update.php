<?php
namespace Frash\ORM\PGSQL\Request;
use Frash\ORM\RequestInterface;
use Frash\ORM\PGSQL\Request\Where;

/**
 * Class Update
 * @package Frash\ORM\PGSQL\Request
 */
class Update extends Where implements RequestInterface{
    /**
     * @var string
     */
    private $table = '';

    /**
     * @var string
     */
    private $update = '';

    /**
     * @var array
     */
    private $updateExecute = [];

    /**
     * @var array
     */
    private $execute = [];

    /**
     * Update constructor.
     * @param string $table
     */
    public function __construct(string $table){
        $this->table = "\"$table\"";
    }

    /**
     * @param string $exec
     */
    public function addExec(string $exec){
        $this->updateExecute[] = $exec;
        return $this;
    }

    /**
     * @param array $update
     */
    public function update(array $update = []){
        $upd = [];

        foreach($update as $k => $v){
            $comp = substr($k, -2);
            $col = substr($k, 0, -2);

            switch($comp){
                case ' +':
                    $upd[] = "\"$col\" = \"$col\" + ".$v;
                    $this->updateExecute[] = substr($v, 1);
                    break;
                case ' -':
                    $upd[] = "\"$col\" = \"$col\" - ".$v;
                    $this->updateExecute[] = substr($v, 1);
                    break;
                case ' /':
                    $upd[] = "\"$col\"".' = '.$v;
                    break;
                default:
                    $upd[] = "\"$k\"".' = '.$v;
                    $this->updateExecute[] = substr($v, 1);
            }
        }

        $this->update = implode(', ', $upd);
        return $this;
    }

    /**
     * @param array $exec
     */
    public function execute(array $exec){
        foreach($this->updateExecute as $v){
            $arrayUpd[] = $v;
        }

        $result = array_merge($arrayUpd, $this->arrayWhere);

        if(count($exec) == count($result)){
            $this->execute = array_combine($result, $exec);
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
        if(!empty($this->table) && !empty($this->update)){
            $request = 'UPDATE '.$this->table.' SET '.$this->update.' ';
            if($this->where != 'WHERE '){ $request .= $this->where; }
            return $request;
        }
    }
}