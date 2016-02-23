<?php
	namespace Bundles\GameBundle\Entity;

	class Mouvement{
		protected $id;
		protected $type;
		protected $lanceur;
		protected $lanceur_id;
		protected $terri_lanceur;
		protected $coord_lanceur;
		protected $groupe_lanceur;
		protected $cible;
		protected $cible_id;
		protected $terri_cible;
		protected $position_cible;
		protected $temps_fin;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getType(){
			return $this->type;
		}

		public function setType($type){
			$this->type = $type;
		}
		
		public function getLanceur(){
			return $this->lanceur;
		}

		public function setLanceur($lanceur){
			$this->lanceur = $lanceur;
		}
		
		public function getLanceur_id(){
			return $this->lanceur_id;
		}

		public function setLanceur_id($lanceur_id){
			$this->lanceur_id = $lanceur_id;
		}
		
		public function getTerri_lanceur(){
			return $this->terri_lanceur;
		}

		public function setTerri_lanceur($terri_lanceur){
			$this->terri_lanceur = $terri_lanceur;
		}
		
		public function getCoord_lanceur(){
			return $this->coord_lanceur;
		}

		public function setCoord_lanceur($coord_lanceur){
			$this->coord_lanceur = $coord_lanceur;
		}
		
		public function getGroupe_lanceur(){
			return $this->groupe_lanceur;
		}

		public function setGroupe_lanceur($groupe_lanceur){
			$this->groupe_lanceur = $groupe_lanceur;
		}
		
		public function getCible(){
			return $this->cible;
		}

		public function setCible($cible){
			$this->cible = $cible;
		}
		
		public function getCible_id(){
			return $this->cible_id;
		}

		public function setCible_id($cible_id){
			$this->cible_id = $cible_id;
		}
		
		public function getTerri_cible(){
			return $this->terri_cible;
		}

		public function setTerri_cible($terri_cible){
			$this->terri_cible = $terri_cible;
		}
		
		public function getPosition_cible(){
			return $this->position_cible;
		}

		public function setPosition_cible($position_cible){
			$this->position_cible = $position_cible;
		}
		
		public function getTemps_fin(){
			return $this->temps_fin;
		}

		public function setTemps_fin($temps_fin){
			$this->temps_fin = $temps_fin;
		}
	}