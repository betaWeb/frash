<?php
	namespace Bundles\GameBundle\Entity;

	class Bat_etat_major_armee_air{
		protected $id;
		protected $joueur;
		protected $territoire;
		protected $niveau;
		protected $cout_monnaie;
		protected $cout_acier;
		protected $cout_composant;
		protected $temps_construction;
		
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
		
		public function getTerritoire(){
			return $this->territoire;
		}

		public function setTerritoire($territoire){
			$this->territoire = $territoire;
		}

		public function getNiveau(){
			return $this->niveau;
		}

		public function setNiveau($niveau){
			$this->niveau = $niveau;
		}
		
		public function getCout_monnaie(){
			return $this->cout_monnaie;
		}

		public function setCout_monnaie($cout_monnaie){
			$this->cout_monnaie = $cout_monnaie;
		}
		
		public function getCout_acier(){
			return $this->cout_acier;
		}

		public function setCout_acier($cout_acier){
			$this->cout_acier = $cout_acier;
		}
		
		public function getCout_composant(){
			return $this->cout_composant;
		}

		public function setCout_composant($cout_composant){
			$this->cout_composant = $cout_composant;
		}
		
		public function getTemps_construction(){
			return $this->temps_construction;
		}

		public function setTemps_construction($temps_construction){
			$this->temps_construction = $temps_construction;
		}
	}