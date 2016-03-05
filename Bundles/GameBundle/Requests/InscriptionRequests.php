<?php
	namespace Bundles\GameBundle\Requests;
    use Composants\ORM\QueryBuilder;
    use Composants\ORM\Request\Select;
    use Composants\ORM\Request\Where;
    use Composants\ORM\Request\Order;
    use Composants\ORM\Request\Update;
    use Composants\ORM\Request\Insert;

    /**
     * Class InscriptionRequests
     * @package Bundles\GameBundle\Requests
     */
    class InscriptionRequests{
        /**
         * @param $pseudo
         * @return mixed
         */
    	public function sqlCountPseudo($pseudo){
            $req = new QueryBuilder();
            $sel = new Select('user');
            $wh = new Where;
            $wh->initNormalWhere([ 'pseudo', ':pseudo' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ 'pseudo' => $pseudo ]);
            return $req->countResult($sel->getRequest(), $sel->getExecute());
        }

        /**
         * @param $mail
         * @return mixed
         */
        public function sqlCountMail($mail){
            $req = new QueryBuilder();
            $sel = new Select('user');
            $wh = new Where;
            $wh->initNormalWhere([ 'mail', ':mail' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ 'mail' => $mail ]);
            return $req->countResult($sel->getRequest(), $sel->getExecute());
        }

        /**
         * @param $pos_x
         * @param $pos_y
         * @return mixed
         */
        public function sqlCountTerri($pos_x, $pos_y){
            $req = new QueryBuilder();
            $sel = new Select('territoire');
            $wh = new Where;
            $wh->initNormalWhere([ 'position_x', ':pos_x' ], '=');
            $wh->andWhere([ 'position_y', ':pos_y' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ 'pos_x' => $pos_x, 'pos_y' => $pos_y ]);
            return $req->countResult($sel->getRequest(), $sel->getExecute());
        }

        /**
         * @param $pseudo
         * @param $mdp
         * @param $mail
         */
        public function sqlInsertUser($pseudo, $mdp, $mail){
            $req = new QueryBuilder();
            $ins = new Insert('user');
            $ins->setInsert([ 'pseudo', 'password', 'mail', 'inscription', 'connexion' ]);
            $ins->setExecute([ $pseudo, $mdp, $mail, time(), time() ]);
            $req->execRequest($ins->getRequest(), $ins->getExecute());
        }

        /**
         * @param $pseudo
         * @return mixed
         */
        public function sqlGetIdInsertUser($pseudo){
            $req = new QueryBuilder();
            $sel = new Select('user');
            $wh = new Where;
            $wh->initNormalWhere([ 'pseudo', ':pseudo' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $pseudo ]);
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\User');

            foreach($data as $v){
                return $v->getId();
            }
        }

        /**
         * @param $id_user
         * @param $pseudo
         * @param $pos_x
         * @param $pos_y
         */
        public function sqlInsertTerri($id_user, $pseudo, $pos_x, $pos_y){
            $req = new QueryBuilder();
            $ins = new Insert('territoire');
            $ins->setInsert([ 'joueur_id', 'joueur', 'position_x', 'position_y', 'terri_principal' ]);
            $ins->setExecute([ $id_user, $pseudo, $pos_x, $pos_y, 1 ]);
            $req->execRequest($ins->getRequest(), $ins->getExecute());
        }

        /**
         * @param $pseudo
         * @return mixed
         */
        public function sqlGetIdInsertTerri($pseudo){
            $req = new QueryBuilder();
            $sel = new Select('territoire');
            $wh = new Where;
            $ord = new Order('id', 'DESC');
            $wh->initNormalWhere([ 'joueur', ':joueur' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setOrder($ord->getOrder());
            $sel->setExecute([ $pseudo ]);
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Territoire');

            foreach($data as $v){
                return $v->getId();
            }
        }

        /**
         * @param $id_terri
         * @param $id_user
         * @param $pseudo
         * @param $pos_x
         * @param $pos_y
         */
        public function sqlUpdateCarte($id_terri, $id_user, $pseudo, $pos_x, $pos_y){
            $req = new QueryBuilder();
            $upd = new Update('carte');
            $wh = new Where;
            $upd->setUpdate([ 'territoire = :terri', 'joueur_id = :jid', 'joueur = :joueur' ]);
            $wh->initNormalWhere([ 'position_x', ':pos_x' ], '=');
            $wh->andWhere([ 'position_y', ':pos_y' ], '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $id_terri, $id_user, $pseudo, $pos_x, $pos_y ]);
            $upd->requestUpdate();
            $req->execRequest($upd->getRequest(), $upd->getExecute());
        }

        /**
         * @param $bat
         * @param $id_user
         * @param $id_terri
         */
        public function sqlForeachBat($bat, $id_user, $id_terri){
            $req = new QueryBuilder();
            $ins = new Insert($bat);
            $ins->setInsert([ 'joueur', 'territoire' ]);
            $ins->setExecute([ $id_user, $id_terri ]);
            $req->execRequest($ins->getRequest(), $ins->getExecute());
        }

        /**
         * @param $id_user
         */
        public function sqlInsertRech($id_user){
            $req = new QueryBuilder();
            $ins = new Insert('recherche');
            $ins->setInsert([ 'joueur' ]);
            $ins->setExecute([ $id_user ]);
            $req->execRequest($ins->getRequest(), $ins->getExecute());
        }
    }