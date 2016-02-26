<?php
    namespace Bundles\GameBundle\Controllers;
    use Composants\Framework\Response\Response;
    use Bundles\GameBundle\Requests\MenuRequests;
    use Composants\Framework\Response\Redirect;

    /**
     * Class AideController
     * @package Controllers
     */
    class AideController{
        /**
         * @return Response
         */
        public function aideAction(){
            if(!isset($_SESSION['id']) || !isset($_SESSION['pseudo']) || !isset($_SESSION['terri'])){ return new Redirect('accueil'); }
            
            $met = new MenuRequests;
            $user = $met->sqlGetInfoUser();
            $terri = $met->sqlGetInfoTerri();

            return new Response('aide.html.twig', 'GameBundle', [
                'rang' => $user['rang'], 'nbmp' => $met->sqlCountMP(), 'nb_monnaie' => $terri['nb_monnaie'], 'nb_uranium' => $terri['nb_uranium'],
                'nb_acier' => $terri['nb_acier'], 'nb_petrole' => $terri['nb_petrole'], 'nb_composant' => $terri['nb_composant']
            ]);
        }
    }