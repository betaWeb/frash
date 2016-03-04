<?php
	namespace Bundles\GameBundle\Entity;

	class Construct_rech{
		protected $id;
		protected $rech;
		protected $joueur;
		protected $time;
		protected $temps_fin;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getRech(){
			return $this->rech;
		}

		public function setRech($rech){
			$this->rech = $rech;
		}
		
		public function getJoueur(){
			return $this->joueur;
		}

		public function setJoueur($joueur){
			$this->joueur = $joueur;
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
	}