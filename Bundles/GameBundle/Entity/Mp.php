<?php
	namespace Bundles\GameBundle\Entity;

	class Mp{
		protected $id;
		protected $auteur;
		protected $auteur_id;
		protected $destinataire;
		protected $destinataire_id;
		protected $titre;
		protected $texte;
		protected $time;
		protected $nombre_vue;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getAuteur(){
			return $this->auteur;
		}

		public function setAuteur($auteur){
			$this->auteur = $auteur;
		}
		
		public function getAuteur_id(){
			return $this->auteur_id;
		}

		public function setAuteur_id($auteur_id){
			$this->auteur_id = $auteur_id;
		}
		
		public function getDestinataire(){
			return $this->destinataire;
		}

		public function setDestinataire($destinataire){
			$this->destinataire = $destinataire;
		}
		
		public function getDestinataire_id(){
			return $this->destinataire_id;
		}

		public function setDestinataire_id($destinataire_id){
			$this->destinataire_id = $destinataire_id;
		}
		
		public function getTitre(){
			return $this->titre;
		}

		public function setTitre($titre){
			$this->titre = $titre;
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
		
		public function getNombre_vue(){
			return $this->nombre_vue;
		}

		public function setNombre_vue($nombre_vue){
			$this->nombre_vue = $nombre_vue;
		}
	}