<?php
    namespace Bundles\GameBundle\Controllers;
    use Composants\Framework\Response\Response;
    use Composants\Framework\Response\Redirect;
    use Composants\Framework\Utility\Forms\CreateForm;
    use Bundles\GameBundle\Requests\IndexRequests;

    /**
     * Class IndexController
     * @package Controllers
     */
    class IndexController{
        /**
         * @return Redirect|Response
         */
        public function indexAction(){
            if(!isset($_SESSION['id'])){
                $form_conn = new CreateForm;
                $form_insc = new CreateForm;
                $i = new IndexRequests;

                $data = $i->getSqlRandPositon();

                $array_x = [];
                $array_y = [];
                foreach($data as $v){
                    $array_x[] = $v->getPosition_x() - 2;
                    $array_x[] = $v->getPosition_x() - 1;
                    $array_x[] = $v->getPosition_x();
                    $array_x[] = $v->getPosition_x() + 1;
                    $array_x[] = $v->getPosition_x() + 2;

                    $array_y[] = $v->getPosition_y() - 2;
                    $array_y[] = $v->getPosition_y() - 1;
                    $array_y[] = $v->getPosition_y();
                    $array_y[] = $v->getPosition_y() + 1;
                    $array_y[] = $v->getPosition_y() + 2;
                }

                $pos_y_min = $array_y[0] - 1;
                $pos_y_max = $array_y[4] + 1;

                $_SESSION['x_min'] = $array_x[0];
                $_SESSION['x_max'] = $array_x[4];
                $_SESSION['y_min'] = $array_y[0];
                $_SESSION['y_max'] = $array_y[4];

                $data1 = $i->sqlGetPosXLine($array_x[0], $pos_y_min, $pos_y_max);
                $data2 = $i->sqlGetPosXLine($array_x[1], $pos_y_min, $pos_y_max);
                $data3 = $i->sqlGetPosXLine($array_x[2], $pos_y_min, $pos_y_max);
                $data4 = $i->sqlGetPosXLine($array_x[3], $pos_y_min, $pos_y_max);
                $data5 = $i->sqlGetPosXLine($array_x[4], $pos_y_min, $pos_y_max);

                return new Response('index.html.twig', 'GameBundle', [
                    'form_conn' => [
                        'start' => $form_conn->startForm([ 'method' => 'post', 'action' => '../connexion/' ]),
                        'mail' => $form_conn->addInput([ 'name' => 'pseudo', 'type' => 'text', 'placeholder' => 'Pseudo', 'require' => true, 'classcss' => 'input_conn' ]),
                        'password' => $form_conn->addInput([ 'name' => 'password', 'type' => 'password', 'placeholder' => 'Password', 'require' => true, 'classcss' => 'input_conn' ]),
                        'submit' => $form_conn->addInput([ 'name' => 'submit', 'type' => 'submit', 'value' => 'Connexion' ]),
                        'end' => $form_conn->endForm()
                    ],
                    'form_insc' => [
                        'start' => $form_insc->startForm([ 'method' => 'post', 'action' => '../inscription/' ]),
                        'pseudo' => $form_insc->addInput([ 'name' => 'pseudo', 'type' => 'text', 'placeholder' => 'Pseudo', 'require' => true, 'id' => 'pseudo', 'classcss' => 'input_insc' ]),
                        'password' => $form_insc->addInput([ 'name' => 'password', 'type' => 'password', 'placeholder' => 'Password', 'require' => true, 'classcss' => 'input_insc' ]),
                        'password_check' => $form_insc->addInput([ 'name' => 'password_check', 'type' => 'password', 'placeholder' => 'Password', 'require' => true, 'classcss' => 'input_insc' ]),
                        'mail' => $form_insc->addInput([ 'name' => 'mail', 'type' => 'mail', 'placeholder' => 'Mail', 'require' => true, 'classcss' => 'input_insc' ]),
                        'pos_x' => $form_insc->addInput([ 'name' => 'pos_x', 'type' => 'number', 'placeholder' => 'Position', 'require' => true, 'classcss' => 'input_insc' ]),
                        'pos_y' => $form_insc->addInput([ 'name' => 'pos_y', 'type' => 'number', 'placeholder' => 'Position', 'require' => true, 'classcss' => 'input_insc' ]),
                        'submit' => $form_insc->addInput([ 'name' => 'submit', 'type' => 'submit', 'value' => 'Inscription' ]),
                        'end' => $form_insc->endForm()
                    ],
                    'line1_table' => $data1, 'line2_table' => $data2, 'line3_table' => $data3, 'line4_table' => $data4, 'line5_table' => $data5
                ]);
            }
            else{
                return new Redirect('../game/');
            }
        }
    }