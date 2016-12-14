<?php
	namespace LFW\Framework\Utility;

    /**
     * Class MathClass
     * @package LFW\Framework\Utility
     */
	class MathClass{
        /**
         * @param int $mult
         * @param int $div
         * @return int
         */
		public static function percentage(int $mult, int $div): int{
			return $mult * 100 / $div;
		}
	}