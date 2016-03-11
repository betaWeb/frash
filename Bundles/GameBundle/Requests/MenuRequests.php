<?php
	namespace Bundles\GameBundle\Requests;
    use Composants\Framework\ORM\MySQL\Request\Select;
    use Composants\Framework\ORM\MySQL\Request\Where;
    use Composants\Framework\ORM\MySQL\QueryBuilder;

    /**
     * Class MenuRequests
     * @package Bundles\GameBundle\Requests
     */
	class MenuRequests{
		/**
         * @return array
         */
        public function sqlGetInfoUser(){
            $req = new QueryBuilder();
            $sel = new Select('user');
            $wh = new Where;
            $wh->initNormalWhere('id', '=');
            $wh->andWhere('pseudo', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $_SESSION['id'], $_SESSION['pseudo'] ]);
            $data = $req->select($sel->getRequest(), $sel->getExecute(), 'User', 'GameBundle');

            foreach($data as $v){
                return [
                    'rang' => $v->getRang(),
                    'point' => $v->getPoint()
                ];
            }
        }

        /**
         * @return mixed
         */
        public function sqlCountMP(){
            $req = new QueryBuilder();
            $sel = new Select('mp');
            $wh = new Where;
            $wh->initNormalWhere('destinataire', '=');
            $wh->andWhere('destinataire_id', '=');
            $wh->andWhere('nombre_vue', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $_SESSION['pseudo'], $_SESSION['id'], 0 ]);
            return $req->countResult($sel->getRequest(), $sel->getExecute());
        }

        /**
         * @return array
         */
        public function sqlGetInfoTerri(){
            $req = new QueryBuilder();
            $sel = new Select('territoire');
            $wh = new Where;
            $wh->initNormalWhere('id', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $_SESSION['terri'] ]);
            $data = $req->select($sel->getRequest(), $sel->getExecute(), 'Territoire', 'GameBundle');

            foreach($data as $v){
                return [
                    'nb_monnaie' => number_format($v->getNombre_monnaie(), 0, ',', ' '),
                    'nb_uranium' => number_format($v->getNombre_uranium(), 0, ',', ' '),
                    'nb_acier' => number_format($v->getNombre_acier(), 0, ',', ' '),
                    'nb_petrole' => number_format($v->getNombre_petrole(), 0, ',', ' '),
                    'nb_composant' => number_format($v->getNombre_composant(), 0, ',', ' '),
                    'dep_monnaie' => $v->getNombre_monnaie(),
                    'dep_uranium' => $v->getNombre_uranium(),
                    'dep_acier' => $v->getNombre_acier(),
                    'dep_petrole' => $v->getNombre_petrole(),
                    'dep_composant' => $v->getNombre_composant(),
                    'terri_p' => $v->getTerri_principal(), 'pos_x' => $v->getPosition_x(), 'pos_y' => $v->getPosition_y()
                ];
            }
        }
	}