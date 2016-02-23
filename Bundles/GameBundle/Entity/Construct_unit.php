<?php
	namespace Bundles\GameBundle\Entity;

	class Construct_unit{
		protected $id;
		protected $territoire;
		protected $time;
		protected $temps_fin;
		protected $unite;
		protected $nom;
		protected $nombre;
		protected $type;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getTerritoire(){
			return $this->territoire;
		}

		public function setTerritoire($territoire){
			$this->territoire = $territoire;
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
		
		public function getUnite(){
			return $this->unite;
		}

		public function setUnite($unite){
			$this->unite = $unite;
		}
		
		public function getNom(){
			return $this->nom;
		}

		public function setNom($nom){
			$this->nom = $nom;
		}
		
		public function getNombre(){
			return $this->nombre;
		}

		public function setNombre($nombre){
			$this->nombre = $nombre;
		}
		
		public function getType(){
			return $this->type;
		}

		public function setType($type){
			$this->type = $type;
		}
	}