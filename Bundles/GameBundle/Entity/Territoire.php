<?php
	namespace Bundles\GameBundle\Entity;

	class Territoire{
		protected $id;
		protected $joueur_id;
		protected $joueur;
		protected $nom;
		protected $position_x;
		protected $position_y;
		protected $terri_principal;
		protected $occupe;
		protected $nombre_monnaie;
		protected $nombre_uranium;
		protected $nombre_acier;
		protected $nombre_petrole;
		protected $nombre_composant;
		protected $prod_monnaie;
		protected $prod_uranium;
		protected $prod_acier;
		protected $prod_petrole;
		protected $prod_composant;
		protected $level_ministere_defense;
		protected $level_etat_major_armee_air;
		protected $level_etat_major_armee_terre;
		protected $level_etat_major_marine;
		protected $level_usine_extract_ura;
		protected $level_fonderie;
		protected $level_puit_petrole;
		protected $level_usine;
		protected $level_chantier_naval;
		protected $level_camp_entrain;
		protected $level_centre_recherche;
		protected $level_radar;
		protected $rayon_radar;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getJoueur_id(){
			return $this->joueur_id;
		}

		public function setJoueur_id($joueur_id){
			$this->joueur_id = $joueur_id;
		}
		
		public function getJoueur(){
			return $this->joueur;
		}

		public function setJoueur($joueur){
			$this->joueur = $joueur;
		}
		
		public function getNom(){
			return $this->nom;
		}

		public function setNom($nom){
			$this->nom = $nom;
		}
		
		public function getPosition_x(){
			return $this->position_x;
		}

		public function setPosition_x($position_x){
			$this->position_x = $position_x;
		}
		
		public function getPosition_y(){
			return $this->position_y;
		}

		public function setPosition_y($position_y){
			$this->position_y = $position_y;
		}
		
		public function getTerri_principal(){
			return $this->terri_principal;
		}

		public function setTerri_principal($terri_principal){
			$this->terri_principal = $terri_principal;
		}
		
		public function getOccupe(){
			return $this->occupe;
		}

		public function setOccupe($occupe){
			$this->occupe = $occupe;
		}
		
		public function getNombre_monnaie(){
			return $this->nombre_monnaie;
		}

		public function setNombre_monnaie($nombre_monnaie){
			$this->nombre_monnaie = $nombre_monnaie;
		}
		
		public function getNombre_uranium(){
			return $this->nombre_uranium;
		}

		public function setNombre_uranium($nombre_uranium){
			$this->nombre_uranium = $nombre_uranium;
		}
		
		public function getNombre_acier(){
			return $this->nombre_acier;
		}

		public function setNombre_acier($nombre_acier){
			$this->nombre_acier = $nombre_acier;
		}
		
		public function getNombre_petrole(){
			return $this->nombre_petrole;
		}

		public function setNombre_petrole($nombre_petrole){
			$this->nombre_petrole = $nombre_petrole;
		}
		
		public function getNombre_composant(){
			return $this->nombre_composant;
		}

		public function setNombre_composant($nombre_composant){
			$this->nombre_composant = $nombre_composant;
		}
		
		public function getProd_monnaie(){
			return $this->prod_monnaie;
		}

		public function setProd_monnaie($prod_monnaie){
			$this->prod_monnaie = $prod_monnaie;
		}
		
		public function getProd_uranium(){
			return $this->prod_uranium;
		}

		public function setProd_uranium($prod_uranium){
			$this->prod_uranium = $prod_uranium;
		}
		
		public function getProd_acier(){
			return $this->prod_acier;
		}

		public function setProd_acier($prod_acier){
			$this->prod_acier = $prod_acier;
		}
		
		public function getProd_petrole(){
			return $this->prod_petrole;
		}

		public function setProd_petrole($prod_petrole){
			$this->prod_petrole = $prod_petrole;
		}
		
		public function getProd_composant(){
			return $this->prod_composant;
		}

		public function setProd_composant($prod_composant){
			$this->prod_composant = $prod_composant;
		}
		
		public function getLevel_ministere_defense(){
			return $this->level_ministere_defense;
		}

		public function setLevel_ministere_defense($level_ministere_defense){
			$this->level_ministere_defense = $level_ministere_defense;
		}
		
		public function getLevel_etat_major_armee_air(){
			return $this->level_etat_major_armee_air;
		}

		public function setLevel_etat_major_armee_air($level_etat_major_armee_air){
			$this->level_etat_major_armee_air = $level_etat_major_armee_air;
		}
		
		public function getLevel_etat_major_armee_terre(){
			return $this->level_etat_major_armee_terre;
		}

		public function setLevel_etat_major_armee_terre($level_etat_major_armee_terre){
			$this->level_etat_major_armee_terre = $level_etat_major_armee_terre;
		}
		
		public function getLevel_etat_major_marine(){
			return $this->level_etat_major_marine;
		}

		public function setLevel_etat_major_marine($level_etat_major_marine){
			$this->level_etat_major_marine = $level_etat_major_marine;
		}
		
		public function getLevel_usine_extract_ura(){
			return $this->level_usine_extract_ura;
		}

		public function setLevel_usine_extract_ura($level_usine_extract_ura){
			$this->level_usine_extract_ura = $level_usine_extract_ura;
		}
		
		public function getLevel_fonderie(){
			return $this->level_fonderie;
		}

		public function setLevel_fonderie($level_fonderie){
			$this->level_fonderie = $level_fonderie;
		}
		
		public function getLevel_puit_petrole(){
			return $this->level_puit_petrole;
		}

		public function setLevel_puit_petrole($level_puit_petrole){
			$this->level_puit_petrole = $level_puit_petrole;
		}
		
		public function getLevel_usine(){
			return $this->level_usine;
		}

		public function setLevel_usine($level_usine){
			$this->level_usine = $level_usine;
		}
		
		public function getLevel_chantier_naval(){
			return $this->level_chantier_naval;
		}

		public function setLevel_chantier_naval($level_chantier_naval){
			$this->level_chantier_naval = $level_chantier_naval;
		}
		
		public function getLevel_camp_entrain(){
			return $this->level_camp_entrain;
		}

		public function setLevel_camp_entrain($level_camp_entrain){
			$this->level_camp_entrain = $level_camp_entrain;
		}
		
		public function getLevel_centre_recherche(){
			return $this->level_centre_recherche;
		}

		public function setLevel_centre_recherche($level_centre_recherche){
			$this->level_centre_recherche = $level_centre_recherche;
		}
		
		public function getLevel_radar(){
			return $this->level_radar;
		}

		public function setLevel_radar($level_radar){
			$this->level_radar = $level_radar;
		}
		
		public function getRayon_radar(){
			return $this->rayon_radar;
		}

		public function setRayon_radar($rayon_radar){
			$this->rayon_radar = $rayon_radar;
		}
	}