<?php
namespace LFW\ORM;
use LFW\Framework\DIC\Dic;

/**
 * Class Entity
 * @package LFW\ORM
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
		return 'LFW\ORM\\'.$system;
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

		$pathClass = $this->pathClass($orm->getSystem());
		$select = $pathClass.'\Request\Select';
		$where = $pathClass.'\Request\Where';
		$qb = $pathClass.'\QueryBuilder';

		$query = new $qb($dic, $orm->getConnexion());
		$sel = new $select([ 'table' => $table ]);
        $wh = new $where;
        $wh->where($this->primary_key, '=', ':id');
        $sel->setWhere($wh);
        $sel->setExecute([ $this->$primary_key ]);
        return $query->selectOne($sel);
	}
}