<?php
	namespace Bundles\GameBundle\Requests;
    use Composants\Framework\ORM\MySQL\QueryBuilder;
    use Composants\Framework\ORM\MySQL\Request\Select;
    use Composants\Framework\ORM\MySQL\Request\Where;
    use Composants\Framework\ORM\MySQL\Request\Update;
    use Composants\Framework\ORM\MySQL\Request\Insert;

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
            $wh->initNormalWhere('pseudo', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $pseudo ]);
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
            $wh->initNormalWhere('mail', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $mail ]);
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
            $wh->initNormalWhere('position_x', '=');
            $wh->andWhere('position_y', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $pos_x, $pos_y ]);
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
            $req->insert($ins->getRequest(), $ins->getExecute());
        }

        /**
         * @param $pseudo
         * @return mixed
         */
        public function sqlGetIdInsertUser($pseudo){
            $req = new QueryBuilder();
            $sel = new Select('user');
            $wh = new Where;
            $wh->initNormalWhere('pseudo', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $pseudo ]);
            $data = $req->select($sel->getRequest(), $sel->getExecute(), 'User', 'GameBundle');

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
            $req->insert($ins->getRequest(), $ins->getExecute());
        }

        /**
         * @param $pseudo
         * @return mixed
         */
        public function sqlGetIdInsertTerri($pseudo){
            $req = new QueryBuilder();
            $sel = new Select('territoire');
            $wh = new Where;
            $wh->initNormalWhere('joueur', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setOrder('id DESC');
            $sel->setExecute([ $pseudo ]);
            $data = $req->select($sel->getRequest(), $sel->getExecute(), 'Territoire', 'GameBundle');

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
            $upd->setUpdate([ 'territoire', 'joueur_id', 'joueur' ]);
            $wh->initNormalWhere('position_x', '=');
            $wh->andWhere('position_y', '=');
            $upd->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $upd->setExecute([ $id_terri, $id_user, $pseudo, $pos_x, $pos_y ]);
            $req->update($upd->getRequest(), $upd->getExecute());
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
            $req->insert($ins->getRequest(), $ins->getExecute());
        }

        /**
         * @param $id_user
         */
        public function sqlInsertRech($id_user){
            $req = new QueryBuilder();
            $ins = new Insert('recherche');
            $ins->setInsert([ 'joueur' ]);
            $ins->setExecute([ $id_user ]);
            $req->insert($ins->getRequest(), $ins->getExecute());
        }
    }