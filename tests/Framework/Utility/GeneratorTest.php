<?php
namespace FrashTest\Framework\Utility;
use Frash\Framework\Utility\Generator;
use Frash\UnitTest\Extend\SimpleTest;

class GeneratorTest extends SimpleTest{
	public function get_test(){
		$this->checkRegex('/^([a-zA-Z]*)$/', Generator::get(10, false, true, true, false));
		$this->checkRegex('/^([a-z]*)$/', Generator::get(10, false, true, false, false));
		$this->checkRegex('/^([A-Z]*)$/', Generator::get(10, false, false, true, false));
		$this->checkRegex('/^([0-9]*)$/', Generator::get(10, true, false, false, false));
	}
}