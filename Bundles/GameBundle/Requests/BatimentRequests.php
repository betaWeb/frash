<?php
    namespace Bundles\GameBundle\Requests;
    use Composants\ORM\Request\Select;
    use Composants\ORM\Request\Where;
    use Composants\ORM\Request\Insert;
    use Composants\ORM\Request\Update;
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

        /**
         * @param $joueur
         * @return array
         */
        public function sqlGetRechJoueur($joueur){
            $req = new QueryBuilder();
            $sel = new Select('recherche');
            $wh = new Where();
            $wh->initNormalWhere([ 'joueur', ':joueur' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $joueur ]);
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Recherche');

            foreach($data as $v){
                return [
                    'uranium' => $v->getManiement_uranium(), 'unit_nav' => $v->getUnites_navales(), 'voil_tourn' => $v->getVoilure_tournante(),
                    'boucl_tourelle' => $v->getBouclier_tourelle(), 'mitr_teleop' => $v->getMitrailleuse_teleop(), 'grille_anti_roq' => $v->getGrille_anti_roq(),
                    'aeronavale' => $v->getAeronavale(), 'furtivite' => $v->getFurtivite(), 'canon_electro' => $v->getCanon_electro(),
                    'syst_tir_deporte' => $v->getSysteme_tir_deporte(), 'radar' => $v->getRadar_aesa(), 'drone' => $v->getDrone_hale(), 'vtol' => $v->getReacteur_vtol()
                ];
            }
        }

        /**
         * @param $table
         * @param $joueur
         * @param $terri
         * @return array
         */
        public function sqlGetInfoConfBat($table, $joueur, $terri){
            $req = new QueryBuilder();
            $sel = new Select($table);
            $wh = new Where();
            $wh->initNormalWhere([ 'joueur', ':joueur' ], '=');
            $wh->andWhere([ 'territoire', ':terri' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $joueur, $terri ]);
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\\'.ucfirst($table));

            foreach($data as $v){
                return [
                    'cout_monnaie' => number_format($v->getCout_monnaie(), 0, ',', ' '),
                    'cout_acier' => number_format($v->getCout_acier(), 0, ',', ' '),
                    'cout_composant' => number_format($v->getCout_composant(), 0, ',', ' '),
                    'temps_construction' => number_format($v->getTemps_construction(), 0, ',', ' '),
                    'niveau' => $v->getNiveau()
                ];
            }
        }

        /**
         * @param $bat
         * @param $temps_const
         * @param $temps_fin
         * @param $terri
         */
        public function sqlInsertConstructBat($bat, $temps_const, $temps_fin, $terri){
            $req = new QueryBuilder();
            $ins = new Insert('construct_bat');
            $ins->setInsert([ 'bat', 'time', 'temps_fin', 'territoire' ]);
            $ins->setExecute([ $bat, $temps_const, $temps_fin, $terri ]);
            $req->execRequest($ins->getRequest(), $ins->getExecute());
        }

        /**
         * @param $table
         * @param $cout_monn
         * @param $cout_acier
         * @param $cout_comp
         * @param $temps_construct
         * @param $niveau
         * @param $terri
         */
        public function sqlUpdateConstructBat($table, $cout_monn, $cout_acier, $cout_comp, $temps_construct, $niveau, $terri){
            $req = new QueryBuilder();
            $upd = new Update($table);
            $wh = new Where;
            $upd->setUpdate([ 'niveau = :niveau', 'cout_monnaie = :monn', 'cout_acier = :acier', 'cout_composant = :comp', 'temps_construction = :time' ]);
            $wh->initNormalWhere([ 'territoire', ':terri' ], '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $niveau, $cout_monn, $cout_acier, $cout_comp, $temps_construct, $terri ]);
            $upd->requestUpdate();
            $req->execRequest($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $new_nb_monnaie
         * @param $new_nb_acier
         * @param $new_nb_comp
         * @param $new_prod
         * @param $terri
         */
        public function sqlUpdateTerriConstBatWithProdMonnaie($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $new_prod, $terri){
            $req = new QueryBuilder();
            $upd = new Update('territoire');
            $wh = new Where;
            $upd->setUpdate([ 'nombre_monnaie = :monn', 'nombre_acier = :acier', 'nombre_composant = :comp', 'prod_monnaie = :prod' ]);
            $wh->initNormalWhere([ 'territoire', ':terri' ], '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $new_nb_monnaie, $new_nb_acier, $new_nb_comp, $new_prod, $terri ]);
            $upd->requestUpdate();
            $req->execRequest($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $new_nb_monnaie
         * @param $new_nb_acier
         * @param $new_nb_comp
         * @param $new_prod
         * @param $terri
         */
        public function sqlUpdateTerriConstBatWithProdUranium($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $new_prod, $terri){
            $req = new QueryBuilder();
            $upd = new Update('territoire');
            $wh = new Where;
            $upd->setUpdate([ 'nombre_monnaie = :monn', 'nombre_acier = :acier', 'nombre_composant = :comp', 'prod_uranium = :prod' ]);
            $wh->initNormalWhere([ 'territoire', ':terri' ], '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $new_nb_monnaie, $new_nb_acier, $new_nb_comp, $new_prod, $terri ]);
            $upd->requestUpdate();
            $req->execRequest($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $new_nb_monnaie
         * @param $new_nb_acier
         * @param $new_nb_comp
         * @param $new_prod
         * @param $terri
         */
        public function sqlUpdateTerriConstBatWithProdAcier($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $new_prod, $terri){
            $req = new QueryBuilder();
            $upd = new Update('territoire');
            $wh = new Where;
            $upd->setUpdate([ 'nombre_monnaie = :monn', 'nombre_acier = :acier', 'nombre_composant = :comp', 'prod_acier = :prod' ]);
            $wh->initNormalWhere([ 'territoire', ':terri' ], '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $new_nb_monnaie, $new_nb_acier, $new_nb_comp, $new_prod, $terri ]);
            $upd->requestUpdate();
            $req->execRequest($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $new_nb_monnaie
         * @param $new_nb_acier
         * @param $new_nb_comp
         * @param $new_prod
         * @param $terri
         */
        public function sqlUpdateTerriConstBatWithProdPetrole($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $new_prod, $terri){
            $req = new QueryBuilder();
            $upd = new Update('territoire');
            $wh = new Where;
            $upd->setUpdate([ 'nombre_monnaie = :monn', 'nombre_acier = :acier', 'nombre_composant = :comp', 'prod_petrole = :prod' ]);
            $wh->initNormalWhere([ 'territoire', ':terri' ], '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $new_nb_monnaie, $new_nb_acier, $new_nb_comp, $new_prod, $terri ]);
            $upd->requestUpdate();
            $req->execRequest($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $new_nb_monnaie
         * @param $new_nb_acier
         * @param $new_nb_comp
         * @param $new_prod
         * @param $terri
         */
        public function sqlUpdateTerriConstBatWithProdComposant($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $new_prod, $terri){
            $req = new QueryBuilder();
            $upd = new Update('territoire');
            $wh = new Where;
            $upd->setUpdate([ 'nombre_monnaie = :monn', 'nombre_acier = :acier', 'nombre_composant = :comp', 'prod_composant = :prod' ]);
            $wh->initNormalWhere([ 'territoire', ':terri' ], '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $new_nb_monnaie, $new_nb_acier, $new_nb_comp, $new_prod, $terri ]);
            $upd->requestUpdate();
            $req->execRequest($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $new_nb_monnaie
         * @param $new_nb_acier
         * @param $new_nb_comp
         * @param $terri
         */
        public function sqlUpdateTerriConstBatNoProd($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $terri){
            $req = new QueryBuilder();
            $upd = new Update('territoire');
            $wh = new Where;
            $upd->setUpdate([ 'nombre_monnaie = :monn', 'nombre_acier = :acier', 'nombre_composant = :comp' ]);
            $wh->initNormalWhere([ 'territoire', ':terri' ], '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $new_nb_monnaie, $new_nb_acier, $new_nb_comp, $terri ]);
            $upd->requestUpdate();
            $req->execRequest($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $user
         * @param $point
         */
        public function sqlUpdatePointUser($user, $point){
            $req = new QueryBuilder();
            $upd = new Update('user');
            $wh = new Where;
            $upd->setUpdate([ 'point = :points' ]);
            $wh->initNormalWhere([ 'id', ':id' ], '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $point, $user ]);
            $upd->requestUpdate();
            $req->execRequest($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $terri
         * @return mixed
         */
        public function sqlCountConstArmee($terri){
            $req = new QueryBuilder();
            $sel = new Select('construct_unit');
            $wh = new Where;
            $wh->initNormalWhere([ 'territoire', ':terri' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ 'terri' => $terri ]);
            return $req->countResult($sel->getRequest(), $sel->getExecute());
        }

        /**
         * @param $terri
         * @param $time
         * @return array
         */
        public function sqlSelectConstArmee($terri, $time){
            $req = new QueryBuilder();
            $sel = new Select('construct_unit');
            $wh = new Where;
            $wh->initNormalWhere([ 'territoire', ':terri' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $terri ]);
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Construct_unit');

            foreach($data as $v){
                $this->sqlUpdConstArmee($terri, $v->getTemps_fin() + $time);
            }
        }

        /**
         * @param $terri
         * @param $time
         */
        public function sqlUpdConstArmee($terri, $time){
            $req = new QueryBuilder();
            $upd = new Update('construct_unit');
            $wh = new Where;
            $upd->setUpdate([ 'temps_fin = :time' ]);
            $wh->initNormalWhere([ 'territoire', ':terri' ], '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $time, $terri ]);
            $upd->requestUpdate();
            $req->execRequest($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $joueur
         * @param $x_min
         * @param $x_max
         * @param $y_min
         * @param $y_max
         */
        public function sqlInsertLevelRadar($joueur, $x_min, $x_max, $y_min, $y_max){
            $req = new QueryBuilder();
            $ins = new Insert('radar');
            $ins->setInsert([ 'joueur', 'type_radar', 'position_x_min', 'position_x_max', 'position_y_min', 'position_y_max' ]);
            $ins->setExecute([ $joueur, 1, $x_min, $x_max, $y_min, $y_max ]);
            $req->execRequest($ins->getRequest(), $ins->getExecute());
        }

        /**
         * @param $joueur
         */
        public function sqlSelectRadar($joueur){
            $req = new QueryBuilder();
            $sel = new Select('radar');
            $wh = new Where;
            $wh->initNormalWhere([ 'joueur', ':joueur' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $joueur ]);
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Radar');

            foreach($data as $v){
                $this->sqlUpdateLevelRadar($joueur, $v->Position_x_min() - 2, $v->Position_x_max() + 2, $v->Position_y_min() - 2, $v->Position_y_max() + 2);
            }
        }

        /**
         * @param $joueur
         * @param $x_min
         * @param $x_max
         * @param $y_min
         * @param $y_max
         */
        public function sqlUpdateLevelRadar($joueur, $x_min, $x_max, $y_min, $y_max){
            $req = new QueryBuilder();
            $upd = new Update('radar');
            $wh = new Where;
            $upd->setUpdate([ 'position_x_min = :x_min', 'position_x_max = :x_max', 'position_y_min = :y_min', 'position_y_max = :y_max' ]);
            $wh->initNormalWhere([ 'joueur', ':joueur' ], '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $x_min, $x_max, $y_min, $y_max, $joueur ]);
            $upd->requestUpdate();
            $req->execRequest($upd->getRequest(), $upd->getExecute());
        }
    }