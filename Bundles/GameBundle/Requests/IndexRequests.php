<?php
    namespace Bundles\GameBundle\Requests;
    use Composants\ORM\Request\QueryBuilder;
    use Composants\ORM\Request\Select;
    use Composants\ORM\Request\Where;
    use Composants\ORM\Request\Order;

    class IndexRequests{
        public function getSqlRandPositon(){
            $req = new QueryBuilder();
            $sel = new Select('territoire');
            $ord = new Order('RAND()');
            $sel->setOrder($ord->getOrder());
            $sel->setExecute();
            $sel->requestSelect();
            return $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Territoire');
        }

        public function sqlGetPosXLine($pos_x, $y_min, $y_max){
            $req = new QueryBuilder();
            $sel = new Select('carte');
            $wh = new Where;
            $wh->initNormalWhere([ 'position_x', ':pos_x' ], '=');
            $wh->andWhere([ 'position_y', ':pos_y_min' ], '>');
            $wh->andWhere([ 'position_y', ':pos_y_max' ], '<');
            $sel->setWhere($wh->getWhere());
            $sel->setArrayWhere($wh->getArrayWhere());
            $sel->setExecute([ $pos_x, $y_min, $y_max ]);
            $sel->requestSelect();
            return $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Carte');
        }
    }