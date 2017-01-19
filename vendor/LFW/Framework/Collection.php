<?php
	namespace LFW\Framework;

    /**
     * Class Collection
     * @package LFW\Framework
     */
	class Collection{
		/**
		 * @var array
		 */
		private $array = [];

        /**
         * Collection constructor.
         * @param array $array
         */
		public function __construct(array $array){
			$this->array = $array;
		}

		/**
		 * @param array $array
		 * @param string $interval
		 * @return array
		 */
		public function interval(array $array, string $interval): array{
			$return = [];

			if($interval[0] == ':'){
				$start = 0;
			}
			else{
				preg_match('/^(\d+);/', $interval, $match);
				$start = $match;
			}

			if(substr($interval, -1) == ':'){
				$end = count($array);
			}
			else{
				preg_match('/;(\d+)$/', $interval, $match);
				$end = $match;
			}

			for($i = $start; $i <= $end; $i++){
				$return[] = $array[ $i ];
			}

			return $return;
		}
	}