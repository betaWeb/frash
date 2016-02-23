<?php
	namespace Bundles\GameBundle\Entity;

	class Alliance{
		protected $id;
		protected $nom;
		protected $fondateur;
		protected $nb_membre;
		protected $point;
		protected $presentation;
		protected $image;
		
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
		
		public function getFondateur(){
			return $this->fondateur;
		}

		public function setFondateur($fondateur){
			$this->fondateur = $fondateur;
		}
		
		public function getNb_membre(){
			return $this->nb_membre;
		}

		public function setNb_membre($nb_membre){
			$this->nb_membre = $nb_membre;
		}
		
		public function getPoint(){
			return $this->point;
		}

		public function setPoint($point){
			$this->point = $point;
		}
		
		public function getPresentation(){
			return $this->presentation;
		}

		public function setPresentation($presentation){
			$this->presentation = $presentation;
		}
		
		public function getImage(){
			return $this->image;
		}

		public function setImage($image){
			$this->image = $image;
		}
	}