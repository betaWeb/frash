<?php
    namespace Bundles\GameBundle\Controllers;
    use Composants\Framework\Response\Response;
    use Composants\Framework\Response\Redirect;
    use Composants\Framework\Forms\CreateForm;
    use Bundles\GameBundle\Requests\MenuRequests;
    use Bundles\GameBundle\Requests\ContactRequests;

    /**
     * Class ContactController
     * @package Controllers
     */
    class ContactController{
        /**
         * @return Response
         */
        public function contactAction(){
            if(!isset($_SESSION['id']) || !isset($_SESSION['pseudo']) || !isset($_SESSION['terri'])){ return new Redirect('../accueil/'); }
            
            $met = new MenuRequests;
            $user = $met->sqlGetInfoUser();
            $terri = $met->sqlGetInfoTerri();

            $form = new CreateForm;

            return new Response('contact.html', 'GameBundle', [
                'form' => [
                    'start' => $form->startForm([ 'method' => 'post', 'action' => '../confContact/' ]),
                    'textarea' => $form->addTextarea([ 'name' => 'texte', 'classcss' => 'textarea_contact' ]),
                    'submit' => $form->addInput([ 'name' => 'submit', 'type' => 'submit', 'value' => 'Envoyer' ]),
                    'end' => $form->endForm()
                ],
                'rang' => $user['rang'], 'nbmp' => $met->sqlCountMP(), 'nb_monnaie' => $terri['nb_monnaie'], 'nb_uranium' => $terri['nb_uranium'],
                'nb_acier' => $terri['nb_acier'], 'nb_petrole' => $terri['nb_petrole'], 'nb_composant' => $terri['nb_composant']
            ]);
        }

        /**
         * @return Redirect
         */
        public function confContactAction(){
            if(isset($_POST['submit'])){
                $c = new ContactRequests;
                $c->sqlInsertContact(htmlentities($_POST['texte']));
                return new Redirect('../game/');
            }
        }
    }