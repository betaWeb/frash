<?php
    namespace Bundles\GameBundle\Requests;
    use Composants\ORM\Request\Select;
    use Composants\ORM\Request\Where;
    use Composants\ORM\QueryBuilder;

    /**
     * Class ConnexionRequests
     * @package Bundles\GameBundle\Requests
     */
    class ConnexionRequests{
        /**
         * @param $pseudo
         * @param $password
         * @return bool
         */
        public function sqlVerifPassword($pseudo, $password){
            $req = new QueryBuilder();
            $sel = new Select('user');
            $wh = new Where;
            $wh->initNormalWhere([ 'pseudo', ':pseudo' ], '=');
            $wh->andWhere([ 'password', ':mdp' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ 'pseudo' => $pseudo, 'mdp' => $password ]);
            $count = $req->countResult($sel->getRequest(), $sel->getExecute());

            if($count == 1){
                return true;
            }
            else{
                return false;
            }
        }

        /**
         * @param $pseudo
         * @param $password
         * @return array
         */
        public function sqlGetInfoUser($pseudo, $password){
            $req = new QueryBuilder();
            $sel = new Select('user');
            $wh = new Where;
            $wh->initNormalWhere([ 'pseudo', ':pseudo' ], '=');
            $wh->andWhere([ 'password', ':mdp' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $pseudo, $password ]);
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\User');

            foreach($data as $v){
                return [ 'id' => $v->getId(), 'pseudo' => $v->getPseudo() ];
            }
        }

        /**
         * @param $pseudo
         * @return mixed
         */
        public function sqlGetInfoTerri($pseudo){
            $req = new QueryBuilder();
            $sel = new Select('territoire');
            $wh = new Where;
            $wh->initNormalWhere([ 'joueur', ':pseudo' ], '=');
            $wh->andWhere([ 'terri_principal', ':tp' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $pseudo, 1 ]);
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Territoire');

            foreach($data as $v){
                return $v->getId();
            }
        }
    }

