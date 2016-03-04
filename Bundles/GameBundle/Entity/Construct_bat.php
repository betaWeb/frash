<?php
	namespace Bundles\GameBundle\Entity;

	class Construct_bat{
		protected $id;
		protected $bat;
		protected $time;
		protected $temps_fin;
		protected $territoire;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getBat(){
			return $this->bat;
		}

		public function setBat($bat){
			$this->bat = $bat;
		}
		
		public function getTime(){
			return $this->time;
		}

		public function setTime($time){
			$this->time = $time;
		}
		
		public function getTemps_fin(){
			return $this->temps_fin;
		}

		public function setTemps_fin($temps_fin){
			$this->temps_fin = $temps_fin;
		}
		
		public function getTerritoire(){
			return $this->territoire;
		}

		public function setTerritoire($territoire){
			$this->territoire = $territoire;
		}
	}