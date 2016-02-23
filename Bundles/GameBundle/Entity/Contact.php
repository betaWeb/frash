<?php
	namespace Bundles\GameBundle\Entity;

	class Contact{
		protected $id;
		protected $texte;
		protected $pseudo;
		protected $traite;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getTexte(){
			return $this->texte;
		}

		public function setTexte($texte){
			$this->texte = $texte;
		}
		
		public function getPseudo(){
			return $this->pseudo;
		}

		public function setPseudo($pseudo){
			$this->pseudo = $pseudo;
		}
		
		public function getTraite(){
			return $this->traite;
		}

		public function setTraite($traite){
			$this->traite = $traite;
		}
	}