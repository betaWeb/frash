<?php
	namespace Bundles\GameBundle\Entity;

	class Unit_def{
		protected $id;
		protected $nom;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getNom(){
			return $this->nom;
		}

		public function setNom($nom){
			$this->nom = $nom;
		}
	}