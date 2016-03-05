<?php
	namespace Bundles\GameBundle\Requests;
    use Composants\ORM\QueryBuilder;
    use Composants\ORM\Request\Select;
    use Composants\ORM\Request\Where;

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
            $wh->initNormalWhere([ 'lanceur_id', ':joueur' ], '=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $_SESSION['id'] ]);
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Mouvement');

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
            $wh->initNormalWhere([ 'cible_id', ':joueur' ], '=');
            $wh->andWhere([ 'type', ':type1' ], '!=');
            $wh->andWhere([ 'type', ':type2' ], '!=');
            $wh->andWhere([ 'type', ':type3' ], '!=');
            $wh->andWhere([ 'type', ':type4' ], '!=');
            $sel->setWhere($wh->getWhere(), $wh->getArrayWhere());
            $sel->setExecute([ $_SESSION['id'], 4, 6, 7, 8 ]);
            $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Mouvement');

            $array = [];
            foreach($data as $v){
	            if($m['type'] == 1){ $type = 'Attaque'; }
				elseif($m['type'] == 2){ $type = 'Annexion'; }
				elseif($m['type'] == 3){ $type = 'Don'; }
				elseif($m['type'] == 5){ $type = 'Transport'; }
				elseif($m['type'] == 9){ $type = 'Déplacement'; }
				else{ $type = 'Autre'; }

	        	$array[] = [ 'assaillant' => $v->getLanceur(), 'pos_cible' => $v->getPosition_cible(), 'vt' => $v->getTemps_fin() - time(), 'type' => $type ];
	        }

	        return $array;
		}
    }