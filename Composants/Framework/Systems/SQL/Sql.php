<?php
    namespace Composants\Framework\Systems\SQL;
    use Composants\Framework\DIC\Dic;
    use Composants\Yaml\Yaml;

    /**
     * Class Sql
     * @package Composants\Framework\Systems\SQL
     */
    class Sql{
        const PATH = 'Composants/Framework/Systems/Ressources/Views/SQL/';

        public function sqlAction(Dic $dic){
            $gets = $dic->open('get');

            if(empty($gets->get('get', 0))){
                $list_db = Yaml::parse(file_get_contents('Composants/Configuration/database.yml'));

                $array = [];
                foreach($list_db as $k => $v){
                    $array[ $k ] = $k;
                }

                $form = $dic->load('form')->create();
                return $dic->load('view')->viewDev('sql_no_choice.html.twig', self::PATH, [
                    'form' => [
                        'start' => $form->create('StartForm', [ 'method' => 'post', 'action' => $dic->load('getUrl')->url('__sql/connexion/') ]),
                        'bundle' => $form->create('Select', [ [ 'name' => 'bundle' ], $array ]),
                        'submit' => $form->create('Submit', [ 'name' => 'submit', 'value' => 'Connexion', 'class' => 'btn btn-default' ]),
                        'end' => '</form>'
                    ]
                ]);
            }
            else{}
        }
    }