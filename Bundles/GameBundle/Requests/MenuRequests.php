<?php
	namespace Bundles\GameBundle\Requests;
    use Composants\ORM\Request\Select;
    use Composants\ORM\Request\Where;
    use Composants\ORM\QueryBuilder;

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
            $wh->initNormalWhere([ 'id', ':id' ], '=');
            $wh->andWhere([ 'pseudo', ':pseudo' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $_SESSION['id'], $_SESSION['pseudo'] ]);
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\User');

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
            $wh->initNormalWhere([ 'destinataire', ':dest' ], '=');
            $wh->andWhere([ 'destinataire_id', ':dest_id' ], '=');
            $wh->andWhere([ 'nombre_vue', ':nb_vue' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ 'dest' => $_SESSION['pseudo'], 'dest_id' => $_SESSION['id'], 'nb_vue' => 0 ]);
            $count = $req->countResult($sel->getRequest(), $sel->getExecute());

            return $count;
        }

        /**
         * @return array
         */
        public function sqlGetInfoTerri(){
            $req = new QueryBuilder();
            $sel = new Select('territoire');
            $wh = new Where;
            $wh->initNormalWhere([ 'id', ':id' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $_SESSION['terri'] ]);
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Territoire');

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
                    'terri_p' => $v->getTerri_principal(),
                    'pos_x' => $v->getPosition_x(), 'pos_y' => $v->getPosition_y()
                ];
            }
        }
	}