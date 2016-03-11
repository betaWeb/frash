<?php
    namespace Bundles\GameBundle\Requests;
    use Composants\Framework\ORM\MySQL\Request\Select;
    use Composants\Framework\ORM\MySQL\Request\Where;
    use Composants\Framework\ORM\MySQL\QueryBuilder;

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
            $wh->initNormalWhere('pseudo', '=');
            $wh->andWhere('password', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $pseudo, $password ]);

            if($req->countResult($sel->getRequest(), $sel->getExecute()) == 1){
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
            $wh->initNormalWhere('pseudo', '=');
            $wh->andWhere('password', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $pseudo, $password ]);
            $data = $req->select($sel->getRequest(), $sel->getExecute(), 'User', 'GameBundle');

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
            $wh->initNormalWhere('joueur', '=');
            $wh->andWhere('terri_principal', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $pseudo, 1 ]);
            $data = $req->select($sel->getRequest(), $sel->getExecute(), 'Territoire', 'GameBundle');

            foreach($data as $v){
                return $v->getId();
            }
        }
    }

