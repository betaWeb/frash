<?php
	namespace Bundles\GameBundle\Requests;
    use Composants\ORM\Request\Select;
    use Composants\ORM\Request\Where;
    use Composants\ORM\QueryBuilder;

    /**
     * Class CarteRequests
     * @package Bundles\GameBundle\Requests
     */
	class CarteRequests{
        /**
         * @param $pos_x
         * @param $pos_y_min
         * @param $pos_y_max
         * @return array
         */
		public function sqlGetLineX($pos_x, $pos_y_min, $pos_y_max){
            $req = new QueryBuilder();
            $sel = new Select('carte');
            $wh = new Where;
            $wh->initNormalWhere([ 'position_x', ':pos_x' ], '=');
            $wh->andWhere([ 'position_y', ':pos_y_min' ], '>');
            $wh->andWhere([ 'position_y', ':pos_y_max' ], '<');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $pos_x, $pos_y_min, $pos_y_max ]);
            $sel->requestSelect();
            return $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Carte');
        }

        /**
         * @param $terri
         * @return array
         */
        public function sqlGetPosTerri($terri){
            $req = new QueryBuilder();
            $sel = new Select('territoire');
            $wh = new Where();
            $wh->initNormalWhere([ 'id', ':id' ], '=');
            $sel->setExecute([ $terri ]);
            $sel->requestSelect();
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Territoire');

            foreach($data as $v){
                return [ 'x' => $v->getPosition_x(), 'y' => $v->getPosition_y() ];
            }
        }
	}