<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Controller;
    use Composants\Framework\CreateLog\CreateErrorLog;

    class GetChargementFail extends Controller{
        public function __construct(){
            new CreateErrorLog('URL incorrecte');

            return $this->view('GetIncorrect.html.twig', 'Exception');
        }
    }