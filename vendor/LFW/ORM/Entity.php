<?php
	namespace LFW\ORM;

    /**
     * Class Entity
     * @package LFW\ORM
     */
	class Entity{
		/**
		 * @var int
		 */
		protected $number_result;

		/**
		 * @return int
		 */
		public function getNumber_result(): int{
			return $this->number_result;
		}

		/**
		 * @param int $number_result
		 */
		public function setNumber_result(int $number_result){
			$this->number_result = $number_result;
		}
	}