<?php
	namespace Bundles\GameBundle\Requests;
    use Composants\ORM\QueryBuilder;
    use Composants\ORM\Request\Order;
    use Composants\ORM\Request\Select;
    use Composants\ORM\Request\Where;
    use Composants\ORM\Request\Limit;

	class GameRequests{
		public function sqlGetListNews(){
            $req = new QueryBuilder();
            $sel = new Select('topic');
            $wh = new Where;
            $ord = new Order('time_creation', 'DESC');
            $wh->initNormalWhere([ 'cat', ':cat' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setOrder($ord->getOrder());
            $sel->setExecute([ 1 ]);
            $sel->requestSelect();
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Topic');

            foreach($data as $v){
                return [ 'id' => $v->getId(), 'nom' => $v->getNom(), 'pseudo' => $v->getPseudo_auteur() ];
            }
        }

        public function sqlGetClassement(){
            $data = [];
            $rang = 1;

            $req = new QueryBuilder();
            $sel = new Select('user');
            $lim = new Limit(20);
            $ord = new Order('point', 'DESC');
            $sel->setOrder($ord->getOrder());
            $sel->setLimit($lim->getLimit());
            $sel->setExecute();
            $sel->requestSelect();
            $datat = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\User');

            foreach($datat as $v){
                $data[] = [ 'rang' => $rang++, 'pseudo' => $v->getPseudo(), 'point' => number_format($v->getPoint(), 0, ',', ' ') ];
            }

            return $data;
        }
	}