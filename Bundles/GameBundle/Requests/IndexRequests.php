<?php
    namespace Bundles\GameBundle\Requests;
    use Composants\Framework\ORM\MySQL\QueryBuilder;
    use Composants\Framework\ORM\MySQL\Request\Select;
    use Composants\Framework\ORM\MySQL\Request\Where;
    use Composants\Framework\ORM\MySQL\Request\Order;

    /**
     * Class IndexRequests
     * @package Bundles\GameBundle\Requests
     */
    class IndexRequests{
        /**
         * @return mixed
         */
        public function getSqlRandPositon(){
            $req = new QueryBuilder();
            $sel = new Select('territoire');
            $ord = new Order('RAND()');
            $sel->setOrder($ord->getOrder());
            $sel->setExecute();
            return $req->select($sel->getRequest(), $sel->getExecute(), 'Territoire', 'GameBundle');
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
            $wh->initNormalWhere('position_x', '=');
            $wh->andWhere('position_y', '>');
            $wh->andWhere('position_y', '<');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $pos_x, $y_min, $y_max ]);
            return $req->select($sel->getRequest(), $sel->getExecute(), 'Carte', 'GameBundle');
        }
    }