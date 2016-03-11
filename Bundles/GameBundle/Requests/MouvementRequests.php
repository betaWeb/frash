<?php
	namespace Bundles\GameBundle\Requests;
    use Composants\Framework\ORM\MySQL\QueryBuilder;
    use Composants\Framework\ORM\MySQL\Request\Select;
    use Composants\Framework\ORM\MySQL\Request\Where;

    /**
     * Class MouvementRequests
     * @package Bundles\GameBundle\Requests
     */
    class MouvementRequests{
        /**
         * @return array
         */
    	public function sqlGetInfoMouvPlayer(){
			$req = new QueryBuilder();
            $sel = new Select('mouvement');
            $wh = new Where;
            $wh->initNormalWhere('lanceur_id', '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $_SESSION['id'] ]);
            $data = $req->select($sel->getRequest(), $sel->getExecute(), 'Mouvement', 'GameBundle');

            $array = [];
            foreach($data as $v){
            	if($v->getType() == 1){ $type = 'Attaque'; }
				elseif($v->getType() == 2){ $type = 'Annexion'; }
				elseif($v->getType() == 3){ $type = 'Don'; }
				elseif($v->getType() == 4){ $type = 'Espionnage'; }
				elseif($v->getType() == 5){ $type = 'Transport'; }
				elseif($v->getType() == 6){ $type = 'Retour'; }
				elseif($v->getType() == 7){ $type = 'Opération spéciale'; }
				elseif($v->getType() == 8){ $type = 'Reconnaissance et surveillance'; }
				elseif($v->getType() == 9){ $type = 'Déplacement'; }
				else{ $type = 'Inconnu'; }

            	$array[] = [ 'joueur_cible' => $v->getCible(), 'pos_cible' => $v->getPosition_cible(), 'vt' => $v->getTemps_fin() - time(), 'type' => $type, 'id' => $v->getId() ];
            }

            return $array;
		}

        /**
         * @return array
         */
		public function sqlGetInfoMouvOther(){
			$req = new QueryBuilder();
            $sel = new Select('mouvement');
            $wh = new Where;
            $wh->initNormalWhere('cible_id', '=');
            $wh->andWhere('type', '!=');
            $wh->andWhere('type', '!=');
            $wh->andWhere('type', '!=');
            $wh->andWhere('type', '!=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $_SESSION['id'], 4, 6, 7, 8 ]);
            $data = $req->select($sel->getRequest(), $sel->getExecute(), 'Mouvement', 'GameBundle');

            $array = [];
            foreach($data as $v){
	            if($v->getType() == 1){ $type = 'Attaque'; }
				elseif($v->getType() == 2){ $type = 'Annexion'; }
				elseif($v->getType() == 3){ $type = 'Don'; }
				elseif($v->getType() == 5){ $type = 'Transport'; }
				elseif($v->getType() == 9){ $type = 'Déplacement'; }
				else{ $type = 'Autre'; }

	        	$array[] = [ 'assaillant' => $v->getLanceur(), 'pos_cible' => $v->getPosition_cible(), 'vt' => $v->getTemps_fin() - time(), 'type' => $type ];
	        }

	        return $array;
		}
    }