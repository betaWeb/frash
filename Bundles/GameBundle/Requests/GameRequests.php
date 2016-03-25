<?php
	namespace Bundles\GameBundle\Requests;
    use Composants\Framework\ORM\MySQL\QueryBuilder;
    use Composants\Framework\ORM\MySQL\Request\Select;
    use Composants\Framework\ORM\MySQL\Request\Where;

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
            $wh->initNormalWhere('cat', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setOrder('time_creation DESC');
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
            $rang = 1;

            $req = new QueryBuilder();
            $sel = new Select('user');
            $sel->setOrder('point DESC');
            $sel->setLimit('0, 20');
            $sel->setExecute();
            $datat = $req->select($sel->getRequest(), $sel->getExecute(), 'User', 'GameBundle');

            $data = [];
            foreach($datat as $v){
                $data[] = [ 'rang' => $rang++, 'pseudo' => $v->getPseudo(), 'point' => number_format($v->getPoint(), 0, ',', ' ') ];
            }

            return $data;
        }
	}