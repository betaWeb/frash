<?php
    namespace Bundles\GameBundle\Controllers;
    use Composants\Framework\Response\Redirect;
    use Bundles\GameBundle\Requests\ConnexionRequests;

    /**
     * Class ConnexionController
     * @package Bundles\GameBundle\Controllers
     */
    class ConnexionController{
        /**
         * @return Redirect
         */
        public function connexionAction(){
            if(isset($_POST['submit']) && strlen($_POST['pseudo']) <= 40){
                $pseudo = htmlentities($_POST['pseudo']);
                $password = sha1($_POST['password']);

                $c = new ConnexionRequests;
                if($c->sqlVerifPassword($pseudo, $password) === true){
                    $user = $c->sqlGetInfoUser($pseudo, $password);

                    $_SESSION['id'] = $user['id'];
                    $_SESSION['pseudo'] = $user['pseudo'];
                    $_SESSION['terri'] = $c->sqlGetInfoTerri($pseudo);

                    return new Redirect('../game/');
                }
                else{
                    return new Redirect('../accueil/');
                }
            }
            else{
                return new Redirect('../accueil/');
            }
        }
    }