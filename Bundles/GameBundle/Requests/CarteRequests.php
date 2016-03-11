<?php
	namespace Bundles\GameBundle\Requests;
    use Composants\Framework\ORM\MySQL\Request\Select;
    use Composants\Framework\ORM\MySQL\Request\Where;
    use Composants\Framework\ORM\MySQL\QueryBuilder;

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
            $wh->initNormalWhere('position_x', '=');
            $wh->andWhere('position_y', '>');
            $wh->andWhere('position_y', '<');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $pos_x, $pos_y_min, $pos_y_max ]);
            return $req->select($sel->getRequest(), $sel->getExecute(), 'Carte', 'GameBundle');
        }

        /**
         * @param $terri
         * @return array
         */
        public function sqlGetPosTerri($terri){
            $req = new QueryBuilder();
            $sel = new Select('territoire');
            $wh = new Where();
            $wh->initNormalWhere('id', '=');
            $sel->setExecute([ $terri ]);
            $data = $req->select($sel->getRequest(), $sel->getExecute(), 'Territoire', 'GameBundle');

            foreach($data as $v){
                return [ 'x' => $v->getPosition_x(), 'y' => $v->getPosition_y() ];
            }
        }
	}