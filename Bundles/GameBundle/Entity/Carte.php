<?php
	namespace Bundles\GameBundle\Entity;

	class Carte{
		protected $id;
		protected $territoire;
		protected $joueur_id;
		protected $joueur;
		protected $statut;
		protected $position_x;
		protected $position_y;
		
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
		
		public function getJoueur_id(){
			return $this->joueur_id;
		}

		public function setJoueur_id($joueur_id){
			$this->joueur_id = $joueur_id;
		}
		
		public function getJoueur(){
			return $this->joueur;
		}

		public function setJoueur($joueur){
			$this->joueur = $joueur;
		}
		
		public function getStatut(){
			return $this->statut;
		}

		public function setStatut($statut){
			$this->statut = $statut;
		}
		
		public function getPosition_x(){
			return $this->position_x;
		}

		public function setPosition_x($position_x){
			$this->position_x = $position_x;
		}
		
		public function getPosition_y(){
			return $this->position_y;
		}

		public function setPosition_y($position_y){
			$this->position_y = $position_y;
		}
	}