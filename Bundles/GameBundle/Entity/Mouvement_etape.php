<?php
	namespace Bundles\GameBundle\Entity;

	class Mouvement_etape{
		protected $id;
		protected $mouv;
		protected $etape_une;
		protected $etape_deux;
		protected $etape_trois;
		protected $etape_quatre;
		protected $etape_cinq;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getMouv(){
			return $this->mouv;
		}

		public function setMouv($mouv){
			$this->mouv = $mouv;
		}
		
		public function getEtape_une(){
			return $this->etape_une;
		}

		public function setEtape_une($etape_une){
			$this->etape_une = $etape_une;
		}
		
		public function getEtape_deux(){
			return $this->etape_deux;
		}

		public function setEtape_deux($etape_deux){
			$this->etape_deux = $etape_deux;
		}
		
		public function getEtape_trois(){
			return $this->etape_trois;
		}

		public function setEtape_trois($etape_trois){
			$this->etape_trois = $etape_trois;
		}
		
		public function getEtape_quatre(){
			return $this->etape_quatre;
		}

		public function setEtape_quatre($etape_quatre){
			$this->etape_quatre = $etape_quatre;
		}
		
		public function getEtape_cinq(){
			return $this->etape_cinq;
		}

		public function setEtape_cinq($etape_cinq){
			$this->etape_cinq = $etape_cinq;
		}
	}