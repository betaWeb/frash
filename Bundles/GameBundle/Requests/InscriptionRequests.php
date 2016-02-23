<?php
	namespace Bundles\GameBundle\Requests;
    use Composants\ORM\Request\QueryBuilder;
    use Composants\ORM\Request\Select;
    use Composants\ORM\Request\Where;
    use Composants\ORM\Request\Order;
    use Composants\ORM\Request\Update;
    use Composants\ORM\Request\Insert;

    class InscriptionRequests{
    	public function sqlCountPseudo($pseudo){
            $req = new QueryBuilder();
            $sel = new Select('user');
            $wh = new Where;
            $wh->initNormalWhere([ 'pseudo', ':pseudo' ], '=');
            $sel->setWhere($wh->getWhere());
            $sel->setArrayWhere($wh->getArrayWhere());
            $sel->setExecute([ 'pseudo' => $pseudo ]);
            $sel->requestSelect();
            return $req->countResult($sel->getRequest(), $sel->getExecute());
        }

        public function sqlCountMail($mail){
            $req = new QueryBuilder();
            $sel = new Select('user');
            $wh = new Where;
            $wh->initNormalWhere([ 'mail', ':mail' ], '=');
            $sel->setWhere($wh->getWhere());
            $sel->setArrayWhere($wh->getArrayWhere());
            $sel->setExecute([ 'mail' => $mail ]);
            $sel->requestSelect();
            return $req->countResult($sel->getRequest(), $sel->getExecute());
        }

        public function sqlCountTerri($pos_x, $pos_y){
            $req = new QueryBuilder();
            $sel = new Select('territoire');
            $wh = new Where;
            $wh->initNormalWhere([ 'position_x', ':pos_x' ], '=');
            $wh->andWhere([ 'position_y', ':pos_y' ], '=');
            $sel->setWhere($wh->getWhere());
            $sel->setArrayWhere($wh->getArrayWhere());
            $sel->setExecute([ 'pos_x' => $pos_x, 'pos_y' => $pos_y ]);
            $sel->requestSelect();
            return $req->countResult($sel->getRequest(), $sel->getExecute());
        }

        public function sqlInsertUser($pseudo, $mdp, $mail){
            $req = new QueryBuilder();
            $ins = new Insert('user');
            $ins->setInsert([ 'pseudo', 'password', 'mail', 'inscription' ]);
            $ins->setExecute([ $pseudo, $mdp, $mail, time() ]);
            $ins->requestInsert();
            $req->execRequest($ins->getRequest(), $ins->getExecute());
        }

        public function sqlGetIdInsertUser($pseudo){
            $req = new QueryBuilder();
            $sel = new Select('user');
            $wh = new Where;
            $wh->initNormalWhere([ 'pseudo', ':pseudo' ], '=');
            $sel->setWhere($wh->getWhere());
            $sel->setArrayWhere($wh->getArrayWhere());
            $sel->setExecute([ $pseudo ]);
            $sel->requestSelect();
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\User');

            foreach($data as $v){
                return $v->getId();
            }
        }

        public function sqlInsertTerri($id_user, $pseudo, $pos_x, $pos_y){
            $req = new QueryBuilder();
            $ins = new Insert('territoire');
            $ins->setInsert([ 'joueur_id', 'joueur', 'position_x', 'position_y', 'terri_principal' ]);
            $ins->setExecute([ $id_user, $pseudo, $pos_x, $pos_y, 1 ]);
            $ins->requestInsert();
            $req->execRequest($ins->getRequest(), $ins->getExecute());
        }

        public function sqlGetIdInsertTerri($pseudo){
            $req = new QueryBuilder();
            $sel = new Select('territoire');
            $wh = new Where;
            $ord = new Order('id', 'DESC');
            $wh->initNormalWhere([ 'joueur', ':joueur' ], '=');
            $sel->setWhere($wh->getWhere());
            $sel->setArrayWhere($wh->getArrayWhere());
            $sel->setOrder($ord->getOrder());
            $sel->setExecute([ $pseudo ]);
            $sel->requestSelect();
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Territoire');

            foreach($data as $v){
                return $v->getId();
            }
        }

        public function sqlUpdateCarte($id_terri, $id_user, $pseudo, $pos_x, $pos_y){
            $req = new QueryBuilder();
            $upd = new Update('carte');
            $wh = new Where;
            $upd->setUpdate([ 'territoire = :terri', 'joueur_id = :jid', 'joueur = :joueur' ]);
            $wh->initNormalWhere([ 'position_x', ':pos_x' ], '=');
            $wh->andWhere([ 'position_y', ':pos_y' ], '=');
            $upd->setWhere($wh->getWhere());
            $upd->setArrayWhere($wh->getArrayWhere());
            $upd->setExecute([ $id_terri, $id_user, $pseudo, $pos_x, $pos_y ]);
            $upd->requestUpdate();
            $req->execRequest($upd->getRequest(), $upd->getExecute());
        }

        public function sqlForeachBat($bat, $id_user, $id_terri){
            $req = new QueryBuilder();
            $ins = new Insert($bat);
            $ins->setInsert([ 'joueur', 'territoire' ]);
            $ins->setExecute([ $id_user, $id_terri ]);
            $ins->requestInsert();
            $req->execRequest($ins->getRequest(), $ins->getExecute());
        }

        public function sqlInsertRech($id_user){
            $req = new QueryBuilder();
            $ins = new Insert('recherche');
            $ins->setInsert([ 'joueur' ]);
            $ins->setExecute([ $id_user ]);
            $ins->requestInsert();
            $req->execRequest($ins->getRequest(), $ins->getExecute());
        }
    }