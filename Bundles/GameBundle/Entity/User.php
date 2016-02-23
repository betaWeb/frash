<?php
	namespace Bundles\GameBundle\Entity;

	class User{
		protected $id;
		protected $pseudo;
		protected $password;
		protected $mail;
		protected $rang;
		protected $inscription;
		protected $connexion;
		protected $deconnexion;
		protected $nb_post;
		protected $nb_topic;
		protected $point;
		protected $alliance;
		protected $nb_terri;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getPseudo(){
			return $this->pseudo;
		}

		public function setPseudo($pseudo){
			$this->pseudo = $pseudo;
		}
		
		public function getPassword(){
			return $this->password;
		}

		public function setPassword($password){
			$this->password = $password;
		}
		
		public function getMail(){
			return $this->mail;
		}

		public function setMail($mail){
			$this->mail = $mail;
		}
		
		public function getRang(){
			return $this->rang;
		}

		public function setRang($rang){
			$this->rang = $rang;
		}
		
		public function getInscription(){
			return $this->inscription;
		}

		public function setInscription($inscription){
			$this->inscription = $inscription;
		}
		
		public function getConnexion(){
			return $this->connexion;
		}

		public function setConnexion($connexion){
			$this->connexion = $connexion;
		}
		
		public function getDeconnexion(){
			return $this->deconnexion;
		}

		public function setDeconnexion($deconnexion){
			$this->deconnexion = $deconnexion;
		}
		
		public function getNb_post(){
			return $this->nb_post;
		}

		public function setNb_post($nb_post){
			$this->nb_post = $nb_post;
		}
		
		public function getNb_topic(){
			return $this->nb_topic;
		}

		public function setNb_topic($nb_topic){
			$this->nb_topic = $nb_topic;
		}
		
		public function getPoint(){
			return $this->point;
		}

		public function setPoint($point){
			$this->point = $point;
		}
		
		public function getAlliance(){
			return $this->alliance;
		}

		public function setAlliance($alliance){
			$this->alliance = $alliance;
		}
		
		public function getNb_terri(){
			return $this->nb_terri;
		}

		public function setNb_terri($nb_terri){
			$this->nb_terri = $nb_terri;
		}
	}