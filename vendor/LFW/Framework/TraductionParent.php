<?php
	namespace LFW\Framework;

    /**
     * Class TraductionParent
     * @package LFW\Framework
     */
	class TraductionParent{
        /**
         * @param string $trad
         * @return string
         */
		public function show($trad){
            return $this->$trad;
        }
	}