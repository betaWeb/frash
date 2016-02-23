<?php
	namespace Bundles\GameBundle\Entity;

	class Post{
		protected $id;
		protected $topic;
		protected $auteur_id;
		protected $auteur;
		protected $texte;
		protected $time;
		protected $first_post;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getTopic(){
			return $this->topic;
		}

		public function setTopic($topic){
			$this->topic = $topic;
		}
		
		public function getAuteur_id(){
			return $this->auteur_id;
		}

		public function setAuteur_id($auteur_id){
			$this->auteur_id = $auteur_id;
		}
		
		public function getAuteur(){
			return $this->auteur;
		}

		public function setAuteur($auteur){
			$this->auteur = $auteur;
		}
		
		public function getTexte(){
			return $this->texte;
		}

		public function setTexte($texte){
			$this->texte = $texte;
		}
		
		public function getTime(){
			return $this->time;
		}

		public function setTime($time){
			$this->time = $time;
		}
		
		public function getFirst_post(){
			return $this->first_post;
		}

		public function setFirst_post($first_post){
			$this->first_post = $first_post;
		}
	}