<?php
    namespace Bundles\GameBundle\Controllers;
    use Composants\Framework\Response\Response;
    use Bundles\GameBundle\Requests\MenuRequests;
    use Bundles\GameBundle\Requests\CarteRequests;
    use Composants\Framework\Forms\CreateForm;
    use Composants\ORM\Request\QueryBuilder;
    use Composants\ORM\Request\Select;
    use Composants\ORM\Request\Where;

    class CarteController{
        public function carteAction(){
            if(!isset($_SESSION['id']) || !isset($_SESSION['pseudo']) || !isset($_SESSION['terri'])){ return new Redirect('../accueil/'); }
            
            $met = new MenuRequests;
            $user = $met->sqlGetInfoUser();
            $terri = $met->sqlGetInfoTerri();

            $req = new QueryBuilder();
            $pos_x;
            $pos_y;

            if(!isset($_POST['submit'])){
                $req = new QueryBuilder();
                $sel = new Select('territoire');
                $wh = new Where();
                $wh->initNormalWhere([ 'id', ':id' ], '=');
                $sel->setExecute([ $_SESSION['terri'] ]);
                $sel->requestSelect();
                $data = $req->execRequestSelect($sel->getRequest(), $sel->getExecute(), '\Bundles\GameBundle\Entity\Territoire');

                foreach($data as $v){
                    $pos_x = $v->getPosition_x();
                    $pos_y = $v->getPosition_y();
                }
            }
            else{
                if(isset($_POST['pos_x']) && is_numeric($_POST['pos_x']) && isset($_POST['pos_y']) && is_numeric($_POST['pos_y'])){
                    $pos_x = $_POST['pos_x'];
                    $pos_y = $_POST['pos_y'];
                }
            }

            $array_x = [];
            $array_y = [];

            $array_x[] = $pos_x - 5;
            $array_x[] = $pos_x - 4;
            $array_x[] = $pos_x - 3;
            $array_x[] = $pos_x - 2;
            $array_x[] = $pos_x - 1;
            $array_x[] = $pos_x;
            $array_x[] = $pos_x + 1;
            $array_x[] = $pos_x + 2;
            $array_x[] = $pos_x + 3;
            $array_x[] = $pos_x + 4;
            $array_x[] = $pos_x + 5;

            $array_y[] = $pos_y - 5;
            $array_y[] = $pos_y - 4;
            $array_y[] = $pos_y - 3;
            $array_y[] = $pos_y - 2;
            $array_y[] = $pos_y - 1;
            $array_y[] = $pos_y;
            $array_y[] = $pos_y + 1;
            $array_y[] = $pos_y + 2;
            $array_y[] = $pos_y + 3;
            $array_y[] = $pos_y + 4;
            $array_y[] = $pos_y + 5;

            $pos_y_min = $array_y[0] - 1;
            $pos_y_max = $array_y[10] + 1;

            $cr = new CarteRequests;
            $data1 = $cr->sqlGetLineX($array_x[0], $pos_y_min, $pos_y_max);
            $data2 = $cr->sqlGetLineX($array_x[1], $pos_y_min, $pos_y_max);
            $data3 = $cr->sqlGetLineX($array_x[2], $pos_y_min, $pos_y_max);
            $data4 = $cr->sqlGetLineX($array_x[3], $pos_y_min, $pos_y_max);
            $data5 = $cr->sqlGetLineX($array_x[4], $pos_y_min, $pos_y_max);
            $data6 = $cr->sqlGetLineX($array_x[5], $pos_y_min, $pos_y_max);
            $data7 = $cr->sqlGetLineX($array_x[6], $pos_y_min, $pos_y_max);
            $data8 = $cr->sqlGetLineX($array_x[7], $pos_y_min, $pos_y_max);
            $data9 = $cr->sqlGetLineX($array_x[8], $pos_y_min, $pos_y_max);
            $data10 = $cr->sqlGetLineX($array_x[9], $pos_y_min, $pos_y_max);
            $data11 = $cr->sqlGetLineX($array_x[10], $pos_y_min, $pos_y_max);

            $form = new CreateForm;

            return new Response('carte.html', 'GameBundle', [
                'rang' => $user['rang'], 'nbmp' => $met->sqlCountMP(), 'nb_monnaie' => $terri['nb_monnaie'], 'nb_uranium' => $terri['nb_uranium'],
                'nb_acier' => $terri['nb_acier'], 'nb_petrole' => $terri['nb_petrole'], 'nb_composant' => $terri['nb_composant'],
                'line1' => $data1, 'line2' => $data2, 'line3' => $data3, 'line4' => $data4, 'line5' => $data5, 'line6' => $data6, 'line7' => $data7,
                'line8' => $data8, 'line9' => $data9, 'line10' => $data10, 'line11' => $data11,
                'form' => [
                    'start' => $form->startForm([ 'method' => 'post', 'action' => '../carte/' ]),
                    'pos_x' => $form->addInput([ 'name' => 'pos_x', 'type' => 'number', 'placeholder' => 'Position', 'require' => true ]),
                    'pos_y' => $form->addInput([ 'name' => 'pos_y', 'type' => 'number', 'placeholder' => 'Position', 'require' => true ]),
                    'submit' => $form->addInput([ 'name' => 'submit', 'type' => 'submit', 'value' => 'Y aller' ]),
                    'end' => $form->endForm()
                ]
            ]);
        }
    }