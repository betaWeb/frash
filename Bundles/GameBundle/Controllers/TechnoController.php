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
        /**
         * @return Redirect|Response
         */
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
                elseif($constr['rech'] == 12){ $nom = 'Drone HALE'; }
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

        /**
         * @return Redirect
         */
        public function technoConfAction(){
            if(isset($_POST['submit']) && isset($_POST['rech'])){
                $tr = new TechnoRequests;
                $met = new MenuRequests;
                $terri = $met->sqlGetInfoTerri();

                if($_POST['rech'] == 'maniement_uranium' && 290000000 < $terri['dep_monnaie'] && 2000 < $terri['dep_uranium'] && 60000 < $terri['dep_acier'] && 20000 < $terri['dep_composant']){
                    $new_nb_monnaie = $terri['dep_monnaie'] - 290000000;
                    $new_nb_uranium = $terri['dep_uranium'] - 2000;
                    $new_nb_acier = $terri['dep_acier'] - 60000;
                    $new_nb_comp = $terri['dep_composant'] - 20000;

                    $tr->sqlInsertConstRech(1, $_SESSION['id'], 400, time() + 400);
                    $tr->sqlUpdateRechTable($_POST['rech'], $_SESSION['id']);
                    $tr->sqlUpdTerriMUAC($new_nb_monnaie, $new_nb_uranium, $new_nb_acier, $new_nb_comp, $_SESSION['terri']);
                    $tr->sqlUpdatePointUser($_SESSION['id'], 280);
                }
                elseif($_POST['rech'] == 'unites_navales' && 600000000 < $terri['dep_monnaie'] && 7000 < $terri['dep_uranium'] && 90000 < $terri['dep_acier'] && 50000 < $terri['dep_petrole'] && 70000 < $terri['dep_composant']){
                    $new_nb_monnaie = $terri['dep_monnaie'] - 600000000;
                    $new_nb_uranium = $terri['dep_uranium'] - 7000;
                    $new_nb_acier = $terri['dep_acier'] - 90000;
                    $new_nb_petrole = $terri['dep_petrole'] - 50000;
                    $new_nb_comp = $terri['dep_composant'] - 70000;

                    $tr->sqlInsertConstRech(2, $_SESSION['id'], 503, time() + 503);
                    $tr->sqlUpdateRechTable($_POST['rech'], $_SESSION['id']);
                    $tr->sqlUpdTerriMUAPC($new_nb_monnaie, $new_nb_uranium, $new_nb_acier, $new_nb_petrole, $new_nb_comp, $_SESSION['terri']);
                    $tr->sqlUpdatePointUser($_SESSION['id'], 320);
                }
                elseif($_POST['rech'] == 'voilure_tournante' && 350000000 < $terri['dep_monnaie'] && 20000 < $terri['dep_acier'] && 20000 < $terri['dep_petrole'] && 40000 < $terri['dep_composant']){
                    $new_nb_monnaie = $terri['dep_monnaie'] - 350000000;
                    $new_nb_acier = $terri['dep_acier'] - 20000;
                    $new_nb_petrole = $terri['dep_petrole'] - 20000;
                    $new_nb_comp = $terri['dep_composant'] - 40000;

                    $tr->sqlInsertConstRech(3, $_SESSION['id'], 470, time() + 470);
                    $tr->sqlUpdateRechTable($_POST['rech'], $_SESSION['id']);
                    $tr->sqlUpdTerriMAPC($new_nb_monnaie, $new_nb_acier, $new_nb_petrole, $new_nb_comp, $_SESSION['terri']);
                    $tr->sqlUpdatePointUser($_SESSION['id'], 300);
                }
                elseif($_POST['rech'] == 'bouclier_tourelle' && 30000000 < $terri['dep_monnaie'] && 5000 < $terri['dep_acier']){
                    $tr->sqlInsertConstRech(4, $_SESSION['id'], 347, time() + 347);
                    $tr->sqlUpdateRechTable($_POST['rech'], $_SESSION['id']);
                    $tr->sqlUpdTerriMA($terri['dep_monnaie'] - 30000000, $terri['dep_acier'] - 5000, $_SESSION['terri']);
                    $tr->sqlUpdatePointUser($_SESSION['id'], 180);
                }
                elseif($_POST['rech'] == 'furtivite' && 300000000 < $terri['dep_monnaie'] && 10000 < $terri['dep_composant']){
                    $tr->sqlInsertConstRech(5, $_SESSION['id'], 450, time() + 450);
                    $tr->sqlUpdateRechTable($_POST['rech'], $_SESSION['id']);
                    $tr->sqlUpdTerriMC($terri['dep_monnaie'] - 300000000, $terri['dep_composant'] - 10000, $_SESSION['terri']);
                    $tr->sqlUpdatePointUser($_SESSION['id'], 310);
                }
                elseif($_POST['rech'] == 'grille_anti_roq' && 70000000 < $terri['dep_monnaie'] && 5000 < $terri['dep_composant']){
                    $tr->sqlInsertConstRech(6, $_SESSION['id'], 301, time() + 301);
                    $tr->sqlUpdateRechTable($_POST['rech'], $_SESSION['id']);
                    $tr->sqlUpdTerriMC($terri['dep_monnaie'] - 70000000, $terri['dep_composant'] - 5000, $_SESSION['terri']);
                    $tr->sqlUpdatePointUser($_SESSION['id'], 195);
                }
                elseif($_POST['rech'] == 'mitrailleuse_teleop' && 130000000 < $terri['dep_monnaie'] && 5000 < $terri['dep_acier'] && 15000 < $terri['dep_composant']){
                    $new_nb_monnaie = $terri['dep_monnaie'] - 130000000;
                    $new_nb_acier = $terri['dep_acier'] - 5000;
                    $new_nb_comp = $terri['dep_composant'] - 15000;

                    $tr->sqlInsertConstRech(7, $_SESSION['id'], 413, time() + 413);
                    $tr->sqlUpdateRechTable($_POST['rech'], $_SESSION['id']);
                    $tr->sqlUpdTerriMAC($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $_SESSION['terri']);
                    $tr->sqlUpdatePointUser($_SESSION['id'], 260);
                }
                elseif($_POST['rech'] == 'systeme_tir_deporte' && 110000000 < $terri['dep_monnaie'] && 5000 < $terri['dep_composant']){
                    $tr->sqlInsertConstRech(8, $_SESSION['id'], 397, time() + 397);
                    $tr->sqlUpdateRechTable($_POST['rech'], $_SESSION['id']);
                    $tr->sqlUpdTerriMC($terri['dep_monnaie'] - 110000000, $terri['dep_composant'] - 5000, $_SESSION['terri']);
                    $tr->sqlUpdatePointUser($_SESSION['id'], 245);
                }
                elseif($_POST['rech'] == 'canon_electro' && 480000000 < $terri['dep_monnaie'] && 15000 < $terri['dep_acier'] && 100000 < $terri['dep_composant']){
                    $new_nb_monnaie = $terri['dep_monnaie'] - 480000000;
                    $new_nb_acier = $terri['dep_acier'] - 15000;
                    $new_nb_comp = $terri['dep_composant'] - 100000;

                    $tr->sqlInsertConstRech(9, $_SESSION['id'], 682, time() + 682);
                    $tr->sqlUpdateRechTable($_POST['rech'], $_SESSION['id']);
                    $tr->sqlUpdTerriMAC($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $_SESSION['terri']);
                    $tr->sqlUpdatePointUser($_SESSION['id'], 420);
                }
                elseif($_POST['rech'] == 'aeronavale' && 250000000 < $terri['dep_monnaie'] && 9000 < $terri['dep_acier'] && 80000 < $terri['dep_composant']){
                    $new_nb_monnaie = $terri['dep_monnaie'] - 250000000;
                    $new_nb_acier = $terri['dep_acier'] - 9000;
                    $new_nb_comp = $terri['dep_composant'] - 80000;

                    $tr->sqlInsertConstRech(10, $_SESSION['id'], 518, time() + 518);
                    $tr->sqlUpdateRechTable($_POST['rech'], $_SESSION['id']);
                    $tr->sqlUpdTerriMAC($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $_SESSION['terri']);
                    $tr->sqlUpdatePointUser($_SESSION['id'], 317);
                }
                elseif($_POST['rech'] == 'radar_aesa' && 320000000 < $terri['dep_monnaie'] && 110000 < $terri['dep_composant']){
                    $tr->sqlInsertConstRech(11, $_SESSION['id'], 667, time() + 667);
                    $tr->sqlUpdateRechTable($_POST['rech'], $_SESSION['id']);
                    $tr->sqlUpdTerriMC($terri['dep_monnaie'] - 320000000, $terri['dep_composant'] - 110000, $_SESSION['terri']);
                    $tr->sqlUpdatePointUser($_SESSION['id'], 398);
                }

                return new Redirect('../techno/');
            }
        }
    }