<?php
	namespace Bundles\GameBundle\Entity;

	class Alli_fondateur{
		protected $id;
		protected $id_joueur;
		protected $joueur;
		protected $alliance;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getId_joueur(){
			return $this->id_joueur;
		}

		public function setId_joueur($id_joueur){
			$this->id_joueur = $id_joueur;
		}
		
		public function getJoueur(){
			return $this->joueur;
		}

		public function setJoueur($joueur){
			$this->joueur = $joueur;
		}
		
		public function getAlliance(){
			return $this->alliance;
		}

		public function setAlliance($alliance){
			$this->alliance = $alliance;
		}
	}