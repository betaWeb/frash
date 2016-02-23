<?php
    namespace Bundles\GameBundle\Controllers;
    use Composants\Framework\Response\Response;
    use Bundles\GameBundle\Requests\MenuRequests;
    use Bundles\GameBundle\Requests\GameRequests;
    use Composants\Framework\Response\Redirect;

    /**
     * Class GameController
     * @package Controllers
     */
    class GameController{
        /**
         * @return Response
         */
        public function gameAction(){
            if(!isset($_SESSION['id']) || !isset($_SESSION['pseudo']) || !isset($_SESSION['terri'])){ return new Redirect('../accueil/'); }

            $met = new MenuRequests;
            $user = $met->sqlGetInfoUser();
            $terri = $met->sqlGetInfoTerri();

            $g = new GameRequests;

            return new Response('game.html.twig', 'GameBundle', [ 'rang' => $user['rang'], 'clmnt' => $g->sqlGetClassement(), 'nbmp' => $met->sqlCountMP(), 'nb_monnaie' => $terri['nb_monnaie'],
                'nb_uranium' => $terri['nb_uranium'], 'nb_acier' => $terri['nb_acier'], 'nb_petrole' => $terri['nb_petrole'], 'nb_composant' => $terri['nb_composant'], 'news' => $g->sqlGetListNews() ]);
        }
    }