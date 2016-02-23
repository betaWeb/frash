<?php
	namespace Bundles\GameBundle\Entity;

	class Groupe{
		protected $id;
		protected $joueur;
		protected $territoire;
		protected $reserve;
		protected $nom_gr;
		protected $mouvement;
		protected $pos_x;
		protected $pos_y;
		protected $pos_x_mini;
		protected $pos_y_mini;
		protected $monnaie;
		protected $uranium;
		protected $acier;
		protected $petrole;
		protected $composant;
		protected $nb_aviateur;
		protected $nb_avion_bireact_soutien;
		protected $nb_avion_chasse;
		protected $nb_avion_leger_transport;
		protected $nb_avion_patrouille_detect;
		protected $nb_avion_reco_embarque;
		protected $nb_avion_soutien_aerien;
		protected $nb_avion_transport_avance;
		protected $nb_awacs;
		protected $nb_batterie_antiaerienne;
		protected $nb_batterie_dca;
		protected $nb_batterie_roquette;
		protected $nb_blinde_leger_cmdt;
		protected $nb_camion_citerne;
		protected $nb_camion_transp_materiel;
		protected $nb_camion_transp_troupe;
		protected $nb_cargo;
		protected $nb_chaland_debarq;
		protected $nb_char;
		protected $nb_chasseur_alpin;
		protected $nb_commando;
		protected $nb_drone_hale;
		protected $nb_embarcation_navale_rapide;
		protected $nb_fregate;
		protected $nb_helico;
		protected $nb_helico_attaque;
		protected $nb_helico_lourd;
		protected $nb_hummer;
		protected $nb_kayak;
		protected $nb_marin;
		protected $nb_mini_drone;
		protected $nb_mortier_tracte;
		protected $nb_obusier;
		protected $nb_patrouilleur_naval;
		protected $nb_porte_avions;
		protected $nb_porte_helico;
		protected $nb_propulseur_sous_marin;
		protected $nb_ravitailleur_mer;
		protected $nb_ravitailleur_vol;
		protected $nb_soldat;
		protected $nb_sousmarin_nucleaire_attaque;
		protected $nb_sousmarin_projection_strategique;
		protected $nb_station_radar_mobile;
		protected $nb_systeme_drone_tactique;
		protected $nb_systeme_transmission;
		protected $nb_vehicule_blinde_arme_leger;
		protected $nb_vehicule_blinde_leger;
		protected $nb_vehicule_surveillance_sol;
		protected $nb_zodiac_rapide_prise_assaut;
		protected $nb_bombe_haute_precision;
		protected $nb_missile_airair;
		protected $nb_missile_airsol;
		protected $nb_missile_antiair;
		protected $nb_missile_balist_navire;
		protected $nb_roq_antichar;
		protected $nb_roq_batterie;
		protected $nb_torpille;
		protected $nb_miss_lanc_port;
		protected $nb_mine_marine;
		protected $nb_mine_antichar;
		protected $nb_miss_antiradar;
		protected $nb_obus_140mm;
		protected $nb_obus_100mm;
		protected $nb_obus_80mm;
		protected $nb_obus_40mm;
		protected $nb_obus_mortier;
		protected $nb_obus_mortier_eclair;
		protected $nb_obus_30mm;
		protected $nb_obus_20mm;
		protected $nb_obus_12_7;
		protected $nb_charg_fusil_assaut;
		protected $nb_charg_fusil_precis;
		protected $nb_charg_mitrailleuse;
		protected $nb_charg_arme_poing;
		protected $nb_charg_fusil_pompe;
		protected $nb_charg_mitraillette;
		protected $nb_fumigene;
		protected $nb_grenade_explo;
		protected $nb_grenade_para;
		protected $nb_mortier;
		protected $nb_lanc_miss_port;
		protected $nb_lanc_roq_antichar;
		protected $nb_miss_antiair_port;
		protected $nb_mitraill_12_7;
		protected $nb_claymore;
		
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
		
		public function getTerritoire(){
			return $this->territoire;
		}

		public function setTerritoire($territoire){
			$this->territoire = $territoire;
		}
		
		public function getReserve(){
			return $this->reserve;
		}

		public function setReserve($reserve){
			$this->reserve = $reserve;
		}
		
		public function getNom_gr(){
			return $this->nom_gr;
		}

		public function setNom_gr($nom_gr){
			$this->nom_gr = $nom_gr;
		}
		
		public function getMouvement(){
			return $this->mouvement;
		}

		public function setMouvement($mouvement){
			$this->mouvement = $mouvement;
		}
		
		public function getPos_x(){
			return $this->pos_x;
		}

		public function setPos_x($pos_x){
			$this->pos_x = $pos_x;
		}
		
		public function getPos_y(){
			return $this->pos_y;
		}

		public function setPos_y($pos_y){
			$this->pos_y = $pos_y;
		}
		
		public function getPos_x_mini(){
			return $this->pos_x_mini;
		}

		public function setPos_x_mini($pos_x_mini){
			$this->pos_x_mini = $pos_x_mini;
		}
		
		public function getPos_y_mini(){
			return $this->pos_y_mini;
		}

		public function setPos_y_mini($pos_y_mini){
			$this->pos_y_mini = $pos_y_mini;
		}
		
		public function getMonnaie(){
			return $this->monnaie;
		}

		public function setMonnaie($monnaie){
			$this->monnaie = $monnaie;
		}
		
		public function getUranium(){
			return $this->uranium;
		}

		public function setUranium($uranium){
			$this->uranium = $uranium;
		}
		
		public function getAcier(){
			return $this->acier;
		}

		public function setAcier($acier){
			$this->acier = $acier;
		}
		
		public function getPetrole(){
			return $this->petrole;
		}

		public function setPetrole($petrole){
			$this->petrole = $petrole;
		}
		
		public function getComposant(){
			return $this->composant;
		}

		public function setComposant($composant){
			$this->composant = $composant;
		}
		
		public function getNb_aviateur(){
			return $this->nb_aviateur;
		}

		public function setNb_aviateur($nb_aviateur){
			$this->nb_aviateur = $nb_aviateur;
		}
		
		public function getNb_avion_bireact_soutien(){
			return $this->nb_avion_bireact_soutien;
		}

		public function setNb_avion_bireact_soutien($nb_avion_bireact_soutien){
			$this->nb_avion_bireact_soutien = $nb_avion_bireact_soutien;
		}
		
		public function getNb_avion_chasse(){
			return $this->nb_avion_chasse;
		}

		public function setNb_avion_chasse($nb_avion_chasse){
			$this->nb_avion_chasse = $nb_avion_chasse;
		}
		
		public function getNb_avion_leger_transport(){
			return $this->nb_avion_leger_transport;
		}

		public function setNb_avion_leger_transport($nb_avion_leger_transport){
			$this->nb_avion_leger_transport = $nb_avion_leger_transport;
		}
		
		public function getNb_avion_patrouille_detect(){
			return $this->nb_avion_patrouille_detect;
		}

		public function setNb_avion_patrouille_detect($nb_avion_patrouille_detect){
			$this->nb_avion_patrouille_detect = $nb_avion_patrouille_detect;
		}
		
		public function getNb_avion_reco_embarque(){
			return $this->nb_avion_reco_embarque;
		}

		public function setNb_avion_reco_embarque($nb_avion_reco_embarque){
			$this->nb_avion_reco_embarque = $nb_avion_reco_embarque;
		}
		
		public function getNb_avion_soutien_aerien(){
			return $this->nb_avion_soutien_aerien;
		}

		public function setNb_avion_soutien_aerien($nb_avion_soutien_aerien){
			$this->nb_avion_soutien_aerien = $nb_avion_soutien_aerien;
		}
		
		public function getNb_avion_transport_avance(){
			return $this->nb_avion_transport_avance;
		}

		public function setNb_avion_transport_avance($nb_avion_transport_avance){
			$this->nb_avion_transport_avance = $nb_avion_transport_avance;
		}
		
		public function getNb_awacs(){
			return $this->nb_awacs;
		}

		public function setNb_awacs($nb_awacs){
			$this->nb_awacs = $nb_awacs;
		}
		
		public function getNb_batterie_antiaerienne(){
			return $this->nb_batterie_antiaerienne;
		}

		public function setNb_batterie_antiaerienne($nb_batterie_antiaerienne){
			$this->nb_batterie_antiaerienne = $nb_batterie_antiaerienne;
		}
		
		public function getNb_batterie_dca(){
			return $this->nb_batterie_dca;
		}

		public function setNb_batterie_dca($nb_batterie_dca){
			$this->nb_batterie_dca = $nb_batterie_dca;
		}
		
		public function getNb_batterie_roquette(){
			return $this->nb_batterie_roquette;
		}

		public function setNb_batterie_roquette($nb_batterie_roquette){
			$this->nb_batterie_roquette = $nb_batterie_roquette;
		}
		
		public function getNb_blinde_leger_cmdt(){
			return $this->nb_blinde_leger_cmdt;
		}

		public function setNb_blinde_leger_cmdt($nb_blinde_leger_cmdt){
			$this->nb_blinde_leger_cmdt = $nb_blinde_leger_cmdt;
		}
		
		public function getNb_camion_citerne(){
			return $this->nb_camion_citerne;
		}

		public function setNb_camion_citerne($nb_camion_citerne){
			$this->nb_camion_citerne = $nb_camion_citerne;
		}
		
		public function getNb_camion_transp_materiel(){
			return $this->nb_camion_transp_materiel;
		}

		public function setNb_camion_transp_materiel($nb_camion_transp_materiel){
			$this->nb_camion_transp_materiel = $nb_camion_transp_materiel;
		}
		
		public function getNb_camion_transp_troupe(){
			return $this->nb_camion_transp_troupe;
		}

		public function setNb_camion_transp_troupe($nb_camion_transp_troupe){
			$this->nb_camion_transp_troupe = $nb_camion_transp_troupe;
		}
		
		public function getNb_cargo(){
			return $this->nb_cargo;
		}

		public function setNb_cargo($nb_cargo){
			$this->nb_cargo = $nb_cargo;
		}
		
		public function getNb_chaland_debarq(){
			return $this->nb_chaland_debarq;
		}

		public function setNb_chaland_debarq($nb_chaland_debarq){
			$this->nb_chaland_debarq = $nb_chaland_debarq;
		}
		
		public function getNb_char(){
			return $this->nb_char;
		}

		public function setNb_char($nb_char){
			$this->nb_char = $nb_char;
		}
		
		public function getNb_chasseur_alpin(){
			return $this->nb_chasseur_alpin;
		}

		public function setNb_chasseur_alpin($nb_chasseur_alpin){
			$this->nb_chasseur_alpin = $nb_chasseur_alpin;
		}
		
		public function getNb_commando(){
			return $this->nb_commando;
		}

		public function setNb_commando($nb_commando){
			$this->nb_commando = $nb_commando;
		}
		
		public function getNb_drone_hale(){
			return $this->nb_drone_hale;
		}

		public function setNb_drone_hale($nb_drone_hale){
			$this->nb_drone_hale = $nb_drone_hale;
		}
		
		public function getNb_embarcation_navale_rapide(){
			return $this->nb_embarcation_navale_rapide;
		}

		public function setNb_embarcation_navale_rapide($nb_embarcation_navale_rapide){
			$this->nb_embarcation_navale_rapide = $nb_embarcation_navale_rapide;
		}
		
		public function getNb_fregate(){
			return $this->nb_fregate;
		}

		public function setNb_fregate($nb_fregate){
			$this->nb_fregate = $nb_fregate;
		}
		
		public function getNb_helico(){
			return $this->nb_helico;
		}

		public function setNb_helico($nb_helico){
			$this->nb_helico = $nb_helico;
		}
		
		public function getNb_helico_attaque(){
			return $this->nb_helico_attaque;
		}

		public function setNb_helico_attaque($nb_helico_attaque){
			$this->nb_helico_attaque = $nb_helico_attaque;
		}
		
		public function getNb_helico_lourd(){
			return $this->nb_helico_lourd;
		}

		public function setNb_helico_lourd($nb_helico_lourd){
			$this->nb_helico_lourd = $nb_helico_lourd;
		}
		
		public function getNb_hummer(){
			return $this->nb_hummer;
		}

		public function setNb_hummer($nb_hummer){
			$this->nb_hummer = $nb_hummer;
		}
		
		public function getNb_kayak(){
			return $this->nb_kayak;
		}

		public function setNb_kayak($nb_kayak){
			$this->nb_kayak = $nb_kayak;
		}
		
		public function getNb_marin(){
			return $this->nb_marin;
		}

		public function setNb_marin($nb_marin){
			$this->nb_marin = $nb_marin;
		}
		
		public function getNb_mini_drone(){
			return $this->nb_mini_drone;
		}

		public function setNb_mini_drone($nb_mini_drone){
			$this->nb_mini_drone = $nb_mini_drone;
		}
		
		public function getNb_mortier_tracte(){
			return $this->nb_mortier_tracte;
		}

		public function setNb_mortier_tracte($nb_mortier_tracte){
			$this->nb_mortier_tracte = $nb_mortier_tracte;
		}
		
		public function getNb_obusier(){
			return $this->nb_obusier;
		}

		public function setNb_obusier($nb_obusier){
			$this->nb_obusier = $nb_obusier;
		}
		
		public function getNb_patrouilleur_naval(){
			return $this->nb_patrouilleur_naval;
		}

		public function setNb_patrouilleur_naval($nb_patrouilleur_naval){
			$this->nb_patrouilleur_naval = $nb_patrouilleur_naval;
		}
		
		public function getNb_porte_avions(){
			return $this->nb_porte_avions;
		}

		public function setNb_porte_avions($nb_porte_avions){
			$this->nb_porte_avions = $nb_porte_avions;
		}
		
		public function getNb_porte_helico(){
			return $this->nb_porte_helico;
		}

		public function setNb_porte_helico($nb_porte_helico){
			$this->nb_porte_helico = $nb_porte_helico;
		}
		
		public function getNb_propulseur_sous_marin(){
			return $this->nb_propulseur_sous_marin;
		}

		public function setNb_propulseur_sous_marin($nb_propulseur_sous_marin){
			$this->nb_propulseur_sous_marin = $nb_propulseur_sous_marin;
		}
		
		public function getNb_ravitailleur_mer(){
			return $this->nb_ravitailleur_mer;
		}

		public function setNb_ravitailleur_mer($nb_ravitailleur_mer){
			$this->nb_ravitailleur_mer = $nb_ravitailleur_mer;
		}
		
		public function getNb_ravitailleur_vol(){
			return $this->nb_ravitailleur_vol;
		}

		public function setNb_ravitailleur_vol($nb_ravitailleur_vol){
			$this->nb_ravitailleur_vol = $nb_ravitailleur_vol;
		}
		
		public function getNb_soldat(){
			return $this->nb_soldat;
		}

		public function setNb_soldat($nb_soldat){
			$this->nb_soldat = $nb_soldat;
		}
		
		public function getNb_sousmarin_nucleaire_attaque(){
			return $this->nb_sousmarin_nucleaire_attaque;
		}

		public function setNb_sousmarin_nucleaire_attaque($nb_sousmarin_nucleaire_attaque){
			$this->nb_sousmarin_nucleaire_attaque = $nb_sousmarin_nucleaire_attaque;
		}
		
		public function getNb_sousmarin_projection_strategique(){
			return $this->nb_sousmarin_projection_strategique;
		}

		public function setNb_sousmarin_projection_strategique($nb_sousmarin_projection_strategique){
			$this->nb_sousmarin_projection_strategique = $nb_sousmarin_projection_strategique;
		}
		
		public function getNb_station_radar_mobile(){
			return $this->nb_station_radar_mobile;
		}

		public function setNb_station_radar_mobile($nb_station_radar_mobile){
			$this->nb_station_radar_mobile = $nb_station_radar_mobile;
		}
		
		public function getNb_systeme_drone_tactique(){
			return $this->nb_systeme_drone_tactique;
		}

		public function setNb_systeme_drone_tactique($nb_systeme_drone_tactique){
			$this->nb_systeme_drone_tactique = $nb_systeme_drone_tactique;
		}
		
		public function getNb_systeme_transmission(){
			return $this->nb_systeme_transmission;
		}

		public function setNb_systeme_transmission($nb_systeme_transmission){
			$this->nb_systeme_transmission = $nb_systeme_transmission;
		}
		
		public function getNb_vehicule_blinde_arme_leger(){
			return $this->nb_vehicule_blinde_arme_leger;
		}

		public function setNb_vehicule_blinde_arme_leger($nb_vehicule_blinde_arme_leger){
			$this->nb_vehicule_blinde_arme_leger = $nb_vehicule_blinde_arme_leger;
		}
		
		public function getNb_vehicule_blinde_leger(){
			return $this->nb_vehicule_blinde_leger;
		}

		public function setNb_vehicule_blinde_leger($nb_vehicule_blinde_leger){
			$this->nb_vehicule_blinde_leger = $nb_vehicule_blinde_leger;
		}
		
		public function getNb_vehicule_surveillance_sol(){
			return $this->nb_vehicule_surveillance_sol;
		}

		public function setNb_vehicule_surveillance_sol($nb_vehicule_surveillance_sol){
			$this->nb_vehicule_surveillance_sol = $nb_vehicule_surveillance_sol;
		}
		
		public function getNb_zodiac_rapide_prise_assaut(){
			return $this->nb_zodiac_rapide_prise_assaut;
		}

		public function setNb_zodiac_rapide_prise_assaut($nb_zodiac_rapide_prise_assaut){
			$this->nb_zodiac_rapide_prise_assaut = $nb_zodiac_rapide_prise_assaut;
		}
		
		public function getNb_bombe_haute_precision(){
			return $this->nb_bombe_haute_precision;
		}

		public function setNb_bombe_haute_precision($nb_bombe_haute_precision){
			$this->nb_bombe_haute_precision = $nb_bombe_haute_precision;
		}
		
		public function getNb_missile_airair(){
			return $this->nb_missile_airair;
		}

		public function setNb_missile_airair($nb_missile_airair){
			$this->nb_missile_airair = $nb_missile_airair;
		}
		
		public function getNb_missile_airsol(){
			return $this->nb_missile_airsol;
		}

		public function setNb_missile_airsol($nb_missile_airsol){
			$this->nb_missile_airsol = $nb_missile_airsol;
		}
		
		public function getNb_missile_antiair(){
			return $this->nb_missile_antiair;
		}

		public function setNb_missile_antiair($nb_missile_antiair){
			$this->nb_missile_antiair = $nb_missile_antiair;
		}
		
		public function getNb_missile_balist_navire(){
			return $this->nb_missile_balist_navire;
		}

		public function setNb_missile_balist_navire($nb_missile_balist_navire){
			$this->nb_missile_balist_navire = $nb_missile_balist_navire;
		}
		
		public function getNb_roq_antichar(){
			return $this->nb_roq_antichar;
		}

		public function setNb_roq_antichar($nb_roq_antichar){
			$this->nb_roq_antichar = $nb_roq_antichar;
		}
		
		public function getNb_roq_batterie(){
			return $this->nb_roq_batterie;
		}

		public function setNb_roq_batterie($nb_roq_batterie){
			$this->nb_roq_batterie = $nb_roq_batterie;
		}
		
		public function getNb_torpille(){
			return $this->nb_torpille;
		}

		public function setNb_torpille($nb_torpille){
			$this->nb_torpille = $nb_torpille;
		}
		
		public function getNb_miss_lanc_port(){
			return $this->nb_miss_lanc_port;
		}

		public function setNb_miss_lanc_port($nb_miss_lanc_port){
			$this->nb_miss_lanc_port = $nb_miss_lanc_port;
		}
		
		public function getNb_mine_marine(){
			return $this->nb_mine_marine;
		}

		public function setNb_mine_marine($nb_mine_marine){
			$this->nb_mine_marine = $nb_mine_marine;
		}
		
		public function getNb_mine_antichar(){
			return $this->nb_mine_antichar;
		}

		public function setNb_mine_antichar($nb_mine_antichar){
			$this->nb_mine_antichar = $nb_mine_antichar;
		}
		
		public function getNb_miss_antiradar(){
			return $this->nb_miss_antiradar;
		}

		public function setNb_miss_antiradar($nb_miss_antiradar){
			$this->nb_miss_antiradar = $nb_miss_antiradar;
		}
		
		public function getNb_obus_140mm(){
			return $this->nb_obus_140mm;
		}

		public function setNb_obus_140mm($nb_obus_140mm){
			$this->nb_obus_140mm = $nb_obus_140mm;
		}
		
		public function getNb_obus_100mm(){
			return $this->nb_obus_100mm;
		}

		public function setNb_obus_100mm($nb_obus_100mm){
			$this->nb_obus_100mm = $nb_obus_100mm;
		}
		
		public function getNb_obus_80mm(){
			return $this->nb_obus_80mm;
		}

		public function setNb_obus_80mm($nb_obus_80mm){
			$this->nb_obus_80mm = $nb_obus_80mm;
		}
		
		public function getNb_obus_40mm(){
			return $this->nb_obus_40mm;
		}

		public function setNb_obus_40mm($nb_obus_40mm){
			$this->nb_obus_40mm = $nb_obus_40mm;
		}
		
		public function getNb_obus_mortier(){
			return $this->nb_obus_mortier;
		}

		public function setNb_obus_mortier($nb_obus_mortier){
			$this->nb_obus_mortier = $nb_obus_mortier;
		}
		
		public function getNb_obus_mortier_eclair(){
			return $this->nb_obus_mortier_eclair;
		}

		public function setNb_obus_mortier_eclair($nb_obus_mortier_eclair){
			$this->nb_obus_mortier_eclair = $nb_obus_mortier_eclair;
		}
		
		public function getNb_obus_30mm(){
			return $this->nb_obus_30mm;
		}

		public function setNb_obus_30mm($nb_obus_30mm){
			$this->nb_obus_30mm = $nb_obus_30mm;
		}
		
		public function getNb_obus_20mm(){
			return $this->nb_obus_20mm;
		}

		public function setNb_obus_20mm($nb_obus_20mm){
			$this->nb_obus_20mm = $nb_obus_20mm;
		}
		
		public function getNb_obus_12_7(){
			return $this->nb_obus_12_7;
		}

		public function setNb_obus_12_7($nb_obus_12_7){
			$this->nb_obus_12_7 = $nb_obus_12_7;
		}
		
		public function getNb_charg_fusil_assaut(){
			return $this->nb_charg_fusil_assaut;
		}

		public function setNb_charg_fusil_assaut($nb_charg_fusil_assaut){
			$this->nb_charg_fusil_assaut = $nb_charg_fusil_assaut;
		}
		
		public function getNb_charg_fusil_precis(){
			return $this->nb_charg_fusil_precis;
		}

		public function setNb_charg_fusil_precis($nb_charg_fusil_precis){
			$this->nb_charg_fusil_precis = $nb_charg_fusil_precis;
		}
		
		public function getNb_charg_mitrailleuse(){
			return $this->nb_charg_mitrailleuse;
		}

		public function setNb_charg_mitrailleuse($nb_charg_mitrailleuse){
			$this->nb_charg_mitrailleuse = $nb_charg_mitrailleuse;
		}
		
		public function getNb_charg_arme_poing(){
			return $this->nb_charg_arme_poing;
		}

		public function setNb_charg_arme_poing($nb_charg_arme_poing){
			$this->nb_charg_arme_poing = $nb_charg_arme_poing;
		}
		
		public function getNb_charg_fusil_pompe(){
			return $this->nb_charg_fusil_pompe;
		}

		public function setNb_charg_fusil_pompe($nb_charg_fusil_pompe){
			$this->nb_charg_fusil_pompe = $nb_charg_fusil_pompe;
		}
		
		public function getNb_charg_mitraillette(){
			return $this->nb_charg_mitraillette;
		}

		public function setNb_charg_mitraillette($nb_charg_mitraillette){
			$this->nb_charg_mitraillette = $nb_charg_mitraillette;
		}
		
		public function getNb_fumigene(){
			return $this->nb_fumigene;
		}

		public function setNb_fumigene($nb_fumigene){
			$this->nb_fumigene = $nb_fumigene;
		}
		
		public function getNb_grenade_explo(){
			return $this->nb_grenade_explo;
		}

		public function setNb_grenade_explo($nb_grenade_explo){
			$this->nb_grenade_explo = $nb_grenade_explo;
		}
		
		public function getNb_grenade_para(){
			return $this->nb_grenade_para;
		}

		public function setNb_grenade_para($nb_grenade_para){
			$this->nb_grenade_para = $nb_grenade_para;
		}
		
		public function getNb_mortier(){
			return $this->nb_mortier;
		}

		public function setNb_mortier($nb_mortier){
			$this->nb_mortier = $nb_mortier;
		}
		
		public function getNb_lanc_miss_port(){
			return $this->nb_lanc_miss_port;
		}

		public function setNb_lanc_miss_port($nb_lanc_miss_port){
			$this->nb_lanc_miss_port = $nb_lanc_miss_port;
		}
		
		public function getNb_lanc_roq_antichar(){
			return $this->nb_lanc_roq_antichar;
		}

		public function setNb_lanc_roq_antichar($nb_lanc_roq_antichar){
			$this->nb_lanc_roq_antichar = $nb_lanc_roq_antichar;
		}
		
		public function getNb_miss_antiair_port(){
			return $this->nb_miss_antiair_port;
		}

		public function setNb_miss_antiair_port($nb_miss_antiair_port){
			$this->nb_miss_antiair_port = $nb_miss_antiair_port;
		}
		
		public function getNb_mitraill_12_7(){
			return $this->nb_mitraill_12_7;
		}

		public function setNb_mitraill_12_7($nb_mitraill_12_7){
			$this->nb_mitraill_12_7 = $nb_mitraill_12_7;
		}
		
		public function getNb_claymore(){
			return $this->nb_claymore;
		}

		public function setNb_claymore($nb_claymore){
			$this->nb_claymore = $nb_claymore;
		}
	}