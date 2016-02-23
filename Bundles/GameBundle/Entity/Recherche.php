<?php
	namespace Bundles\GameBundle\Entity;

	class Recherche{
		protected $id;
		protected $joueur;
		protected $maniement_uranium;
		protected $unites_navales;
		protected $voilure_tournante;
		protected $bouclier_tourelle;
		protected $mitrailleuse_teleop;
		protected $grille_anti_roq;
		protected $aeronavale;
		protected $furtivite;
		protected $canon_electro;
		protected $systeme_tir_deporte;
		protected $radar_aesa;
		protected $drone_hale;
		protected $reacteur_vtol;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getJoueur(){
			return $this->joueur;
		}

		public function setJoueur($joueur){
			$this->joueur = $joueur;
		}
		
		public function getManiement_uranium(){
			return $this->maniement_uranium;
		}

		public function setManiement_uranium($maniement_uranium){
			$this->maniement_uranium = $maniement_uranium;
		}
		
		public function getUnites_navales(){
			return $this->unites_navales;
		}

		public function setUnites_navales($unites_navales){
			$this->unites_navales = $unites_navales;
		}
		
		public function getVoilure_tournante(){
			return $this->voilure_tournante;
		}

		public function setVoilure_tournante($voilure_tournante){
			$this->voilure_tournante = $voilure_tournante;
		}
		
		public function getBouclier_tourelle(){
			return $this->bouclier_tourelle;
		}

		public function setBouclier_tourelle($bouclier_tourelle){
			$this->bouclier_tourelle = $bouclier_tourelle;
		}
		
		public function getMitrailleuse_teleop(){
			return $this->mitrailleuse_teleop;
		}

		public function setMitrailleuse_teleop($mitrailleuse_teleop){
			$this->mitrailleuse_teleop = $mitrailleuse_teleop;
		}
		
		public function getGrille_anti_roq(){
			return $this->grille_anti_roq;
		}

		public function setGrille_anti_roq($grille_anti_roq){
			$this->grille_anti_roq = $grille_anti_roq;
		}
		
		public function getAeronavale(){
			return $this->aeronavale;
		}

		public function setAeronavale($aeronavale){
			$this->aeronavale = $aeronavale;
		}
		
		public function getFurtivite(){
			return $this->furtivite;
		}

		public function setFurtivite($furtivite){
			$this->furtivite = $furtivite;
		}
		
		public function getCanon_electro(){
			return $this->canon_electro;
		}

		public function setCanon_electro($canon_electro){
			$this->canon_electro = $canon_electro;
		}
		
		public function getSysteme_tir_deporte(){
			return $this->systeme_tir_deporte;
		}

		public function setSysteme_tir_deporte($systeme_tir_deporte){
			$this->systeme_tir_deporte = $systeme_tir_deporte;
		}
		
		public function getRadar_aesa(){
			return $this->radar_aesa;
		}

		public function setRadar_aesa($radar_aesa){
			$this->radar_aesa = $radar_aesa;
		}
		
		public function getDrone_hale(){
			return $this->drone_hale;
		}

		public function setDrone_hale($drone_hale){
			$this->drone_hale = $drone_hale;
		}
		
		public function getReacteur_vtol(){
			return $this->reacteur_vtol;
		}

		public function setReacteur_vtol($reacteur_vtol){
			$this->reacteur_vtol = $reacteur_vtol;
		}
	}