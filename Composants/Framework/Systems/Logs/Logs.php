<?php
    namespace Composants\Framework\Systems\Logs;
    use Composants\Framework\DIC\Dic;

    /**
     * Class Logs
     * @package Composants\Framework\Systems\Logs
     */
    class Logs{
        const PATH = 'Composants/Framework/Systems/Ressources/Views/Logs/';

        public function logAction(Dic $dic){
            $gets = $dic->open('get');

            if(empty($gets->get('get', 0))){
                return $dic->load('view')->viewDev('logs_no_choice.html.twig', self::PATH);
            }
            else{
                return $dic->load('view')->viewDev('logs_choice.html.twig', self::PATH, [
                    'file' => nl2br(file_get_contents('Composants/Logs/'.$gets->get('get', 0).'.log'))
                ]);
            }
        }
    }