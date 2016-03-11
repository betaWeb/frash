<?php
    namespace Bundles\GameBundle\Requests;
    use Composants\Framework\ORM\MySQL\Request\Select;
    use Composants\Framework\ORM\MySQL\Request\Where;
    use Composants\Framework\ORM\MySQL\Request\Insert;
    use Composants\Framework\ORM\MySQL\Request\Update;
    use Composants\Framework\ORM\MySQL\QueryBuilder;

    /**
     * Class TechnoRequests
     * @package Bundles\GameBundle\Requests
     */
    class TechnoRequests{
        /**
         * @param $joueur
         * @return int
         */
        public function sqlCountRech($joueur){
            $req = new QueryBuilder();
            $sel = new Select('construct_rech');
            $wh = new Where;
            $wh->initNormalWhere('joueur', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $joueur ]);
            return $req->countResult($sel->getRequest(), $sel->getExecute());
        }

        /**
         * @param $joueur
         * @return array
         */
        public function sqlConstructRech($joueur){
            $req = new QueryBuilder();
            $sel = new Select('construct_rech');
            $wh = new Where();
            $wh->initNormalWhere('joueur', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $joueur ]);
            $data = $req->select($sel->getRequest(), $sel->getExecute(), 'Construct_rech', 'GameBundle');

            foreach($data as $v){
                return [ 'rech' => $v->getRech(), 'temps_fin' => $v->getTemps_fin() ];
            }
        }

        /**
         * @param $terri
         * @return int
         */
        public function sqlGetLevelCenterRech($terri){
            $req = new QueryBuilder();
            $sel = new Select('bat_centre_rech');
            $wh = new Where();
            $wh->initNormalWhere('territoire', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $terri ]);
            $data = $req->select($sel->getRequest(), $sel->getExecute(), 'Bat_centre_rech', 'GameBundle');

            foreach($data as $v){
                return $v->getNiveau();
            }
        }

        /**
         * @param $terri
         * @return int
         */
        public function sqlGetLevelUsine($terri){
            $req = new QueryBuilder();
            $sel = new Select('bat_usine');
            $wh = new Where();
            $wh->initNormalWhere('territoire', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $terri ]);
            $data = $req->select($sel->getRequest(), $sel->getExecute(), 'Bat_usine', 'GameBundle');

            foreach($data as $v){
                return $v->getNiveau();
            }
        }

        public function sqlGetLevelsRech($joueur){
            $req = new QueryBuilder();
            $sel = new Select('recherche');
            $wh = new Where();
            $wh->initNormalWhere('joueur', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $joueur ]);
            $data = $req->select($sel->getRequest(), $sel->getExecute(), 'Recherche', 'GameBundle');

            foreach($data as $v){
                return [
                    'ura' => $v->getManiement_uranium(), 'unit_nav' => $v->getUnites_navales(), 'voil_to' => $v->getVoilure_tournante(), 'boucl_tour' => $v->getBouclier_tourelle(),
                    'teleop' => $v->getMitrailleuse_teleop(), 'anti_roq' => $v->getGrille_anti_roq(), 'aeron' => $v->getAeronavale(), 'furt' => $v->getFurtivite(),
                    'canon' => $v->getCanon_electro(), 'syst_tir' => $v->getSysteme_tir_deporte(), 'aesa' => $v->getRadar_aesa(), 'dhale' => $v->getDrone_hale(), 'vtol' => $v->getReacteur_vtol()
                ];
            }
        }
    }