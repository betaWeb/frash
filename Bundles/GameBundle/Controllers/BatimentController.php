<?php
    namespace Bundles\GameBundle\Controllers;
    use Composants\Framework\Response\Response;
    use Composants\Framework\Response\Redirect;
    use Bundles\GameBundle\Requests\MenuRequests;
    use Bundles\GameBundle\Requests\BatimentRequests;
    use Composants\Framework\Forms\CreateForm;

    class BatimentController{
        public function batimentAction(){
            if(!isset($_SESSION['id']) || !isset($_SESSION['pseudo']) || !isset($_SESSION['terri'])){ return new Redirect('../accueil/'); }

            $br = new BatimentRequests;
            $met = new MenuRequests;
            $user = $met->sqlGetInfoUser();
            $terri = $met->sqlGetInfoTerri();

            if($br->sqlCountConstructBat($_SESSION['terri']) == 1){
                $constr = $br->sqlConstructBat($_SESSION['terri']);

                $nom = '';
                $phrase = '';
                if($constr['bat'] == 1){ $nom = 'Ministère de la défense'; }
                elseif($constr['bat'] == 2){ $nom = 'Etat-major de la Marine'; }
                elseif($constr['bat'] == 3){ $nom = 'Etat-major de l\'Armée de Terre'; }
                elseif($constr['bat'] == 4){ $nom = 'Etat-major de l\'Armée de l\'Air'; }
                elseif($constr['bat'] == 5){ $nom = 'Usine d\'extraction d\'uranium'; }
                elseif($constr['bat'] == 6){ $nom = 'Fonderie'; }
                elseif($constr['bat'] == 7){ $nom = 'Puit de pétrole'; }
                elseif($constr['bat'] == 8){ $nom = 'Usine'; }
                elseif($constr['bat'] == 10){ $nom = 'Radar'; }
                elseif($constr['bat'] == 11){ $nom = 'Centre de recherche'; }
                elseif($constr['bat'] == 12){ $nom = 'Camp d\'entraînement'; }
                elseif($constr['bat'] == 13){ $nom = 'Chantier naval'; }
                else{ $nom = 'Undefined'; }

                $tr = $constr['temps_fin'] - time();
                if($tr <= 0){ $phrase = '<ul><li>'.$nom.'</li><li>Temps restant : 0 seconde, actualisation dans la minute.</li></ul>'; }
                else{ $phrase = '<ul><li>'.$nom.', temps restant : <span id="time">'.$tr.'</span> secondes.</li></ul>'; }

                return new Response('Batiment/batiment_construct.html.twig', 'GameBundle', [
                    'rang' => $user['rang'], 'nbmp' => $met->sqlCountMP(), 'nb_monnaie' => $terri['nb_monnaie'], 'nb_uranium' => $terri['nb_uranium'],
                    'nb_acier' => $terri['nb_acier'], 'nb_petrole' => $terri['nb_petrole'], 'nb_composant' => $terri['nb_composant'], 'phrase' => $phrase
                ]);
            }
            else{
                $form = new CreateForm;
                $rech = $br->sqlGetRechJoueur($_SESSION['id']);

                $arrayBat = [];
                if($terri['terri_p'] == 1){
                    $arrayBat[] = $br->sqlGetInfoBat('bat_ministere_defense', 'Ministère de la défense', $_SESSION['id'], $_SESSION['terri']);
                    $arrayBat[] = $br->sqlGetInfoBat('bat_etat_major_marine', 'Etat-major de la Marine', $_SESSION['id'], $_SESSION['terri']);
                    $arrayBat[] = $br->sqlGetInfoBat('bat_etat_major_armee_terre', 'Etat-major de l\'Armée de Terre', $_SESSION['id'], $_SESSION['terri']);
                    $arrayBat[] = $br->sqlGetInfoBat('bat_etat_major_armee_air', 'Etat-major de l\'Armée de l\'Air', $_SESSION['id'], $_SESSION['terri']);
                }

                if($rech['uranium'] == 1){
                    $arrayBat[] = $br->sqlGetInfoBat('bat_usine_extract_ura', 'Usine d\'extraction d\'uranium', $_SESSION['id'], $_SESSION['terri']);
                }

                $arrayBat[] = $br->sqlGetInfoBat('bat_fonderie', 'Fonderie', $_SESSION['id'], $_SESSION['terri']);
                $arrayBat[] = $br->sqlGetInfoBat('bat_puit_petrole', 'Puit de pétrole', $_SESSION['id'], $_SESSION['terri']);
                $arrayBat[] = $br->sqlGetInfoBat('bat_usine', 'Usine', $_SESSION['id'], $_SESSION['terri']);
                $arrayBat[] = $br->sqlGetInfoBat('bat_chantier_naval', 'Chantier naval', $_SESSION['id'], $_SESSION['terri']);
                $arrayBat[] = $br->sqlGetInfoBat('bat_radar', 'Radar', $_SESSION['id'], $_SESSION['terri']);
                $arrayBat[] = $br->sqlGetInfoBat('bat_centre_rech', 'Centre de recherches', $_SESSION['id'], $_SESSION['terri']);
                $arrayBat[] = $br->sqlGetInfoBat('bat_camp_entrainement', 'Camp d\'entraînement', $_SESSION['id'], $_SESSION['terri']);

                return new Response('Batiment/batiment_selection.html.twig', 'GameBundle', [
                    'rang' => $user['rang'], 'nbmp' => $met->sqlCountMP(), 'nb_monnaie' => $terri['nb_monnaie'], 'nb_uranium' => $terri['nb_uranium'],
                    'nb_acier' => $terri['nb_acier'], 'nb_petrole' => $terri['nb_petrole'], 'nb_composant' => $terri['nb_composant'], 'list' => $arrayBat,
                    'form' => [
                        'start' => $form->startForm([ 'method' => 'post', 'action' => '../batConf/' ]),
                        'submit' => $form->addInput([ 'name' => 'submit', 'type' => 'submit', 'value' => 'Construire' ]),
                        'end' => $form->endForm()
                    ]
                ]);
            }
        }
    }