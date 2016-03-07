<?php
    namespace Bundles\GameBundle\Controllers;
    use Composants\Framework\Response\Response;
    use Composants\Framework\Response\Redirect;
    use Bundles\GameBundle\Requests\MenuRequests;
    use Bundles\GameBundle\Requests\BatimentRequests;
    use Composants\Framework\Forms\CreateForm;
    use Composants\Framework\Response\ClassUrl;

    /**
     * Class BatimentController
     * @package Bundles\GameBundle\Controllers
     */
    class BatimentController{
        /**
         * @return Redirect|Response
         */
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

                $curl = new ClassUrl;

                return new Response('Batiment/batiment_selection.html.twig', 'GameBundle', [
                    'rang' => $user['rang'], 'nbmp' => $met->sqlCountMP(), 'nb_monnaie' => $terri['nb_monnaie'], 'nb_uranium' => $terri['nb_uranium'],
                    'nb_acier' => $terri['nb_acier'], 'nb_petrole' => $terri['nb_petrole'], 'nb_composant' => $terri['nb_composant'], 'list' => $arrayBat,
                    'form' => [
                        'start' => $form->startForm([ 'method' => 'post', 'action' => $curl->getUrlForm('batConf/') ]),
                        'submit' => $form->addInput([ 'name' => 'submit', 'type' => 'submit', 'value' => 'Construire' ]),
                        'end' => $form->endForm()
                    ]
                ]);
            }
        }

        /**
         * @return Redirect
         */
        public function batConfAction(){
            if(isset($_POST['submit']) && isset($_POST['bat'])){
                $br = new BatimentRequests;
                $met = new MenuRequests;
                $user = $met->sqlGetInfoUser();
                $terri = $met->sqlGetInfoTerri();

                $rech = $br->sqlGetRechJoueur($_SESSION['id']);

                if($_POST['bat'] == 'ministere_defense'){
                    $det = $br->sqlGetInfoConfBat('bat_'.$_POST['bat'], $_SESSION['id'], $_SESSION['terri']);
                    if($det['cout_monnaie'] > $terri['nb_monnaie'] || $det['cout_acier'] > $terri['nb_acier'] || $det['cout_composant'] > $terri['nb_composant']){ return new Redirect('../batiment/'); }

                    $temps_fin = time() + $det['temps_construction'];
                    $new_nb_monnaie = $terri['nb_monnaie'] - $det['cout_monnaie'];
                    $new_nb_acier = $terri['nb_acier'] - $det['cout_acier'];
                    $new_nb_comp = $terri['nb_composant'] - $det['cout_composant'];

                    $cout_monn = ceil($det['cout_monnaie'] * 1.2);
                    $cout_acier = ceil($det['cout_acier'] * 1.2);
                    $cout_comp = ceil($det['cout_composant'] * 1.2);
                    $temps_construct = ceil($det['temps_construction'] * 1.2);
                    $new_prod = ceil($terri['prod_monnaie'] * 1.2);

                    $br->sqlInsertConstructBat($this->defineTypeConstructBat($_POST['bat']), $det['temps_construction'], $temps_fin, $_SESSION['terri']);
                    $br->sqlUpdateConstructBat('bat_'.$_POST['bat'], $cout_monn, $cout_acier, $cout_comp, $temps_construct, $det['niveau'] + 1, $_SESSION['terri']);
                    $br->sqlUpdateTerriConstBatWithProdMonnaie($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $new_prod, $_SESSION['terri']);
                    $br->sqlUpdatePointUser($_SESSION['id'], $user['point'] + 20);
                }
                elseif($_POST['bat'] == 'etat_major_marine' || $_POST['bat'] == 'etat_major_armee_terre' || $_POST['bat'] == 'etat_major_armee_air'){
                    $det = $br->sqlGetInfoConfBat('bat_'.$_POST['bat'], $_SESSION['id'], $_SESSION['terri']);
                    if($det['cout_monnaie'] > $terri['nb_monnaie'] || $det['cout_acier'] > $terri['nb_acier'] || $det['cout_composant'] > $terri['nb_composant']){ return new Redirect('../batiment/'); }

                    $temps_fin = time() + $det['temps_construction'];
                    $new_nb_monnaie = $terri['nb_monnaie'] - $det['cout_monnaie'];
                    $new_nb_acier = $terri['nb_acier'] - $det['cout_acier'];
                    $new_nb_comp = $terri['nb_composant'] - $det['cout_composant'];

                    $cout_monn = ceil($det['cout_monnaie'] * 1.2);
                    $cout_acier = ceil($det['cout_acier'] * 1.2);
                    $cout_comp = ceil($det['cout_composant'] * 1.2);
                    $temps_construct = ceil($det['temps_construction'] * 1.2);

                    $br->sqlInsertConstructBat($this->defineTypeConstructBat($_POST['bat']), $det['temps_construction'], $temps_fin, $_SESSION['terri']);
                    $br->sqlUpdateConstructBat('bat_'.$_POST['bat'], $cout_monn, $cout_acier, $cout_comp, $temps_construct, $det['niveau'] + 1, $_SESSION['terri']);
                    $br->sqlUpdateTerriConstBatNoProd($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $_SESSION['terri']);
                    $br->sqlUpdatePointUser($_SESSION['id'], $user['point'] + 32);
                }
                elseif($_POST['bat'] == 'usine_extract_ura' && $rech['uranium'] == 1){
                    $det = $br->sqlGetInfoConfBat('bat_'.$_POST['bat'], $_SESSION['id'], $_SESSION['terri']);
                    if($det['cout_monnaie'] > $terri['nb_monnaie'] || $det['cout_acier'] > $terri['nb_acier'] || $det['cout_composant'] > $terri['nb_composant']){ return new Redirect('../batiment/'); }

                    $temps_fin = time() + $det['temps_construction'];
                    $new_nb_monnaie = $terri['nb_monnaie'] - $det['cout_monnaie'];
                    $new_nb_acier = $terri['nb_acier'] - $det['cout_acier'];
                    $new_nb_comp = $terri['nb_composant'] - $det['cout_composant'];

                    $cout_monn = ceil($det['cout_monnaie'] * 1.2);
                    $cout_acier = ceil($det['cout_acier'] * 1.2);
                    $cout_comp = ceil($det['cout_composant'] * 1.2);
                    $temps_construct = ceil($det['temps_construction'] * 1.2);
                    $new_prod = ceil($terri['prod_uranium'] * 1.2);

                    $br->sqlInsertConstructBat($this->defineTypeConstructBat($_POST['bat']), $det['temps_construction'], $temps_fin, $_SESSION['terri']);
                    $br->sqlUpdateConstructBat('bat_'.$_POST['bat'], $cout_monn, $cout_acier, $cout_comp, $temps_construct, $det['niveau'] + 1, $_SESSION['terri']);
                    $br->sqlUpdateTerriConstBatWithProdUranium($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $new_prod, $_SESSION['terri']);
                    $br->sqlUpdatePointUser($_SESSION['id'], $user['point'] + 26);
                }
                elseif($_POST['bat'] == 'fonderie'){
                    $det = $br->sqlGetInfoConfBat('bat_'.$_POST['bat'], $_SESSION['id'], $_SESSION['terri']);
                    if($det['cout_monnaie'] > $terri['nb_monnaie'] || $det['cout_acier'] > $terri['nb_acier'] || $det['cout_composant'] > $terri['nb_composant']){ return new Redirect('../batiment/'); }

                    $temps_fin = time() + $det['temps_construction'];
                    $new_nb_monnaie = $terri['nb_monnaie'] - $det['cout_monnaie'];
                    $new_nb_acier = $terri['nb_acier'] - $det['cout_acier'];
                    $new_nb_comp = $terri['nb_composant'] - $det['cout_composant'];

                    $cout_monn = ceil($det['cout_monnaie'] * 1.2);
                    $cout_acier = ceil($det['cout_acier'] * 1.2);
                    $cout_comp = ceil($det['cout_composant'] * 1.2);
                    $temps_construct = ceil($det['temps_construction'] * 1.2);
                    $new_prod = ceil($terri['prod_acier'] * 1.2);

                    $br->sqlInsertConstructBat($this->defineTypeConstructBat($_POST['bat']), $det['temps_construction'], $temps_fin, $_SESSION['terri']);
                    $br->sqlUpdateConstructBat('bat_'.$_POST['bat'], $cout_monn, $cout_acier, $cout_comp, $temps_construct, $det['niveau'] + 1, $_SESSION['terri']);
                    $br->sqlUpdateTerriConstBatWithProdAcier($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $new_prod, $_SESSION['terri']);
                    $br->sqlUpdatePointUser($_SESSION['id'], $user['point'] + 20);
                }
                elseif($_POST['bat'] == 'puit_petrole'){
                    $det = $br->sqlGetInfoConfBat('bat_'.$_POST['bat'], $_SESSION['id'], $_SESSION['terri']);
                    if($det['cout_monnaie'] > $terri['nb_monnaie'] || $det['cout_acier'] > $terri['nb_acier'] || $det['cout_composant'] > $terri['nb_composant']){ return new Redirect('../batiment/'); }

                    $temps_fin = time() + $det['temps_construction'];
                    $new_nb_monnaie = $terri['nb_monnaie'] - $det['cout_monnaie'];
                    $new_nb_acier = $terri['nb_acier'] - $det['cout_acier'];
                    $new_nb_comp = $terri['nb_composant'] - $det['cout_composant'];

                    $cout_monn = ceil($det['cout_monnaie'] * 1.2);
                    $cout_acier = ceil($det['cout_acier'] * 1.2);
                    $cout_comp = ceil($det['cout_composant'] * 1.2);
                    $temps_construct = ceil($det['temps_construction'] * 1.2);
                    $new_prod = ceil($terri['prod_petrole'] * 1.2);

                    $br->sqlInsertConstructBat($this->defineTypeConstructBat($_POST['bat']), $det['temps_construction'], $temps_fin, $_SESSION['terri']);
                    $br->sqlUpdateConstructBat('bat_'.$_POST['bat'], $cout_monn, $cout_acier, $cout_comp, $temps_construct, $det['niveau'] + 1, $_SESSION['terri']);
                    $br->sqlUpdateTerriConstBatWithProdPetrole($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $new_prod, $_SESSION['terri']);
                    $br->sqlUpdatePointUser($_SESSION['id'], $user['point'] + 24);
                }
                elseif($_POST['bat'] == 'usine'){
                    $det = $br->sqlGetInfoConfBat('bat_'.$_POST['bat'], $_SESSION['id'], $_SESSION['terri']);
                    if($det['cout_monnaie'] > $terri['nb_monnaie'] || $det['cout_acier'] > $terri['nb_acier'] || $det['cout_composant'] > $terri['nb_composant']){ return new Redirect('../batiment/'); }

                    $temps_fin = time() + $det['temps_construction'];
                    $new_nb_monnaie = $terri['nb_monnaie'] - $det['cout_monnaie'];
                    $new_nb_acier = $terri['nb_acier'] - $det['cout_acier'];
                    $new_nb_comp = $terri['nb_composant'] - $det['cout_composant'];

                    $cout_monn = ceil($det['cout_monnaie'] * 1.2);
                    $cout_acier = ceil($det['cout_acier'] * 1.2);
                    $cout_comp = ceil($det['cout_composant'] * 1.2);
                    $temps_construct = ceil($det['temps_construction'] * 1.2);
                    $new_prod = ceil($terri['prod_composant'] * 1.2);

                    $br->sqlInsertConstructBat($this->defineTypeConstructBat($_POST['bat']), $det['temps_construction'], $temps_fin, $_SESSION['terri']);
                    $br->sqlUpdateConstructBat('bat_'.$_POST['bat'], $cout_monn, $cout_acier, $cout_comp, $temps_construct, $det['niveau'] + 1, $_SESSION['terri']);
                    $br->sqlUpdateTerriConstBatWithProdComposant($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $new_prod, $_SESSION['terri']);
                    $br->sqlUpdatePointUser($_SESSION['id'], $user['point'] + 26);

                    if($br->sqlCountConstArmee($_SESSION['terri']) != 0){
                        $br->sqlSelectConstArmee($_SESSION['terri'], $det['temps_construction']);
                    }
                }
                elseif($_POST['bat'] == 'radar'){
                    $det = $br->sqlGetInfoConfBat('bat_'.$_POST['bat'], $_SESSION['id'], $_SESSION['terri']);
                    if($det['cout_monnaie'] > $terri['nb_monnaie'] || $det['cout_acier'] > $terri['nb_acier'] || $det['cout_composant'] > $terri['nb_composant']){ return new Redirect('../batiment/'); }

                    $temps_fin = time() + $det['temps_construction'];
                    $new_nb_monnaie = $terri['nb_monnaie'] - $det['cout_monnaie'];
                    $new_nb_acier = $terri['nb_acier'] - $det['cout_acier'];
                    $new_nb_comp = $terri['nb_composant'] - $det['cout_composant'];

                    $cout_monn = ceil($det['cout_monnaie'] * 1.2);
                    $cout_acier = ceil($det['cout_acier'] * 1.2);
                    $cout_comp = ceil($det['cout_composant'] * 1.2);
                    $temps_construct = ceil($det['temps_construction'] * 1.2);

                    $br->sqlInsertConstructBat($this->defineTypeConstructBat($_POST['bat']), $det['temps_construction'], $temps_fin, $_SESSION['terri']);
                    $br->sqlUpdateConstructBat('bat_'.$_POST['bat'], $cout_monn, $cout_acier, $cout_comp, $temps_construct, $det['niveau'] + 1, $_SESSION['terri']);
                    $br->sqlUpdateTerriConstBatNoProd($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $_SESSION['terri']);
                    $br->sqlUpdatePointUser($_SESSION['id'], $user['point'] + 17);

                    if($det['niveau'] + 1 == 1){
                        $br->sqlInsertLevelRadar($_SESSION['id'], $terri['pos_x'] - 2, $terri['pos_x'] + 2, $terri['pos_y'] - 2, $terri['pos_y'] + 2);
                    }
                    else{
                        $br->sqlSelectRadar($_SESSION['id']);
                    }
                }
                elseif($_POST['bat'] == 'centre_recherche'){
                    $det = $br->sqlGetInfoConfBat('bat_'.$_POST['bat'], $_SESSION['id'], $_SESSION['terri']);
                    if($det['cout_monnaie'] > $terri['nb_monnaie'] || $det['cout_acier'] > $terri['nb_acier'] || $det['cout_composant'] > $terri['nb_composant']){ return new Redirect('../batiment/'); }

                    $temps_fin = time() + $det['temps_construction'];
                    $new_nb_monnaie = $terri['nb_monnaie'] - $det['cout_monnaie'];
                    $new_nb_acier = $terri['nb_acier'] - $det['cout_acier'];
                    $new_nb_comp = $terri['nb_composant'] - $det['cout_composant'];

                    $cout_monn = ceil($det['cout_monnaie'] * 1.2);
                    $cout_acier = ceil($det['cout_acier'] * 1.2);
                    $cout_comp = ceil($det['cout_composant'] * 1.2);
                    $temps_construct = ceil($det['temps_construction'] * 1.2);

                    $br->sqlInsertConstructBat($this->defineTypeConstructBat($_POST['bat']), $det['temps_construction'], $temps_fin, $_SESSION['terri']);
                    $br->sqlUpdateConstructBat('bat_'.$_POST['bat'], $cout_monn, $cout_acier, $cout_comp, $temps_construct, $det['niveau'] + 1, $_SESSION['terri']);
                    $br->sqlUpdateTerriConstBatNoProd($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $_SESSION['terri']);
                    $br->sqlUpdatePointUser($_SESSION['id'], $user['point'] + 30);
                }
                elseif($_POST['bat'] == 'camp_entrainement'){
                    $det = $br->sqlGetInfoConfBat('bat_'.$_POST['bat'], $_SESSION['id'], $_SESSION['terri']);
                    if($det['cout_monnaie'] > $terri['nb_monnaie'] || $det['cout_acier'] > $terri['nb_acier'] || $det['cout_composant'] > $terri['nb_composant']){ return new Redirect('../batiment/'); }

                    $temps_fin = time() + $det['temps_construction'];
                    $new_nb_monnaie = $terri['nb_monnaie'] - $det['cout_monnaie'];
                    $new_nb_acier = $terri['nb_acier'] - $det['cout_acier'];
                    $new_nb_comp = $terri['nb_composant'] - $det['cout_composant'];

                    $cout_monn = ceil($det['cout_monnaie'] * 1.2);
                    $cout_acier = ceil($det['cout_acier'] * 1.2);
                    $cout_comp = ceil($det['cout_composant'] * 1.2);
                    $temps_construct = ceil($det['temps_construction'] * 1.2);

                    $br->sqlInsertConstructBat($this->defineTypeConstructBat($_POST['bat']), $det['temps_construction'], $temps_fin, $_SESSION['terri']);
                    $br->sqlUpdateConstructBat('bat_'.$_POST['bat'], $cout_monn, $cout_acier, $cout_comp, $temps_construct, $det['niveau'] + 1, $_SESSION['terri']);
                    $br->sqlUpdateTerriConstBatNoProd($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $_SESSION['terri']);
                    $br->sqlUpdatePointUser($_SESSION['id'], $user['point'] + 34);
                }
                elseif($_POST['bat'] == 'chantier_naval' && $data2['level_usine_tactique'] > 0){
                    $det = $br->sqlGetInfoConfBat('bat_'.$_POST['bat'], $_SESSION['id'], $_SESSION['terri']);
                    if($det['cout_monnaie'] > $terri['nb_monnaie'] || $det['cout_acier'] > $terri['nb_acier'] || $det['cout_composant'] > $terri['nb_composant']){ return new Redirect('../batiment/'); }

                    $temps_fin = time() + $det['temps_construction'];
                    $new_nb_monnaie = $terri['nb_monnaie'] - $det['cout_monnaie'];
                    $new_nb_acier = $terri['nb_acier'] - $det['cout_acier'];
                    $new_nb_comp = $terri['nb_composant'] - $det['cout_composant'];

                    $cout_monn = ceil($det['cout_monnaie'] * 1.2);
                    $cout_acier = ceil($det['cout_acier'] * 1.2);
                    $cout_comp = ceil($det['cout_composant'] * 1.2);
                    $temps_construct = ceil($det['temps_construction'] * 1.2);

                    $br->sqlInsertConstructBat($this->defineTypeConstructBat($_POST['bat']), $det['temps_construction'], $temps_fin, $_SESSION['terri']);
                    $br->sqlUpdateConstructBat('bat_'.$_POST['bat'], $cout_monn, $cout_acier, $cout_comp, $temps_construct, $det['niveau'] + 1, $_SESSION['terri']);
                    $br->sqlUpdateTerriConstBatNoProd($new_nb_monnaie, $new_nb_acier, $new_nb_comp, $_SESSION['terri']);
                    $br->sqlUpdatePointUser($_SESSION['id'], $user['point'] + 27);
                }

                return new Redirect('../batiment/');
            }
        }

        private function defineTypeConstructBat($bat){
            $res = 0;
            if($bat == 'Ministère de la défense'){ $res = 1; }
            elseif($bat == 'Etat-major de la Marine'){ $res = 2; }
            elseif($bat == 'Etat-major de l\'Armée de Terre'){ $res = 3; }
            elseif($bat == 'Etat-major de l\'Armée de l\'Air'){ $res = 4; }
            elseif($bat == 'Usine d\'extraction d\'uranium'){ $res = 5; }
            elseif($bat == 'Fonderie'){ $res = 6; }
            elseif($bat == 'Puit de pétrole'){ $res = 7; }
            elseif($bat == 'Usine'){ $res = 8; }
            elseif($bat == 'Radar'){ $res = 9; }
            elseif($bat == 'Centre de recherche'){ $res = 10; }
            elseif($bat == 'Camp d\'entraînement'){ $res = 11; }
            elseif($bat == 'Chantier naval'){ $res = 12; }

            return $res;
        }
    }