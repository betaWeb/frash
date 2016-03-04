<?php
    namespace Bundles\GameBundle\Controllers;
    use Composants\Framework\Response\Response;
    use Composants\Framework\Response\Redirect;
    use Bundles\GameBundle\Requests\MenuRequests;
    use Bundles\GameBundle\Requests\MouvementRequests;

    /**
     * Class MouvementController
     * @package Bundles\GameBundle\Controllers
     */
	class MouvementController{
        /**
         * @return Redirect|Response
         */
		public function showMouvAction(){
            if(!isset($_SESSION['id']) || !isset($_SESSION['pseudo']) || !isset($_SESSION['terri'])){ return new Redirect('../accueil/'); }
            
            $met = new MenuRequests;
            $user = $met->sqlGetInfoUser();
            $terri = $met->sqlGetInfoTerri();

            $m = new MouvementRequests;

			return new Response('show_mouv.html.twig', 'GameBundle', [
				'rang' => $user['rang'], 'nbmp' => $met->sqlCountMP(), 'nb_monnaie' => $terri['nb_monnaie'], 'nb_uranium' => $terri['nb_uranium'],
                'nb_acier' => $terri['nb_acier'], 'nb_petrole' => $terri['nb_petrole'], 'nb_composant' => $terri['nb_composant'], 'mouv_vous' => $m->sqlGetInfoMouvPlayer(), 
                'mouv_autre' => $m->sqlGetInfoMouvOther()
			]);
		}
	}