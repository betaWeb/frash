<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Response\Response;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Yaml\Yaml;

    /**
     * Class PathNotFound
     * @package Composants\Framework\Exception
     */
    class PathNotFound{
        /**
         * PathNotFound constructor.
         * @param $path
         */
        public function __construct($path){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));

            if($yaml['log']['error'] == 'yes'){
                new CreateErrorLog('Path Not Found');
            }
            
            return new Response('PathNotFound.html.twig', 'Exception', [ 'path' => $path ]);
        }
    }