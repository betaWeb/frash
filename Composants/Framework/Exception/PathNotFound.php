<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Response\Response;
    use Composants\Framework\CreateLog\CreateErrorLog;

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
            new CreateErrorLog('Path Not Found');
            return new Response('PathNotFound.html.twig', 'Exception', [ 'path' => $path ]);
        }
    }