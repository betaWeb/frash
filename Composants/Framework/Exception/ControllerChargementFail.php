<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Controller;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Yaml\Yaml;

    /**
     * Class ControllerChargementFail
     * @package Composants\Framework\Exception
     */
    class ControllerChargementFail extends Controller{
        /**
         * ControllerChargementFail constructor.
         * @param $controller
         */
        public function __construct($controller){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));

            if($yaml['log']['error'] == 'yes'){
                new CreateErrorLog('Controller '.$controller.' Not Found');
            }

            return $this->view('ControllerNotFound.html.twig', 'Exception', [ 'controller' => $controller ]);
        }
    }