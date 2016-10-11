<?php
    namespace LFW\Framework\Systems\Logs;
    use LFW\Framework\DIC\Dic;

    /**
     * Class Logs
     * @package LFW\Framework\Systems\Logs
     */
    class Logs{
        const PATH = 'vendor/LFW/Framework/Systems/Ressources/Views/Logs/';

        public function logAction(Dic $dic){
            $gets = $dic->open('get');

            if(empty($gets->get('get', 0))){
                return $dic->load('view')->viewDev('logs_no_choice.html.twig', self::PATH);
            }
            else{
                return $dic->load('view')->viewDev('logs_choice.html.twig', self::PATH, [
                    'file' => nl2br(file_get_contents('LFW/Logs/'.$gets->get('get', 0).'.log'))
                ]);
            }
        }
    }