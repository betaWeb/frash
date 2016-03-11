<?php
    namespace Bundles\GameBundle\Controllers;
    use Composants\Framework\Response\Response;
    use Composants\Framework\Response\Redirect;
    use Bundles\GameBundle\Requests\MenuRequests;
    use Bundles\GameBundle\Requests\TechnoRequests;
    use Composants\Framework\Utility\Forms\CreateForm;
    use Composants\Framework\Response\ClassUrl;

    /**
     * Class TechnoController
     * @package Bundles\GameBundle\Controllers
     */
    class TechnoController{
        public function technoAction(){
            if(!isset($_SESSION['id']) || !isset($_SESSION['pseudo']) || !isset($_SESSION['terri'])){ return new Redirect('../accueil/'); }

            $tr = new TechnoRequests;
            $met = new MenuRequests;
            $user = $met->sqlGetInfoUser();
            $terri = $met->sqlGetInfoTerri();

            if($tr->sqlCountRech($_SESSION['id']) == 1){
                $constr = $tr->sqlConstructRech($_SESSION['id']);

                $nom = '';
                $phrase = '';
                if($constr['rech'] == 1){ $nom = 'Maniement de l\'uranium'; }
                elseif($constr['rech'] == 2){ $nom = 'Unités navales'; }
                elseif($constr['rech'] == 3){ $nom = 'Voilures tournantes'; }
                elseif($constr['rech'] == 4){ $nom = 'Bouclier de tourelle'; }
                elseif($constr['rech'] == 5){ $nom = 'Furtivité'; }
                elseif($constr['rech'] == 6){ $nom = 'Grille anti-roquettes'; }
                elseif($constr['rech'] == 7){ $nom = 'Mitrailleuse télé-opérée'; }
                elseif($constr['rech'] == 8){ $nom = 'Système de tir déporté'; }
                elseif($constr['rech'] == 9){ $nom = 'Canon électromagnétique'; }
                elseif($constr['rech'] == 10){ $nom = 'Aéronavale'; }
                elseif($constr['rech'] == 11){ $nom = 'Radar AESA'; }
                else{ $nom = 'Undefined'; }

                $tr = $constr['temps_fin'] - time();
                if($tr <= 0){ $phrase = '<ul><li>'.$nom.'</li><li>Temps restant : 0 seconde, actualisation dans la minute.</li></ul>'; }
                else{ $phrase = '<ul><li>'.$nom.', temps restant : <span id="time">'.$tr.'</span> secondes.</li></ul>'; }

                return new Response('Technos/techno_construct.html.twig', 'GameBundle', [
                    'rang' => $user['rang'], 'nbmp' => $met->sqlCountMP(), 'nb_monnaie' => $terri['nb_monnaie'], 'nb_uranium' => $terri['nb_uranium'],
                    'nb_acier' => $terri['nb_acier'], 'nb_petrole' => $terri['nb_petrole'], 'nb_composant' => $terri['nb_composant'], 'phrase' => $phrase
                ]);
            }
            else{
                $form = new CreateForm;
                $curl = new ClassUrl;

                return new Response('Technos/techno_selection.html.twig', 'GameBundle', [
                    'rang' => $user['rang'], 'nbmp' => $met->sqlCountMP(), 'nb_monnaie' => $terri['nb_monnaie'], 'nb_uranium' => $terri['nb_uranium'],
                    'nb_acier' => $terri['nb_acier'], 'nb_petrole' => $terri['nb_petrole'], 'nb_composant' => $terri['nb_composant'],
                    'lvlcr' => $tr->sqlGetLevelCenterRech($_SESSION['terri']), 'lvlus' => $tr->sqlGetLevelUsine($_SESSION['terri']), 'rech' => $tr->sqlGetLevelsRech($_SESSION['id']),
                    'form' => [
                        'start' => $form->startForm([ 'method' => 'post', 'action' => $curl->getUrlForm('technoConf/') ]),
                        'submit' => $form->addInput([ 'name' => 'submit', 'type' => 'submit', 'value' => 'Construire' ]),
                        'end' => $form->endForm()
                    ]
                ]);
            }
        }
    }