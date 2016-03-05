<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Response\Response;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Yaml\Yaml;

    /**
     * Class ControllerChargementFail
     * @package Composants\Framework\Exception
     */
    class ControllerChargementFail{
        /**
         * ControllerChargementFail constructor.
         * @param $controller
         */
        public function __construct($controller){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));

            if($yaml['log']['error'] == 'yes'){
                new CreateErrorLog('Controller '.$controller.' Not Found');
            }

            return new Response('ControllerNotFound.html.twig', 'Exception', [ 'controller' => $controller ]);
        }
    }