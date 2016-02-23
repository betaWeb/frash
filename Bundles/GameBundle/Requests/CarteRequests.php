<?php
	namespace Bundles\GameBundle\Requests;
    use Composants\ORM\Request\Select;
    use Composants\ORM\Request\Where;
    use Composants\ORM\Request\QueryBuilder;

	class CarteRequests{
		public function sqlGetLineX($pos_x, $pos_y_min, $pos_y_max){
            $req = new QueryBuilder();
            $sel = new Select('carte');
            $wh = new Where;
            $wh->initNormalWhere([ 'position_x', ':pos_x' ], '=');
            $wh->andWhere([ 'position_y', ':pos_y_min' ], '>');
            $wh->andWhere([ 'position_y', ':pos_y_max' ], '<');
            $sel->setWhere($wh->getWhere());
            $sel->setArrayWhere($wh->getArrayWhere());
            $sel->setExecute([ $pos_x, $pos_y_min, $pos_y_max ]);
            echo '<pre>';
                print_r($sel->getExecute());
            echo '</pre>';
            $sel->requestSelect();
            return $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Carte');
        }
	}