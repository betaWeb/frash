<?php
    namespace Bundles\GameBundle\Controllers;
    use Composants\Framework\Response\Response;
    use Bundles\GameBundle\Requests\MenuRequests;
    use Bundles\GameBundle\Requests\MouvementRequests;
    use Composants\ORM\Request\QueryBuilder;
    use Composants\ORM\Request\Select;
    use Composants\ORM\Request\Where;
    use Composants\ORM\Request\Order;

	class MouvementController{
		public function showMouvAction(){
            if(!isset($_SESSION['id']) || !isset($_SESSION['pseudo']) || !isset($_SESSION['terri'])){ return new Redirect('../accueil/'); }
            
            $met = new MenuRequests;
            $user = $met->sqlGetInfoUser();
            $terri = $met->sqlGetInfoTerri();

            $m = new MouvementRequests;

			return new Response('show_mouv.html', 'GameBundle', [
				'rang' => $user['rang'], 'nbmp' => $met->sqlCountMP(), 'nb_monnaie' => $terri['nb_monnaie'], 'nb_uranium' => $terri['nb_uranium'],
                'nb_acier' => $terri['nb_acier'], 'nb_petrole' => $terri['nb_petrole'], 'nb_composant' => $terri['nb_composant'], 'mouv_vous' => $m->sqlGetInfoMouvPlayer(), 
                'mouv_autre' => $m->sqlGetInfoMouvOther()
			]);
		}
	}