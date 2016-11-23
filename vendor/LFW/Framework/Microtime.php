<?php
	namespace LFW\Framework;

	class Microtime{
		private $microtime = [];

		public function setMicrotime($name){
			$this->microtime[ $name ] = microtime(true) * 1000;
		}

		public function getTiming($start, $end){
			return substr($this->microtime[ $end ] - $this->microtime[ $start ], 0, 5);
		}
	}