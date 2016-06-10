<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Controller;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Yaml\Yaml;

    /**
     * Class ActionChargementFail
     * @package Composants\Framework\Exception
     */
    class ActionChargementFail extends Controller{
        /**
         * ActionChargementFail constructor.
         * @param $action
         */
        public function __construct($action){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));

            if($yaml['log']['error'] == 'yes'){
                new CreateErrorLog('Action '.$action.' Not Found');
            }

            header("HTTP/1.0 404 Not Found");
            return $this->view('ActionNotFound.html.twig', 'Exception', [ 'action' => $action ]);
        }
    }