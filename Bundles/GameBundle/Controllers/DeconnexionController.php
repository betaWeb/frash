<?php
    namespace Bundles\GameBundle\Controllers;
    use Composants\Framework\Response\Redirect;

    /**
     * Class DeconnexionController
     * @package Controllers
     */
    class DeconnexionController{
        /**
         * @return Redirect
         */
        public function deconnexionAction(){
            session_unset();
            session_destroy();

            return new Redirect('../accueil/');
        }
    }