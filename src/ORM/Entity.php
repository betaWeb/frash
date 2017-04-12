<?php
namespace Frash\ORM;
use Frash\Framework\Collection;
use Frash\Framework\DIC\Dic;
use Frash\ORM\{ OrmFactory, QueryBuilder };

/**
 * Class Entity
 * @package Frash\ORM
 */
abstract class Entity{
	/**
	 * @var int
	 */
	protected $number_result;

	/**
	 * @var string
	 */
	protected $primary_key = 'id';

	/**
	 * @var string
	 */
	protected $table = '';

	/**
	 * @var Dic
	 */
	private $dic;

	/**
	 * @var OrmFactory
	 */
	private $orm;

	/**
	 * Entity constructor.
	 * @param Dic $dic
	 */
	public function __construct(Dic $dic)
	{
		$this->dic = $dic;
		$this->orm = $this->dic->load('orm');

		$coll = new Collection(explode('\\', get_called_class()));
		$this->table = lcfirst($coll->last());
	}

	/**
	 * @param string $system
	 * @return string
	 */
	private function pathClass(string $system): string
	{
		return 'Frash\ORM\\'.$system;
	}

	/**
	 * @param string $column
	 * @return mixed
	 */
	public function __get(string $column)
	{
		return $this->$column;
	}

	/**
	 * @param string $column
	 * @param mixed $value
	 */
	public function __set(string $column, $value)
	{
		$this->$column = $value;
	}

	/**
	 * @param string $pk
	 */
	public function primaryKey(string $pk)
	{
		$this->primary_key = $pk;
		return $this;
	}

	/**
	 * @return object
	 */
	public function find()
	{
		$prim_key = $this->primary_key;
		$select = $this->pathClass($this->orm->system).'\Request\Select';

		$query = new QueryBuilder($this->dic);
		$sel = new $select([ 'table' => $this->table ]);
        $sel->where($prim_key, ':id')->execute([ $this->$prim_key ]);
        $res = $query->selectOne($sel);

        foreach($res as $col => $value){
        	$this->$col = $value;
        }
	}
}