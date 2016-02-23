<?php
	namespace Bundles\GameBundle\Entity;

	class Cate_forum{
		protected $id;
		protected $nom;
		protected $nb_topic;
		protected $nb_post;
		protected $auto_ecrire;
		
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
		
		public function getNb_topic(){
			return $this->nb_topic;
		}

		public function setNb_topic($nb_topic){
			$this->nb_topic = $nb_topic;
		}
		
		public function getNb_post(){
			return $this->nb_post;
		}

		public function setNb_post($nb_post){
			$this->nb_post = $nb_post;
		}
		
		public function getAuto_ecrire(){
			return $this->auto_ecrire;
		}

		public function setAuto_ecrire($auto_ecrire){
			$this->auto_ecrire = $auto_ecrire;
		}
	}