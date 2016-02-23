<?php
	namespace Bundles\GameBundle\Entity;

	class Alli_candid{
		protected $id;
		protected $id_candidat;
		protected $candidat;
		protected $alliance;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getId_candidat(){
			return $this->id_candidat;
		}

		public function setId_candidat($id_candidat){
			$this->id_candidat = $id_candidat;
		}
		
		public function getCandidat(){
			return $this->candidat;
		}

		public function setCandidat($candidat){
			$this->candidat = $candidat;
		}
		
		public function getAlliance(){
			return $this->alliance;
		}

		public function setAlliance($alliance){
			$this->alliance = $alliance;
		}
	}