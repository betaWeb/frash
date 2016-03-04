<?php
	namespace Bundles\GameBundle\Entity;

	class Radar{
		protected $id;
		protected $joueur;
		protected $groupe;
		protected $type_radar;
		protected $position_x_min;
		protected $position_x_max;
		protected $position_y_min;
		protected $position_y_max;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getJoueur(){
			return $this->joueur;
		}

		public function setJoueur($joueur){
			$this->joueur = $joueur;
		}
		
		public function getGroupe(){
			return $this->groupe;
		}

		public function setGroupe($groupe){
			$this->groupe = $groupe;
		}
		
		public function getType_radar(){
			return $this->type_radar;
		}

		public function setType_radar($type_radar){
			$this->type_radar = $type_radar;
		}
		
		public function getPosition_x_min(){
			return $this->position_x_min;
		}

		public function setPosition_x_min($position_x_min){
			$this->position_x_min = $position_x_min;
		}
		
		public function getPosition_x_max(){
			return $this->position_x_max;
		}

		public function setPosition_x_max($position_x_max){
			$this->position_x_max = $position_x_max;
		}
		
		public function getPosition_y_min(){
			return $this->position_y_min;
		}

		public function setPosition_y_min($position_y_min){
			$this->position_y_min = $position_y_min;
		}
		
		public function getPosition_y_max(){
			return $this->position_y_max;
		}

		public function setPosition_y_max($position_y_max){
			$this->position_y_max = $position_y_max;
		}
	}