<?php
	namespace Bundles\GameBundle\Requests;
    use Composants\Framework\ORM\MySQL\QueryBuilder;
    use Composants\Framework\ORM\MySQL\Request\Order;
    use Composants\Framework\ORM\MySQL\Request\Select;
    use Composants\Framework\ORM\MySQL\Request\Where;
    use Composants\Framework\ORM\MySQL\Request\Limit;

    /**
     * Class GameRequests
     * @package Bundles\GameBundle\Requests
     */
	class GameRequests{
        /**
         * @return array
         */
		public function sqlGetListNews(){
            $req = new QueryBuilder();
            $sel = new Select('topic');
            $wh = new Where;
            $ord = new Order('time_creation', 'DESC');
            $wh->initNormalWhere('cat', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setOrder($ord->getOrder());
            $sel->setExecute([ 1 ]);
            $data = $req->select($sel->getRequest(), $sel->getExecute(), 'Topic', 'GameBundle');

            foreach($data as $v){
                return [ 'id' => $v->getId(), 'nom' => $v->getNom(), 'pseudo' => $v->getPseudo_auteur() ];
            }
        }

        /**
         * @return array
         */
        public function sqlGetClassement(){
            $data = [];
            $rang = 1;

            $req = new QueryBuilder();
            $sel = new Select('user');
            $lim = new Limit('0, 20');
            $ord = new Order('point', 'DESC');
            $sel->setOrder($ord->getOrder());
            $sel->setLimit($lim->getLimit());
            $sel->setExecute();
            $datat = $req->select($sel->getRequest(), $sel->getExecute(), 'User', 'GameBundle');

            $data = [];
            foreach($datat as $v){
                $data[] = [ 'rang' => $rang++, 'pseudo' => $v->getPseudo(), 'point' => number_format($v->getPoint(), 0, ',', ' ') ];
            }

            return $data;
        }
	}