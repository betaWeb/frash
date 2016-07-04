<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class TwigChargementTemplateFail
     * @package Composants\Framework\Exception
     */
    class TwigChargementTemplateFail{
        /**
         * TwigChargementTemplateFail constructor.
         * @param string $templ
         */
        public function __construct($templ){
            new CreateErrorLog('Template TWIG Not Found');

            header('HTTP/1.0 404 Not Found', true, 404);
            die();
        }
    }