<?php
namespace FrashTest\Framework\Utility\Formatting;
use Frash\Framework\Utility\Formatting\Collection;
use Frash\UnitTest\Extend\SimpleTest;

class CollectionTest extends SimpleTest{
	private $class;

	public function __construct(){
		$this->class = new Collection([ 1, 2, 3, 4, 5 ]);
	}

	public function first_test(){
		$this->checkEqual(1, $this->class->first());
	}

	public function interval_test(){
		$this->checkEqual([ 2, 3 ], $this->class->interval('1:2'));
		$this->checkEqual([ 4, 5 ], $this->class->interval('3:'));
		$this->checkEqual([ 1, 2 ], $this->class->interval(':1'));
	}

	public function last_test(){
		$this->checkEqual(5, $this->class->last());
	}
}