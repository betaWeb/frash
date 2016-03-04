<?php
    namespace Bundles\GameBundle\Requests;
    use Composants\ORM\Request\Select;
    use Composants\ORM\Request\Where;
    use Composants\ORM\QueryBuilder;

    /**
     * Class BatimentRequests
     * @package Bundles\GameBundle\Requests
     */
    class BatimentRequests{
        /**
         * @param $terri
         * @return mixed
         */
        public function sqlCountConstructBat($terri){
            $req = new QueryBuilder();
            $sel = new Select('construct_bat');
            $wh = new Where;
            $wh->initNormalWhere([ 'territoire', ':terri' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ 'terri' => $terri ]);
            $sel->requestSelect();
            return $req->countResult($sel->getRequest(), $sel->getExecute());
        }

        /**
         * @param $terri
         * @return array
         */
        public function sqlConstructBat($terri){
            $req = new QueryBuilder();
            $sel = new Select('construct_bat');
            $wh = new Where();
            $wh->initNormalWhere([ 'territoire', ':terri' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $terri ]);
            $sel->requestSelect();
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Construct_bat');

            foreach($data as $v){
                return [ 'bat' => $v->getBat(), 'temps_fin' => $v->getTemps_fin() ];
            }
        }

        /**
         * @param $table
         * @param $nom
         * @param $joueur
         * @param $terri
         * @return array
         */
        public function sqlGetInfoBat($table, $nom, $joueur, $terri){
            $req = new QueryBuilder();
            $sel = new Select($table);
            $wh = new Where();
            $wh->initNormalWhere([ 'joueur', ':joueur' ], '=');
            $wh->andWhere([ 'territoire', ':terri' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $joueur, $terri ]);
            $sel->requestSelect();
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\\'.ucfirst($table));

            foreach($data as $v){
                return [
                    'nom' => $nom,
                    'monnaie' => number_format($v->getCout_monnaie(), 0, ',', ' '),
                    'acier' => number_format($v->getCout_acier(), 0, ',', ' '),
                    'composant' => number_format($v->getCout_composant(), 0, ',', ' '),
                    'temps' => number_format($v->getTemps_construction(), 0, ',', ' '),
                    'name' => ltrim($table, 'bat_'),
                    'niveau' => $v->getNiveau()
                ];
            }
        }

        public function sqlGetRechJoueur($joueur){
            $req = new QueryBuilder();
            $sel = new Select('recherche');
            $wh = new Where();
            $wh->initNormalWhere([ 'joueur', ':joueur' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $joueur ]);
            $sel->requestSelect();
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Recherche');

            foreach($data as $v){
                return [
                    'uranium' => $v->getManiement_uranium(),
                    'unit_nav' => $v->getUnites_navales(),
                    'voil_tourn' => $v->getVoilure_tournante(),
                    'boucl_tourelle' => $v->getBouclier_tourelle(),
                    'mitr_teleop' => $v->getMitrailleuse_teleop(),
                    'grille_anti_roq' => $v->getGrille_anti_roq(),
                    'aeronavale' => $v->getAeronavale(),
                    'furtivite' => $v->getFurtivite(),
                    'canon_electro' => $v->getCanon_electro(),
                    'syst_tir_deporte' => $v->getSysteme_tir_deporte(),
                    'radar' => $v->getRadar_aesa(),
                    'drone' => $v->getDrone_hale(),
                    'vtol' => $v->getReacteur_vtol()
                ];
            }
        }
    }