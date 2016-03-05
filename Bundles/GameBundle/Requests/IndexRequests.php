<?php
    namespace Bundles\GameBundle\Requests;
    use Composants\ORM\QueryBuilder;
    use Composants\ORM\Request\Select;
    use Composants\ORM\Request\Where;
    use Composants\ORM\Request\Order;

    /**
     * Class IndexRequests
     * @package Bundles\GameBundle\Requests
     */
    class IndexRequests{
        public function getSqlRandPositon(){
            $req = new QueryBuilder();
            $sel = new Select('territoire');
            $ord = new Order('RAND()');
            $sel->setOrder($ord->getOrder());
            $sel->setExecute();
            return $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Territoire');
        }

        /**
         * @param $pos_x
         * @param $y_min
         * @param $y_max
         * @return array
         */
        public function sqlGetPosXLine($pos_x, $y_min, $y_max){
            $req = new QueryBuilder();
            $sel = new Select('carte');
            $wh = new Where;
            $wh->initNormalWhere([ 'position_x', ':pos_x' ], '=');
            $wh->andWhere([ 'position_y', ':pos_y_min' ], '>');
            $wh->andWhere([ 'position_y', ':pos_y_max' ], '<');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $pos_x, $y_min, $y_max ]);
            return $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Carte');
        }
    }