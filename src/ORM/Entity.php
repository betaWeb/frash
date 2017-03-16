<?php
namespace Frash\ORM;
use Frash\Framework\DIC\Dic;

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
	 * @param string $system
	 * @return string
	 */
	private function pathClass(string $system)
	{
		return 'Frash\ORM\\'.$system;
	}

	/**
	 * @param string $column
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
	 * @param int $pk
	 */
	public function setPrimaryKey(int $pk)
	{
		$this->primary_key = $pk;
	}

	/**
	 * @param Dic $dic
	 * @param string $table
	 * @param int $id
	 * @return object
	 */
	public function find(Dic $dic, string $table, int $id)
	{
		$orm = $dic->load('orm');

		$pathClass = $this->pathClass($orm->system);
		$select = $pathClass.'\Request\Select';
		$qb = $pathClass.'\QueryBuilder';

		$query = new $qb($dic, $orm->connexion);
		$sel = new $select([ 'table' => $table ]);
        $sel->where($this->primary_key, ':id')->setExecute([ $this->$primary_key ]);
        return $query->selectOne($sel);
	}
}