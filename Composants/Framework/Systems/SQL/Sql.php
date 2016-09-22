<?php
    namespace Composants\Framework\Systems\SQL;
    use Composants\Framework\DIC\Dic;

    /**
     * Class Sql
     * @package Composants\Framework\Systems\SQL
     */
    class Sql{
        const PATH = 'Composants/Framework/Systems/Ressources/Views/SQL/';

        public function sqlAction(Dic $dic){
            $gets = $dic->open('get');

            if(empty($gets->get('get', 0))){
                return $dic->load('view')->viewDev('sql_no_choice.html.twig', self::PATH);
            }
            else{}
        }
    }