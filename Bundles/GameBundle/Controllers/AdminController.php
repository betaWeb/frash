<?php
    namespace Bundles\GameBundle\Controllers;
    use Composants\Framework\Response\Response;
    use Composants\ORM\Request\QueryBuilder;
    use Bundles\GameBundle\Requests\MenuRequests;

    /**
     * Class AdminController
     * @package Controllers
     */
    class AdminController{
        /**
         * @return Response
         */
        public function adminAction(){
            if(!isset($_SESSION['id']) || !isset($_SESSION['pseudo']) || !isset($_SESSION['terri'])){ return new Redirect('../accueil/'); }
            
            $req = new QueryBuilder();
            $data = $req->findAll('contact', 'GameBundle');

            $met = new MenuRequests;
            $user = $met->sqlGetInfoUser();
            $terri = $met->sqlGetInfoTerri();

            return new Response('admin.html', 'GameBundle', [ 
                'data' => $data, 'rang' => $user['rang'], 'nbmp' => $met->sqlCountMP(), 'nb_monnaie' => $terri['nb_monnaie'], 'nb_uranium' => $terri['nb_uranium'],
                'nb_acier' => $terri['nb_acier'], 'nb_petrole' => $terri['nb_petrole'], 'nb_composant' => $terri['nb_composant']
            ]);
        }
    }