<?php
    namespace Bundles\GameBundle\Controllers;
    use Bundles\GameBundle\Requests\InscriptionRequests;
    use Composants\Framework\Response\Redirect;
    use Composants\Framework\Forms\VerifForm;
    use Composants\ORM\Request\Insert;
    use Composants\ORM\Request\QueryBuilder;

    /**
     * Class InscriptionController
     * @package Controllers
     */
    class InscriptionController{
        /**
         * @return Redirect
         */
        public function inscriptionAction(){
            if(isset($_POST['submit'])){
                $vf = new VerifForm;
                if($vf->isEqualInferLength($_POST['pseudo'], 40) === false){ return new Redirect('../accueil/'); }
                elseif($_POST['password'] != $_POST['password_check']){ return new Redirect('../accueil/'); }
                elseif($vf->isEqualInferLength($_POST['mail'], 100) === false){ return new Redirect('../accueil/'); }
                //elseif($_POST['pos_x'] < $_SESSION['x_min'] || $_POST['pos_x'] > $_SESSION['x_max']){ return new Redirect('../accueil/'); }
                //elseif($_POST['pos_y'] < $_SESSION['y_min'] || $_POST['pos_y'] > $_SESSION['y_max']){ return new Redirect('../accueil/'); }
                else{
                    $pseudo = htmlentities($_POST['pseudo']);
                    $mail = htmlentities($_POST['mail']);
                    $pos_x = $_POST['pos_x'];
                    $pos_y = $_POST['pos_y'];

                    $i = new InscriptionRequests;
                    if($i->sqlCountPseudo($pseudo) > 0){ return new Redirect('../accueil/'); }
                    elseif($i->sqlCountMail($mail) > 0){ return new Redirect('../accueil/'); }
                    elseif($i->sqlCountTerri($pos_x, $pos_y) > 0){ return new Redirect('../accueil/'); }
                    else{
                        $i->sqlInsertUser($pseudo, sha1($_POST['password']), $mail);
                        /*$id_user = $i->sqlGetIdInsertUser($pseudo);
                        $i->sqlInsertTerri($id_user, $pseudo, $pos_x, $pos_y);
                        $id_terri = $i->sqlGetIdInsertTerri($pseudo);
                        $i->sqlUpdateCarte($id_terri, $id_user, $pseudo, $pos_x, $pos_y);

                        $table_bat = [ 'bat_camp_entrainement', 'bat_centre_rech', 'bat_chantier_naval', 'bat_etat_major_armee_air', 'bat_etat_major_armee_terre', 'bat_etat_major_marine', 'bat_fonderie', 'bat_ministere_defense', 'bat_puit_petrole', 'bat_radar', 'bat_usine', 'bat_usine_extract_ura' ];
                        foreach($table_bat as $v){
                            $i->sqlForeachBat($v, $id_user, $id_terri);
                        }

                        $i->sqlInsertRech($id_user);*/

                        /*$_SESSION['id'] = $id_user;
                        $_SESSION['pseudo'] = $pseudo;
                        $_SESSION['terri'] = $id_terri;*/

                        //return new Redirect('../game/');
                    }
                }
            }
            else{
                return new Redirect('../accueil/');
            }
        }
    }