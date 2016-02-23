<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Response\Response;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class TwigChargementTemplateFail
     * @package Composants\Framework\Exception
     */
    class TwigChargementTemplateFail{
        /**
         * TwigChargementTemplateFail constructor.
         * @param $templ
         */
        public function __construct($templ){
            new CreateErrorLog('Template TWIG Not Found');
            return new Response('TplNotFound.html.twig', 'Exception', [ 'tpl' => $templ ]);
        }
    }