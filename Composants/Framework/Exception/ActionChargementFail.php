<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Response\Response;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Yaml\Yaml;

    /**
     * Class ActionChargementFail
     * @package Composants\Framework\Exception
     */
    class ActionChargementFail{
        /**
         * ActionChargementFail constructor.
         * @param $action
         */
        public function __construct($action){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));

            if($yaml['log']['error'] == 'yes'){
                new CreateErrorLog('Action '.$action.' Not Found');
            }

            return new Response('ActionNotFound.html.twig', 'Exception', [ 'action' => $action ]);
        }
    }