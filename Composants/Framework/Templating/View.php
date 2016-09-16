<?php
    namespace Composants\Framework\Templating;

    /**
     * Class View
     * @package Composants\Framework\Templating
     */
    class View{
        /**
         * View constructor.
         * @param string $file
         * @param array $params
         */
        public function __construct($file, $params){
            $prefix = 'Bundles/'.$params['bundle'].'/Views';
            // {/ /} => Afficher variable
            // {{ }} => Fonctions

            if($params['include'] != ''){
                $incl = file_get_contents($prefix.'/'.$params['include']);

                $occur = [];
                preg_match_all('/{% cell (\w+) %}(.*?){% endcell %}/s', $incl, $matches2);
                array_push($occur, $matches2);

                echo '<pre>'; print_r($occur); echo '</pre>';
                
                echo $incl;
            }

            $view = file_get_contents($prefix.'/'.$file);

            //$search = 'blablabla<td class="test">Victoria</td>blablabla';

            //preg_match("#{{ include('(\w+)') }}#", $view, $matches);
            //preg_match('#<td class="test">(\w+)</td>#', $search, $matches);

            //echo '<pre>'; print_r($matches); echo '</pre>';

            echo $view;
        }
    }