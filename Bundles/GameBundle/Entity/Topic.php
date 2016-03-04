<?php
	namespace Bundles\GameBundle\Entity;

	class Topic{
		protected $id;
		protected $nom;
		protected $cat;
		protected $id_auteur;
		protected $pseudo_auteur;
		protected $time_creation;
		protected $nb_post;
		protected $annonce;
		protected $locked;
		protected $derniere_modif;
		
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
		
		public function getCat(){
			return $this->cat;
		}

		public function setCat($cat){
			$this->cat = $cat;
		}
		
		public function getId_auteur(){
			return $this->id_auteur;
		}

		public function setId_auteur($id_auteur){
			$this->id_auteur = $id_auteur;
		}
		
		public function getPseudo_auteur(){
			return $this->pseudo_auteur;
		}

		public function setPseudo_auteur($pseudo_auteur){
			$this->pseudo_auteur = $pseudo_auteur;
		}
		
		public function getTime_creation(){
			return $this->time_creation;
		}

		public function setTime_creation($time_creation){
			$this->time_creation = $time_creation;
		}
		
		public function getNb_post(){
			return $this->nb_post;
		}

		public function setNb_post($nb_post){
			$this->nb_post = $nb_post;
		}
		
		public function getAnnonce(){
			return $this->annonce;
		}

		public function setAnnonce($annonce){
			$this->annonce = $annonce;
		}
		
		public function getLocked(){
			return $this->locked;
		}

		public function setLocked($locked){
			$this->locked = $locked;
		}
		
		public function getDerniere_modif(){
			return $this->derniere_modif;
		}

		public function setDerniere_modif($derniere_modif){
			$this->derniere_modif = $derniere_modif;
		}
	}