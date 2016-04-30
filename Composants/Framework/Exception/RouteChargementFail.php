<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Response\Response;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Yaml\Yaml;

    /**
     * Class RouteChargementFail
     * @package Composants\Framework\Exception
     */
    class RouteChargementFail{
        /**
         * RouteChargementFail constructor.
         * @param $route
         */
        public function __construct($route){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));

            if($yaml['log']['error'] == 'yes'){
                new CreateErrorLog('Route '.$route.' Not Found');
            }

            return new Response('RouteNotFound.html.twig', 'Exception', [ 'route' => $route ]);
        }
    }