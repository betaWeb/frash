<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\CreateLog\CreateErrorLog;

    class GetChargementFail{
        public function __construct(){
            new CreateErrorLog('URL incorrecte');

            header('HTTP/1.0 404 Not Found', true, 404);
            die();
        }
    }