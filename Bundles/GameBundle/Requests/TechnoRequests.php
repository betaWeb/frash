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

        /**
         * @param $joueur
         * @return array
         */
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

        /**
         * @param $nrech
         * @param $joueur
         * @param $time
         * @param $temps_fin
         */
        public function sqlInsertConstRech($nrech, $joueur, $time, $temps_fin){
            $req = new QueryBuilder();
            $ins = new Insert('construct_rech');
            $ins->setInsert([ 'rech', 'joueur', 'time', 'temps_fin' ]);
            $ins->setExecute([ $nrech, $joueur, $time, $temps_fin ]);
            $req->insert($ins->getRequest(), $ins->getExecute());
        }

        /**
         * @param $name
         * @param $joueur
         */
        public function sqlUpdateRechTable($name, $joueur){
            $req = new QueryBuilder();
            $upd = new Update('recherche');
            $wh = new Where;
            $upd->setUpdate([ $name ]);
            $wh->initNormalWhere('joueur', '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ 1, $joueur ]);
            $req->update($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $monn
         * @param $ura
         * @param $acier
         * @param $comp
         * @param $terri
         */
        public function sqlUpdTerriMUAC($monn, $ura, $acier, $comp, $terri){
            $req = new QueryBuilder();
            $upd = new Update('territoire');
            $wh = new Where;
            $upd->setUpdate([ 'nombre_monnaie', 'nombre_uranium', 'nombre_acier', 'nombre_composant' ]);
            $wh->initNormalWhere('id', '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $monn, $ura, $acier, $comp, $terri ]);
            $req->update($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $monn
         * @param $ura
         * @param $acier
         * @param $petr
         * @param $comp
         * @param $terri
         */
        public function sqlUpdTerriMUAPC($monn, $ura, $acier, $petr, $comp, $terri){
            $req = new QueryBuilder();
            $upd = new Update('territoire');
            $wh = new Where;
            $upd->setUpdate([ 'nombre_monnaie', 'nombre_uranium', 'nombre_acier', 'nombre_petrole', 'nombre_composant' ]);
            $wh->initNormalWhere('id', '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $monn, $ura, $acier, $petr, $comp, $terri ]);
            $req->update($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $monn
         * @param $acier
         * @param $petr
         * @param $comp
         * @param $terri
         */
        public function sqlUpdTerriMAPC($monn, $acier, $petr, $comp, $terri){
            $req = new QueryBuilder();
            $upd = new Update('territoire');
            $wh = new Where;
            $upd->setUpdate([ 'nombre_monnaie', 'nombre_acier', 'nombre_petrole', 'nombre_composant' ]);
            $wh->initNormalWhere('id', '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $monn, $acier, $petr, $comp, $terri ]);
            $req->update($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $monn
         * @param $acier
         * @param $terri
         */
        public function sqlUpdTerriMA($monn, $acier, $terri){
            $req = new QueryBuilder();
            $upd = new Update('territoire');
            $wh = new Where;
            $upd->setUpdate([ 'nombre_monnaie', 'nombre_acier' ]);
            $wh->initNormalWhere('id', '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $monn, $acier, $terri ]);
            $req->update($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $monn
         * @param $acier
         * @param $comp
         * @param $terri
         */
        public function sqlUpdTerriMAC($monn, $acier, $comp, $terri){
            $req = new QueryBuilder();
            $upd = new Update('territoire');
            $wh = new Where;
            $upd->setUpdate([ 'nombre_monnaie', 'nombre_acier', 'nombre_composant' ]);
            $wh->initNormalWhere('id', '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $monn, $acier, $comp, $terri ]);
            $req->update($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $monn
         * @param $comp
         * @param $terri
         */
        public function sqlUpdTerriMC($monn, $comp, $terri){
            $req = new QueryBuilder();
            $upd = new Update('territoire');
            $wh = new Where;
            $upd->setUpdate([ 'nombre_monnaie', 'nombre_composant' ]);
            $wh->initNormalWhere('id', '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $monn, $comp, $terri ]);
            $req->update($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $user
         * @param $point
         */
        public function sqlUpdatePointUser($user, $point){
            $req = new QueryBuilder();
            $upd = new Update('user');
            $wh = new Where;
            $upd->setUpdate([ 'point' ]);
            $wh->initNormalWhere('id', '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $point, $user ]);
            $req->update($upd->getRequest(), $upd->getExecute());
        }
    }